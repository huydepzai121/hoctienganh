<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'discussion_id',
        'user_id',
        'parent_id',
        'is_solution',
        'is_best_answer',
        'votes_count'
    ];

    protected $casts = [
        'is_solution' => 'boolean',
        'is_best_answer' => 'boolean',
        'votes_count' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            // Update discussion replies count and last activity
            $discussion = $reply->discussion;
            $discussion->increment('replies_count');
            $discussion->updateLastActivity($reply->user_id);
        });

        static::deleted(function ($reply) {
            // Update discussion replies count
            $reply->discussion->decrement('replies_count');
        });
    }

    // Relationships
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(DiscussionReply::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(DiscussionReply::class, 'parent_id');
    }

    public function votes()
    {
        return $this->morphMany(DiscussionVote::class, 'votable');
    }

    // Scopes
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeSolutions($query)
    {
        return $query->where('is_solution', true);
    }

    public function scopeBestAnswers($query)
    {
        return $query->where('is_best_answer', true);
    }

    // Methods
    public function getVoteScore()
    {
        return $this->votes()->where('type', 'up')->count() -
               $this->votes()->where('type', 'down')->count();
    }

    public function hasUserVoted($userId)
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }

    public function getUserVoteType($userId)
    {
        $vote = $this->votes()->where('user_id', $userId)->first();
        return $vote ? $vote->type : null;
    }

    public function markAsSolution()
    {
        $this->update(['is_solution' => true]);

        // Update discussion status to solved
        $this->discussion->update(['status' => 'solved']);
    }

    public function markAsBestAnswer()
    {
        // Remove best answer from other replies in the same discussion
        $this->discussion->replies()->where('id', '!=', $this->id)
                         ->update(['is_best_answer' => false]);

        $this->update(['is_best_answer' => true]);
    }
}
