<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    use HasFactory;
 protected $fillable = [
        'user_id', 
        'phone', // <- Agregar este campo
        'birth_date',
        'nationality',
        'education_level', 
        'work_experience', 
        'languages', 
        'skills', 
        'desired_position',
        'desired_salary',
        'cv_path', 
        'about_me', 
        'is_available'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_available' => 'boolean',
        'desired_salary' => 'decimal:2',
    ];

    // Accesors para convertir JSON a array
    public function getLanguagesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function getSkillsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    // Mutators para convertir array a JSON
    public function setLanguagesAttribute($value)
    {
        if (is_array($value) && !empty($value)) {
            $this->attributes['languages'] = json_encode($value);
        } else {
            $this->attributes['languages'] = null;
        }
    }

    public function setSkillsAttribute($value)
    {
        if (is_array($value) && !empty($value)) {
            $this->attributes['skills'] = json_encode($value);
        } else {
            $this->attributes['skills'] = null;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
// Verificar si el candidato está activo a través de la suscripción
public function getIsActiveAttribute()
{
    return $this->user->isActiveCandidate();
}
    public function answers()
    {
        return $this->hasMany(CandidateAnswer::class, 'candidate_id', 'user_id');
    }
}