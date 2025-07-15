<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Course;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of reviews
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'course']);

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'approved') {
                $query->approved();
            } elseif ($request->status === 'pending') {
                $query->pending();
            }
        }

        // Filter by course
        if ($request->has('course_id') && $request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('course', function($courseQuery) use ($search) {
                      $courseQuery->where('title', 'like', "%{$search}%");
                  });
            });
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(20);
        $courses = Course::published()->get();

        return view('admin.reviews.index-adminlte', compact('reviews', 'courses'));
    }

    /**
     * Display the specified review
     */
    public function show(Review $review)
    {
        $review->load(['user', 'course']);
        return view('admin.reviews.show-adminlte', compact('review'));
    }

    /**
     * Approve a review
     */
    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'Đánh giá đã được duyệt.');
    }

    /**
     * Reject/Unapprove a review
     */
    public function reject(Review $review)
    {
        $review->update(['is_approved' => false]);
        return redirect()->back()->with('success', 'Đánh giá đã bị từ chối.');
    }

    /**
     * Bulk approve reviews
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);

        Review::whereIn('id', $request->review_ids)->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Đã duyệt ' . count($request->review_ids) . ' đánh giá.');
    }

    /**
     * Bulk reject reviews
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);

        Review::whereIn('id', $request->review_ids)->update(['is_approved' => false]);

        return redirect()->back()->with('success', 'Đã từ chối ' . count($request->review_ids) . ' đánh giá.');
    }

    /**
     * Remove the specified review
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Đánh giá đã được xóa.');
    }

    /**
     * Bulk delete reviews
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);

        Review::whereIn('id', $request->review_ids)->delete();

        return redirect()->back()->with('success', 'Đã xóa ' . count($request->review_ids) . ' đánh giá.');
    }
}
