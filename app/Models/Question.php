<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'question_type',
        'options',
        'is_required',
        'order', 
        'is_active'
    ];

    protected $casts = [
        'options' => 'array', 
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function answers()
    {
        return $this->hasMany(CandidateAnswer::class);
    }
}