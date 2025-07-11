<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'summary',
        'video_url',
        'audio_url',
        'attachments',
        'duration_minutes',
        'order',
        'is_published',
        'is_free',
        'course_id',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_published' => 'boolean',
        'is_free' => 'boolean',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function completedUsers()
    {
        return $this->belongsToMany(User::class, 'lesson_user')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Helper methods
    public function isCompletedBy($userId)
    {
        return $this->userProgress()
            ->where('user_id', $userId)
            ->where('is_completed', true)
            ->exists();
    }
}
