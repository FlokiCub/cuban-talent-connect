<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean'
        ];
    }

    // Relación con el perfil de candidato
    public function candidateProfile()
    {
        return $this->hasOne(CandidateProfile::class);
    }

    // Relación con las respuestas
    public function answers()
    {
        return $this->hasMany(CandidateAnswer::class, 'candidate_id');
    }

    // Relación con suscripciones
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'candidate_id');
    }

    // Obtener suscripción activa
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class, 'candidate_id')
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->latest();
    }

    // Método para obtener iniciales del nombre
    public function initials()
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        if (count($names) >= 2) {
            $initials = strtoupper(substr($names[0], 0, 1) . substr($names[1], 0, 1));
        } else {
            $initials = strtoupper(substr($this->name, 0, 2));
        }
        
        return $initials;
    }

    // Métodos para verificar roles
    public function isCandidate()
    {
        return $this->role === 'candidate';
    }

    public function isInterviewer()
    {
        return $this->role === 'interviewer';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Verificar si el candidato está activo (tiene suscripción activa y perfil)
    public function isActiveCandidate()
    {
        return $this->isCandidate() && 
               $this->candidateProfile && 
               $this->activeSubscription();
    }

    // Scope para candidatos activos
    public function scopeActiveCandidates($query)
    {
        return $query->where('role', 'candidate')
                    ->where('is_active', true)
                    ->whereHas('candidateProfile')
                    ->whereHas('subscriptions', function($q) {
                        $q->where('is_active', true)
                          ->where('end_date', '>=', now());
                    });
    }

    // Scope para candidatos pendientes (con perfil pero sin suscripción activa)
    public function scopePendingCandidates($query)
    {
        return $query->where('role', 'candidate')
                    ->where('is_active', true)
                    ->whereHas('candidateProfile')
                    ->whereDoesntHave('subscriptions', function($q) {
                        $q->where('is_active', true)
                          ->where('end_date', '>=', now());
                    });
    }
}