<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;
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
            })->where('is_active', true)->count(),
            'published_courses' => Course::where('is_published', true)->count(),
        ];

        $recent_enrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->take(10)
            ->get();

        $popular_courses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard-pure', compact('stats', 'recent_enrollments', 'popular_courses'));
    }
}
