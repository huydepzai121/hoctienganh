<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new review
     */
    public function store(Request $request, Course $course)
    {
        // Check if user is enrolled in the course
        if (!$course->students()->where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'Bạn cần đăng ký khóa học để có thể đánh giá.');
        }

        // Check if user already reviewed this course
        if ($course->hasUserReviewed(Auth::user())) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá khóa học này rồi.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false // Requires admin approval
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá! Đánh giá của bạn sẽ được hiển thị sau khi được duyệt.');
    }

    /**
     * Update an existing review
     */
    public function update(Request $request, Review $review)
    {
        // Check if user owns this review and can edit it
        if (!$review->canBeEditedBy(Auth::user())) {
            return redirect()->back()->with('error', 'Bạn không thể chỉnh sửa đánh giá này.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false // Requires re-approval after edit
        ]);

        return redirect()->back()->with('success', 'Đánh giá đã được cập nhật và sẽ được duyệt lại.');
    }

    /**
     * Delete a review
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không thể xóa đánh giá này.');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Đánh giá đã được xóa.');
    }
}
