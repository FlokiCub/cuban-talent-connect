<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * Mostrar solicitudes pendientes de candidatos
     */
    public function pendingRequests()
    {
        // Candidatos con perfil pero sin suscripción activa
        $pendingCandidates = User::whereHas('candidateProfile')
            ->whereDoesntHave('subscriptions', function($query) {
                $query->where('is_active', true)
                      ->where('end_date', '>=', now());
            })
            ->with('candidateProfile')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pending-requests', compact('pendingCandidates'));
    }

    /**
     * Mostrar formulario de aprobación de candidato
     */
    public function showApprovalForm(User $candidate)
    {
        $candidate->load(['candidateProfile', 'answers.question']);
        
        if (!$candidate->candidateProfile) {
            abort(404, 'Perfil de candidato no encontrado');
        }

        return view('admin.candidate-approval', compact('candidate'));
    }

    /**
 * Procesar aprobación de candidato
 */
public function approveCandidate(Request $request, User $candidate)
{
    try {
        $validated = $request->validate([
            'subscription_type' => 'required|in:standard,plus,premium',
            'start_date' => 'required|date',
            'months_duration' => 'required|integer|min:1|max:36',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        // Asegurar que los tipos sean correctos
        $monthsDuration = (int) $validated['months_duration'];
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = $startDate->copy()->addMonths($monthsDuration);

        // Verificar que la fecha de fin sea válida
        if ($endDate->lessThan($startDate)) {
            return back()->with('error', 'La fecha de fin no puede ser anterior a la fecha de inicio')->withInput();
        }

        // Crear suscripción
        Subscription::create([
            'candidate_id' => $candidate->id,
            'type' => $validated['subscription_type'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'months_duration' => $monthsDuration,
            'admin_notes' => $validated['admin_notes'],
            'is_active' => true
        ]);

        return redirect()->route('admin.pending-requests')
                        ->with('success', 'Candidato aprobado exitosamente');

    } catch (\Exception $e) {
        \Log::error('Error al aprobar candidato: ' . $e->getMessage());
        return back()->with('error', 'Error al aprobar el candidato: ' . $e->getMessage())->withInput();
    }
}

    /**
     * Mostrar todos los candidatos activos
     */
    public function activeCandidates()
    {
        $activeCandidates = User::whereHas('candidateProfile')
            ->whereHas('subscriptions', function($query) {
                $query->where('is_active', true)
                      ->where('end_date', '>=', now());
            })
            ->with(['candidateProfile', 'subscriptions' => function($query) {
                $query->where('is_active', true)
                      ->where('end_date', '>=', now());
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.active-candidates', compact('activeCandidates'));
    }

    /**
     * Mostrar historial de suscripciones de un candidato
     */
    public function subscriptionHistory(User $candidate)
    {
        $subscriptions = $candidate->subscriptions()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.subscription-history', compact('candidate', 'subscriptions'));
    }

    /**
     * Desactivar suscripción
     */
    public function deactivateSubscription(Subscription $subscription)
    {
        $subscription->update(['is_active' => false]);

        return back()->with('success', 'Suscripción desactivada exitosamente');
    }
}