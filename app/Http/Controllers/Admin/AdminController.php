<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_courses' => Course::count(),
            'total_categories' => Category::count(),
            'total_enrollments' => Enrollment::count(),
            'active_students' => User::whereHas('role', function($q) {
                $q->where('name', 'student');
            })->count(),
            'published_courses' => Course::where('is_published', true)->count(),
            'total_quizzes' => Quiz::count(),
            'total_quiz_attempts' => QuizAttempt::count(),
        ];

        $recent_enrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->take(10)
            ->get();

        $popular_courses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard-adminlte', compact('stats', 'recent_enrollments', 'popular_courses'));
    }
}
