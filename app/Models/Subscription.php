<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'type',
        'start_date',
        'end_date',
        'months_duration',
        'is_active',
        'admin_notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    // Verificar si la suscripción está activa
    public function isActive()
    {
        return $this->is_active && $this->end_date >= now();
    }

    // Obtener suscripción activa de un candidato
    public static function getActiveSubscription($candidateId)
    {
        return static::where('candidate_id', $candidateId)
                    ->where('is_active', true)
                    ->where('end_date', '>=', now())
                    ->first();
    }
}