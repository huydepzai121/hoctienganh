<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\DiscussionCategory;
use App\Models\Course;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of discussions.
     */
    public function index(Request $request)
    {
        $query = Discussion::with(['user', 'category', 'course', 'lastReplyUser'])
                          ->withCount('replies');

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by course
        if ($request->filled('course')) {
            $query->byCourse($request->course);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderByDesc('votes_count')->orderByDesc('replies_count');
                break;
            case 'most_replies':
                $query->orderByDesc('replies_count');
                break;
            case 'oldest':
                $query->orderBy('created_at');
                break;
            default: // latest
                $query->orderByDesc('is_pinned')
                      ->orderByDesc('last_activity_at');
        }

        $discussions = $query->paginate(20);

        $categories = DiscussionCategory::active()->ordered()->get();
        $courses = Course::published()->orderBy('title')->get();

        return view('admin.discussions.index', compact('discussions', 'categories', 'courses'));
    }

    /**
     * Display the specified discussion.
     */
    public function show(Discussion $discussion)
    {
        $discussion->load([
            'user',
            'category',
            'course',
            'replies' => function ($query) {
                $query->with(['user', 'children.user'])
                      ->orderBy('created_at');
            }
        ]);

        return view('admin.discussions.show', compact('discussion'));
    }

    /**
     * Update discussion status.
     */
    public function updateStatus(Request $request, Discussion $discussion)
    {
        $request->validate([
            'status' => 'required|in:open,closed,solved'
        ]);

        $discussion->update(['status' => $request->status]);

        return redirect()->route('admin.discussions.show', $discussion)
                        ->with('success', 'Trạng thái thảo luận đã được cập nhật!');
    }

    /**
     * Toggle pin status.
     */
    public function togglePin(Discussion $discussion)
    {
        $discussion->update(['is_pinned' => !$discussion->is_pinned]);

        $status = $discussion->is_pinned ? 'ghim' : 'bỏ ghim';

        return redirect()->route('admin.discussions.index')
                        ->with('success', "Thảo luận đã được {$status}!");
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Discussion $discussion)
    {
        $discussion->update(['is_featured' => !$discussion->is_featured]);

        $status = $discussion->is_featured ? 'nổi bật' : 'bỏ nổi bật';

        return redirect()->route('admin.discussions.index')
                        ->with('success', "Thảo luận đã được đánh dấu {$status}!");
    }

    /**
     * Remove the specified discussion.
     */
    public function destroy(Discussion $discussion)
    {
        $discussion->delete();

        return redirect()->route('admin.discussions.index')
                        ->with('success', 'Thảo luận đã được xóa!');
    }

    /**
     * Bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,close,open,pin,unpin,feature,unfeature',
            'discussion_ids' => 'required|array',
            'discussion_ids.*' => 'exists:discussions,id'
        ]);

        $discussions = Discussion::whereIn('id', $request->discussion_ids);

        switch ($request->action) {
            case 'delete':
                $discussions->delete();
                $message = 'Các thảo luận đã được xóa!';
                break;
            case 'close':
                $discussions->update(['status' => 'closed']);
                $message = 'Các thảo luận đã được đóng!';
                break;
            case 'open':
                $discussions->update(['status' => 'open']);
                $message = 'Các thảo luận đã được mở!';
                break;
            case 'pin':
                $discussions->update(['is_pinned' => true]);
                $message = 'Các thảo luận đã được ghim!';
                break;
            case 'unpin':
                $discussions->update(['is_pinned' => false]);
                $message = 'Các thảo luận đã được bỏ ghim!';
                break;
            case 'feature':
                $discussions->update(['is_featured' => true]);
                $message = 'Các thảo luận đã được đánh dấu nổi bật!';
                break;
            case 'unfeature':
                $discussions->update(['is_featured' => false]);
                $message = 'Các thảo luận đã được bỏ đánh dấu nổi bật!';
                break;
        }

        return redirect()->route('admin.discussions.index')
                        ->with('success', $message);
    }
}
