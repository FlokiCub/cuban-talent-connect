<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\CandidateProfile;
use App\Models\CandidateAnswer;
use App\Models\Question;
use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;

class CandidateController extends Controller
{
    public function dashboard()
{
    // Para admin e interviewer: mostrar candidatos con suscripciones activas
    // Para candidate: mostrar información personal
    
    if (auth()->user()->isAdmin() || auth()->user()->isInterviewer()) {
        
        // DEBUG: Verificar datos directamente
        $debugCandidates = User::where('role', 'candidate')
            ->with(['candidateProfile', 'subscriptions'])
            ->get();
            
        \Log::info('DEBUG CANDIDATOS:', [
            'total_candidates' => $debugCandidates->count(),
            'candidates' => $debugCandidates->map(function($candidate) {
                return [
                    'id' => $candidate->id,
                    'name' => $candidate->name,
                    'has_profile' => !is_null($candidate->candidateProfile),
                    'subscriptions_count' => $candidate->subscriptions->count(),
                    'subscriptions' => $candidate->subscriptions->map(function($sub) {
                        return [
                            'id' => $sub->id,
                            'start_date' => $sub->start_date,
                            'end_date' => $sub->end_date,
                            'is_active' => $sub->is_active,
                            'is_active_today' => $sub->is_active && 
                                                $sub->start_date <= now() && 
                                                $sub->end_date >= now()
                        ];
                    })
                ];
            })
        ]);

        // Obtener candidatos con suscripciones activas (VERSIÓN CORREGIDA)
        $recentCandidates = User::where('role', 'candidate')
            ->whereHas('subscriptions', function($query) {
                $today = now()->format('Y-m-d');
                $query->where('is_active', true)
                      ->whereDate('start_date', '<=', $today)
                      ->whereDate('end_date', '>=', $today);
            })
            ->with(['candidateProfile', 'subscriptions' => function($query) {
                $today = now()->format('Y-m-d');
                $query->where('is_active', true)
                      ->whereDate('start_date', '<=', $today)
                      ->whereDate('end_date', '>=', $today);
            }])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Contar total de candidatos con suscripciones activas
        $totalCandidates = User::where('role', 'candidate')
            ->whereHas('subscriptions', function($query) {
                $today = now()->format('Y-m-d');
                $query->where('is_active', true)
                      ->whereDate('start_date', '<=', $today)
                      ->whereDate('end_date', '>=', $today);
            })
            ->count();

        \Log::info('CANDIDATOS ACTIVOS FILTRADOS:', [
            'total_active' => $totalCandidates,
            'recent_count' => $recentCandidates->count(),
            'recent_candidates' => $recentCandidates->pluck('id')
        ]);

    } else {
        // Para candidatos, mostrar información diferente
        $recentCandidates = collect();
        $totalCandidates = 0;
    }

    return view('dashboard', compact('recentCandidates', 'totalCandidates'));
}

