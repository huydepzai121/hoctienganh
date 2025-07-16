<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\DiscussionCategory;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiscussionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
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

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->open(); // Default to open discussions
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

        $discussions = $query->paginate(15);

        $categories = DiscussionCategory::active()->ordered()->get();
        $courses = Course::published()->orderBy('title')->get();

        return view('discussions.index', compact('discussions', 'categories', 'courses'));
    }

    /**
     * Show the form for creating a new discussion.
     */
    public function create(Request $request)
    {
        $categories = DiscussionCategory::active()->ordered()->get();
        $courses = Course::published()->orderBy('title')->get();
        $selectedCourse = $request->get('course_id');

        return view('discussions.create', compact('categories', 'courses', 'selectedCourse'));
    }

    /**
     * Store a newly created discussion.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'discussion_category_id' => 'required|exists:discussion_categories,id',
            'course_id' => 'nullable|exists:courses,id'
        ]);

        $discussion = Discussion::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'user_id' => auth()->id(),
            'discussion_category_id' => $request->discussion_category_id,
            'course_id' => $request->course_id,
        ]);

        return redirect()->route('discussions.show', $discussion->slug)
                        ->with('success', 'Thảo luận đã được tạo thành công!');
    }

    /**
     * Display the specified discussion.
     */
    public function show(Discussion $discussion)
    {
        // Increment views
        $discussion->incrementViews();

        // Load relationships
        $discussion->load([
            'user',
            'category',
            'course',
            'replies' => function ($query) {
                $query->with(['user', 'children.user'])
                      ->whereNull('parent_id')
                      ->orderBy('is_best_answer', 'desc')
                      ->orderBy('votes_count', 'desc')
                      ->orderBy('created_at');
            }
        ]);

        return view('discussions.show', compact('discussion'));
    }

    /**
     * Show the form for editing the discussion.
     */
    public function edit(Discussion $discussion)
    {
        $this->authorize('update', $discussion);

        $categories = DiscussionCategory::active()->ordered()->get();
        $courses = Course::published()->orderBy('title')->get();

        return view('discussions.edit', compact('discussion', 'categories', 'courses'));
    }

    /**
     * Update the specified discussion.
     */
    public function update(Request $request, Discussion $discussion)
    {
        $this->authorize('update', $discussion);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'discussion_category_id' => 'required|exists:discussion_categories,id',
            'course_id' => 'nullable|exists:courses,id'
        ]);

        $discussion->update([
            'title' => $request->title,
            'content' => $request->content,
            'discussion_category_id' => $request->discussion_category_id,
            'course_id' => $request->course_id,
        ]);

        return redirect()->route('discussions.show', $discussion->slug)
                        ->with('success', 'Thảo luận đã được cập nhật!');
    }

    /**
     * Remove the specified discussion.
     */
    public function destroy(Discussion $discussion)
    {
        $this->authorize('delete', $discussion);

        $discussion->delete();

        return redirect()->route('discussions.index')
                        ->with('success', 'Thảo luận đã được xóa!');
    }
}
