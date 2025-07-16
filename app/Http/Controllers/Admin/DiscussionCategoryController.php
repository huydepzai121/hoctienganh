<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscussionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiscussionCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of discussion categories.
     */
    public function index()
    {
        $categories = DiscussionCategory::withCount('discussions')
                                      ->ordered()
                                      ->paginate(15);

        return view('admin.discussion-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.discussion-categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        DiscussionCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'color' => $request->color,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.discussion-categories.index')
                        ->with('success', 'Danh mục thảo luận đã được tạo thành công!');
    }

    /**
     * Display the specified category.
     */
    public function show(DiscussionCategory $discussionCategory)
    {
        $discussionCategory->load(['discussions' => function ($query) {
            $query->with(['user', 'course'])
                  ->withCount('replies')
                  ->latest('last_activity_at');
        }]);

        return view('admin.discussion-categories.show', compact('discussionCategory'));
    }

    /**
     * Show the form for editing the category.
     */
    public function edit(DiscussionCategory $discussionCategory)
    {
        return view('admin.discussion-categories.edit', compact('discussionCategory'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, DiscussionCategory $discussionCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $discussionCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'color' => $request->color,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.discussion-categories.index')
                        ->with('success', 'Danh mục thảo luận đã được cập nhật!');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(DiscussionCategory $discussionCategory)
    {
        if ($discussionCategory->discussions()->count() > 0) {
            return redirect()->route('admin.discussion-categories.index')
                           ->with('error', 'Không thể xóa danh mục có chứa thảo luận!');
        }

        $discussionCategory->delete();

        return redirect()->route('admin.discussion-categories.index')
                        ->with('success', 'Danh mục thảo luận đã được xóa!');
    }

    /**
     * Toggle category status.
     */
    public function toggleStatus(DiscussionCategory $discussionCategory)
    {
        $discussionCategory->update([
            'is_active' => !$discussionCategory->is_active
        ]);

        $status = $discussionCategory->is_active ? 'kích hoạt' : 'vô hiệu hóa';

        return redirect()->route('admin.discussion-categories.index')
                        ->with('success', "Danh mục đã được {$status}!");
    }
}
