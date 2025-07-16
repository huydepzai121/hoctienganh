<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\DiscussionVote;
use Illuminate\Http\Request;

class DiscussionVoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vote on a discussion.
     */
    public function voteDiscussion(Request $request, Discussion $discussion)
    {
        $request->validate([
            'type' => 'required|in:up,down'
        ]);

        return $this->handleVote($discussion, $request->type);
    }

    /**
     * Vote on a reply.
     */
    public function voteReply(Request $request, DiscussionReply $reply)
    {
        $request->validate([
            'type' => 'required|in:up,down'
        ]);

        return $this->handleVote($reply, $request->type);
    }

    /**
     * Handle voting logic.
     */
    private function handleVote($votable, $type)
    {
        $userId = auth()->id();

        // Check if user already voted
        $existingVote = DiscussionVote::where([
            'user_id' => $userId,
            'votable_id' => $votable->id,
            'votable_type' => get_class($votable)
        ])->first();

        if ($existingVote) {
            if ($existingVote->type === $type) {
                // Same vote type - remove vote
                $existingVote->delete();
                $message = 'Đã hủy bỏ vote';
            } else {
                // Different vote type - update vote
                $existingVote->update(['type' => $type]);
                $message = $type === 'up' ? 'Đã vote up' : 'Đã vote down';
            }
        } else {
            // New vote
            DiscussionVote::create([
                'user_id' => $userId,
                'votable_id' => $votable->id,
                'votable_type' => get_class($votable),
                'type' => $type
            ]);
            $message = $type === 'up' ? 'Đã vote up' : 'Đã vote down';
        }

        // Return JSON response for AJAX
        if (request()->wantsJson()) {
            $votable->refresh();
            return response()->json([
                'success' => true,
                'message' => $message,
                'votes_count' => $votable->getVoteScore(),
                'user_vote' => $votable->getUserVoteType($userId)
            ]);
        }

        // Redirect back for non-AJAX requests
        if ($votable instanceof Discussion) {
            return redirect()->route('discussions.show', $votable->slug)
                           ->with('success', $message);
        } else {
            return redirect()->route('discussions.show', $votable->discussion->slug)
                           ->with('success', $message)
                           ->fragment('reply-' . $votable->id);
        }
    }
}
