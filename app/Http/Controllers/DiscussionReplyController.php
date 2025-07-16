<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;

class DiscussionReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new reply.
     */
    public function store(Request $request, Discussion $discussion)
    {
        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:discussion_replies,id'
        ]);

        $reply = DiscussionReply::create([
            'content' => $request->content,
            'discussion_id' => $discussion->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('discussions.show', $discussion->slug)
                        ->with('success', 'Câu trả lời đã được thêm!')
                        ->fragment('reply-' . $reply->id);
    }

    /**
     * Update a reply.
     */
    public function update(Request $request, DiscussionReply $reply)
    {
        $this->authorize('update', $reply);

        $request->validate([
            'content' => 'required|string'
        ]);

        $reply->update([
            'content' => $request->content
        ]);

        return redirect()->route('discussions.show', $reply->discussion->slug)
                        ->with('success', 'Câu trả lời đã được cập nhật!')
                        ->fragment('reply-' . $reply->id);
    }

    /**
     * Delete a reply.
     */
    public function destroy(DiscussionReply $reply)
    {
        $this->authorize('delete', $reply);

        $discussionSlug = $reply->discussion->slug;
        $reply->delete();

        return redirect()->route('discussions.show', $discussionSlug)
                        ->with('success', 'Câu trả lời đã được xóa!');
    }

    /**
     * Mark reply as best answer.
     */
    public function markAsBestAnswer(DiscussionReply $reply)
    {
        $discussion = $reply->discussion;

        // Only discussion author can mark best answer
        if (auth()->id() !== $discussion->user_id) {
            abort(403, 'Chỉ tác giả thảo luận mới có thể chọn câu trả lời hay nhất.');
        }

        $reply->markAsBestAnswer();

        return redirect()->route('discussions.show', $discussion->slug)
                        ->with('success', 'Đã đánh dấu là câu trả lời hay nhất!')
                        ->fragment('reply-' . $reply->id);
    }

    /**
     * Mark reply as solution.
     */
    public function markAsSolution(DiscussionReply $reply)
    {
        $discussion = $reply->discussion;

        // Only discussion author or admin can mark as solution
        if (auth()->id() !== $discussion->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Không có quyền thực hiện hành động này.');
        }

        $reply->markAsSolution();

        return redirect()->route('discussions.show', $discussion->slug)
                        ->with('success', 'Đã đánh dấu là giải pháp!')
                        ->fragment('reply-' . $reply->id);
    }
}
