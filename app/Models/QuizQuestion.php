<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'type',
        'options',
        'correct_answer',
        'explanation',
        'points',
        'order',
        'image_url',
        'audio_url',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    // Relationships
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Helper methods
    public function getFormattedOptionsAttribute()
    {
        if ($this->type === 'multiple_choice' && $this->options) {
            return collect($this->options)->map(function ($option, $key) {
                return [
                    'key' => $key,
                    'value' => $option,
                ];
            });
        }
        return collect();
    }

    public function isCorrectAnswer($answer)
    {
        return strtolower(trim($answer)) === strtolower(trim($this->correct_answer));
    }
}
