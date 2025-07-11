<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'answers',
        'score',
        'total_points',
        'is_passed',
        'started_at',
        'completed_at',
        'time_taken',
    ];

    protected $casts = [
        'answers' => 'array',
        'is_passed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function getScorePercentageAttribute()
    {
        return $this->total_points > 0 ? round(($this->score / $this->total_points) * 100, 2) : 0;
    }

    public function getDurationAttribute()
    {
        if ($this->started_at && $this->completed_at) {
            return $this->started_at->diffInSeconds($this->completed_at);
        }
        return $this->time_taken;
    }

    public function getFormattedDurationAttribute()
    {
        $seconds = $this->duration;
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        return sprintf('%02d:%02d', $minutes, $remainingSeconds);
    }
}
