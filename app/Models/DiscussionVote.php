<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'votable_id',
        'votable_type',
        'type'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($vote) {
            $vote->updateVotableCount();
        });

        static::updated(function ($vote) {
            $vote->updateVotableCount();
        });

        static::deleted(function ($vote) {
            $vote->updateVotableCount();
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votable()
    {
        return $this->morphTo();
    }

    // Methods
    public function updateVotableCount()
    {
        $votable = $this->votable;
        if ($votable) {
            $upVotes = $votable->votes()->where('type', 'up')->count();
            $downVotes = $votable->votes()->where('type', 'down')->count();
            $votable->update(['votes_count' => $upVotes - $downVotes]);
        }
    }

    // Scopes
    public function scopeUpVotes($query)
    {
        return $query->where('type', 'up');
    }

    public function scopeDownVotes($query)
    {
        return $query->where('type', 'down');
    }
}
