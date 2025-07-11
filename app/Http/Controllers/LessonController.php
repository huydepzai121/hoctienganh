<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display the specified lesson.
     */
    public function show(Lesson $lesson)
    {
        // Check if user is enrolled in the course
        $course = $lesson->course;

        if (!auth()->user()->enrollments()->where('course_id', $course->id)->exists()) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Bạn cần đăng ký khóa học để xem bài học này.');
        }

        // Get all lessons in the course for navigation
        $lessons = $course->lessons()
            ->where('is_published', true)
            ->orderBy('order')
            ->get();

        // Find current lesson index
        $currentIndex = $lessons->search(function ($item) use ($lesson) {
            return $item->id === $lesson->id;
        });

        // Get previous and next lessons
        $previousLesson = $currentIndex > 0 ? $lessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $lessons->count() - 1 ? $lessons[$currentIndex + 1] : null;

        return view('lessons.show', compact('lesson', 'course', 'lessons', 'previousLesson', 'nextLesson'));
    }

    /**
     * Mark lesson as completed
     */
    public function complete(Lesson $lesson)
    {
        $user = auth()->user();
        $course = $lesson->course;

        // Check if user is enrolled
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();

        if (!$enrollment) {
            return response()->json(['error' => 'Bạn chưa đăng ký khóa học này.'], 403);
        }

        // Mark lesson as completed
        $user->completedLessons()->syncWithoutDetaching([$lesson->id => [
            'completed_at' => now()
        ]]);

        // Update progress
        $totalLessons = $course->lessons()->where('is_published', true)->count();
        $completedLessons = $user->completedLessons()
            ->whereIn('lesson_id', $course->lessons()->pluck('id'))
            ->count();

        $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        $enrollment->update(['progress' => $progress]);

        return response()->json([
            'success' => true,
            'progress' => $progress,
            'message' => 'Bài học đã được đánh dấu hoàn thành!'
        ]);
    }
}
