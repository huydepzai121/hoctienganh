<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['category', 'instructor'])
            ->where('is_published', true);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Filter by price
        if ($request->filled('price')) {
            if ($request->price === 'free') {
                $query->where('price', 0);
            } elseif ($request->price === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $courses = $query->latest()->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('courses.index', compact('courses', 'categories'));
    }

    public function show(Course $course)
    {
        if (!$course->is_published) {
            abort(404);
        }

        $course->load(['category', 'instructor', 'lessons' => function($query) {
            $query->where('is_published', true)->orderBy('order');
        }]);

        $isEnrolled = false;
        $enrollment = null;

        if (auth()->check()) {
            $enrollment = Enrollment::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->first();
            $isEnrolled = $enrollment !== null;
        }

        $relatedCourses = Course::where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->where('is_published', true)
            ->take(3)
            ->get();

        return view('courses.show', compact('course', 'isEnrolled', 'enrollment', 'relatedCourses'));
    }

    public function enroll(Request $request, Course $course)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!$course->is_published) {
            return back()->with('error', 'Khóa học này không khả dụng.');
        }

        $existingEnrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return back()->with('info', 'Bạn đã đăng ký khóa học này rồi.');
        }

        Enrollment::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'enrolled_at' => now(),
        ]);

        return back()->with('success', 'Đăng ký khóa học thành công!');
    }

    public function myCourses()
    {
        $enrollments = Enrollment::with(['course.category', 'course.instructor'])
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('courses.my-courses', compact('enrollments'));
    }
}
