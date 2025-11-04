<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        if ($role === 'admin' && !$user->isAdmin()) {
            abort(403, 'No tienes permisos de administrador');
        }

        if ($role === 'interviewer' && !$user->isInterviewer()) {
            abort(403, 'No tienes permisos de entrevistador');
        }

        if ($role === 'candidate' && !$user->isCandidate()) {
            abort(403, 'No tienes permisos de candidato');
        }

        return $next($request);
    }
}