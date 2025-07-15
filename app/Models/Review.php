<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'rating',
        'comment',
        'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer'
    ];

    /**
     * Get the user who wrote the review
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course being reviewed
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope for approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for pending reviews
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Get formatted rating with stars
     */
    public function getStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    /**
     * Get rating percentage for display
     */
    public function getRatingPercentageAttribute()
    {
        return ($this->rating / 5) * 100;
    }

    /**
     * Check if review can be edited by user
     */
    public function canBeEditedBy(User $user): bool
    {
        return $this->user_id === $user->id && $this->created_at->diffInHours() < 24;
    }

    /**
     * Get excerpt of comment
     */
    public function getCommentExcerptAttribute($length = 100)
    {
        if (!$this->comment) return '';
        return strlen($this->comment) > $length
            ? substr($this->comment, 0, $length) . '...'
            : $this->comment;
    }
}
