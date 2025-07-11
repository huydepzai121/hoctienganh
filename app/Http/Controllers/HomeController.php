<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featured_courses = Course::with(['category', 'instructor'])
            ->where('is_published', true)
            ->where('is_featured', true)
            ->take(6)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount(['courses' => function($query) {
                $query->where('is_published', true);
            }])
            ->take(6)
            ->get();

        $latest_courses = Course::with(['category', 'instructor'])
            ->where('is_published', true)
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('featured_courses', 'categories', 'latest_courses'));
    }
}
