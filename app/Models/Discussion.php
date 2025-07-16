<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'discussion_category_id',
        'course_id',
        'status',
        'is_pinned',
        'is_featured',
        'views_count',
        'replies_count',
        'votes_count',
        'last_activity_at',
        'last_reply_user_id'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'replies_count' => 'integer',
        'votes_count' => 'integer',
        'last_activity_at' => 'datetime'
    ];

    // Automatically generate slug when creating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($discussion) {
            if (empty($discussion->slug)) {
                $discussion->slug = Str::slug($discussion->title);
            }
            $discussion->last_activity_at = now();
        });

        static::updating(function ($discussion) {
            if ($discussion->isDirty('title') && empty($discussion->slug)) {
                $discussion->slug = Str::slug($discussion->title);
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(DiscussionCategory::class, 'discussion_category_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function replies()
    {
        return $this->hasMany(DiscussionReply::class);
    }

    public function lastReplyUser()
    {
        return $this->belongsTo(User::class, 'last_reply_user_id');
    }

    public function votes()
    {
        return $this->morphMany(DiscussionVote::class, 'votable');
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('discussion_category_id', $categoryId);
    }

    public function scopeByCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function updateLastActivity($userId = null)
    {
        $this->update([
            'last_activity_at' => now(),
            'last_reply_user_id' => $userId
        ]);
    }

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
}
