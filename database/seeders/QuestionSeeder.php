<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            [
                'question_text' => '¿Cuántos años de experiencia tienes en la industria hotelera?',
                'question_type' => 'select',
                'options' => ['Ninguna', 'Menos de 1 año', '1-2 años', '3-5 años', 'Más de 5 años'],
                'is_required' => true,
                'order' => 1,
            ],
            [
                'question_text' => '¿Qué turnos prefieres trabajar?',
                'question_type' => 'select', 
                'options' => ['Solo mañana', 'Solo tarde', 'Solo noche', 'Rotativos', 'Cualquiera'],
                'is_required' => true,
                'order' => 2,
            ],
            [
                'question_text' => '¿Tienes disponibilidad para trabajar fines de semana?',
                'question_type' => 'select',
                'options' => ['Sí', 'No', 'Ocasionalmente'],
                'is_required' => true,
                'order' => 3,
            ],
            [
                'question_text' => '¿Qué idiomas hablas y a qué nivel?',
                'question_type' => 'text',
                'options' => null,
                'is_required' => true,
                'order' => 4,
            ],
            [
                'question_text' => '¿Por qué quieres trabajar en la industria hotelera?',
                'question_type' => 'text',
                'options' => null,
                'is_required' => false,
                'order' => 5,
            ],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}