    /**
     * Display a listing of the candidates.
     */
    public function index()
    {
        // Solo admin e interviewer pueden ver la lista de candidatos
        if (!auth()->user()->isAdmin() && !auth()->user()->isInterviewer()) {
            abort(403, 'No tienes permisos para ver esta página');
        }

        // Obtener candidatos con suscripciones activas
        $candidates = User::where('role', 'candidate')
            ->whereHas('subscriptions', function($query) {
                $today = Carbon::today();
                $query->where('is_active', true)
                      ->where('start_date', '<=', $today)
                      ->where('end_date', '>=', $today);
            })
            ->with(['candidateProfile', 'subscriptions' => function($query) {
                $today = Carbon::today();
                $query->where('is_active', true)
                      ->where('start_date', '<=', $today)
                      ->where('end_date', '>=', $today);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('candidate.index', compact('candidates'));
    }

    public function showRegistrationForm()
    {
        $user = Auth::user();
        $steps = ['personal', 'professional', 'questions', 'review'];
        $questions = Question::where('is_active', true)->orderBy('order')->get();
        
        Log::info('Mostrando formulario de registro', [
            'user_id' => $user->id,
            'preguntas_count' => $questions->count()
        ]);
        
        return view('candidate.registration', compact('user', 'steps', 'questions'));
    }

   public function storeRegistration(Request $request)
{
    Log::info('=== INICIANDO STORE REGISTRATION ===', [
        'user_id' => Auth::id(),
        'datos_recibidos' => $request->except(['_token', 'cv']) // Excluir token y archivo para el log
    ]);

    // Validación completa
    $validatedData = $request->validate([
        // Información personal
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20', // Este va a candidate_profiles
        'nationality' => 'required|string|in:cubana,extranjera',
        
        // Información profesional
        'birth_date' => 'required|date',
        'education_level' => 'required|string|max:255',
        'work_experience' => 'required|string|min:10',
        'desired_position' => 'required|string|max:255',
        'languages' => 'nullable|string|max:500',
        'skills' => 'nullable|string|max:500',
        'desired_salary' => 'nullable|numeric|min:0',
        'about_me' => 'nullable|string|max:1000',
        'cv' => 'required|file|mimes:pdf,doc,docx|max:10240',
        
        // Respuestas a preguntas
        'answers' => 'required|array',
        'answers.*' => 'required|string|max:1000',
    ]);

    Log::info('✅ Validación pasada correctamente');

    $user = Auth::user();
    
    DB::beginTransaction();
    try {
        Log::info('🔵 Iniciando transacción...');

        // 1. Actualizar SOLO el nombre del usuario (si es necesario)
        Log::info('Actualizando nombre de usuario...', ['user_id' => $user->id]);
        $userUpdate = $user->update([
            'name' => $request->name,
            // NO actualizar phone aquí, va a candidate_profiles
        ]);

        Log::info('Usuario actualizado:', ['success' => $userUpdate]);

        // 2. Procesar archivo CV
        $cvPath = null;
        if ($request->hasFile('cv')) {
            Log::info('Procesando archivo CV...');
            $cvFile = $request->file('cv');
            $cvPath = $cvFile->store('cvs', 'public');
            Log::info('CV guardado:', ['path' => $cvPath]);
        } else {
            Log::warning('No se encontró archivo CV');
        }

        // 3. Procesar arrays (languages y skills)
        $languagesArray = $request->languages ? array_filter(array_map('trim', explode(',', $request->languages))) : null;
        $skillsArray = $request->skills ? array_filter(array_map('trim', explode(',', $request->skills))) : null;

        Log::info('Arrays procesados:', [
            'languages' => $languagesArray,
            'skills' => $skillsArray
        ]);

        // 4. Crear o actualizar perfil de candidato (INCLUYENDO phone aquí)
        $profileData = [
            'user_id' => $user->id,
            'phone' => $request->phone, // <- Teléfono guardado aquí
            'birth_date' => $request->birth_date,
            'nationality' => $request->nationality,
            'education_level' => $request->education_level,
            'work_experience' => $request->work_experience,
            'languages' => $languagesArray,
            'skills' => $skillsArray,
            'desired_position' => $request->desired_position,
            'desired_salary' => $request->desired_salary,
            'about_me' => $request->about_me,
            'cv_path' => $cvPath,
            'is_available' => true,
        ];

        Log::info('Creando/actualizando perfil con datos:', $profileData);

        $candidateProfile = CandidateProfile::updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        Log::info('Perfil de candidato procesado:', [
            'profile_id' => $candidateProfile->id,
            'user_id' => $candidateProfile->user_id,
            'existe' => $candidateProfile->exists,
            'wasRecentlyCreated' => $candidateProfile->wasRecentlyCreated
        ]);

        // 5. Guardar respuestas a las preguntas
        Log::info('Guardando respuestas...', [
            'answers_count' => count($request->answers),
            'answers' => $request->answers
        ]);
        
        $savedAnswers = $this->saveQuestionAnswers($user->id, $request->answers);
        Log::info('Respuestas guardadas:', ['count' => $savedAnswers]);

        DB::commit();
        Log::info('✅ TRANSACCIÓN COMPLETADA EXITOSAMENTE');

        return redirect()->route('candidate.success')
                        ->with('success', '¡Perfil de candidato creado exitosamente!');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('❌ ERROR CRÍTICO EN TRANSACCIÓN:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return back()
                ->with('error', 'Error al guardar la información: ' . $e->getMessage())
                ->withInput();
    }
}

    /**
     * Guarda las respuestas a las preguntas en candidate_answers
     */
    private function saveQuestionAnswers($candidateId, $answers)
    {
        $savedCount = 0;
        
        foreach ($answers as $questionId => $answer) {
            try {
                // Verificar que la pregunta existe
                $question = Question::find($questionId);
                
                if (!$question) {
                    Log::warning('Pregunta no encontrada, saltando:', ['question_id' => $questionId]);
                    continue;
                }

                // Guardar la respuesta
                $candidateAnswer = CandidateAnswer::updateOrCreate(
                    [
                        'candidate_id' => $candidateId,
                        'question_id' => $questionId,
                    ],
                    ['answer' => $answer]
                );

                $savedCount++;
                Log::debug('Respuesta guardada:', [
                    'question_id' => $questionId,
                    'answer_id' => $candidateAnswer->id,
                    'answer_preview' => substr($answer, 0, 50)
                ]);

            } catch (\Exception $e) {
                Log::error('Error guardando respuesta:', [
                    'question_id' => $questionId,
                    'error' => $e->getMessage()
                ]);
            }
        }

        Log::info('Total de respuestas procesadas:', [
            'intentadas' => count($answers),
            'guardadas' => $savedCount
        ]);
        
        return $savedCount;
    }

    public function success()
    {
        return view('candidate.success');
    }
}