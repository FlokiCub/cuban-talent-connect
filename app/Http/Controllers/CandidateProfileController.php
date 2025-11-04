<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CandidateProfileController extends Controller
{
    public function show(User $candidate)
    {
        // Cargar relaciones necesarias - asumimos que es candidato
        $candidate->load(['candidateProfile', 'answers.question']);

        // Verificar que existe el perfil del candidato
        if (!$candidate->candidateProfile) {
            abort(404, 'Perfil de candidato no encontrado');
        }

        return view('candidate.profile-show', compact('candidate'));
    }
}