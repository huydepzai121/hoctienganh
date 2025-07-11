<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with(['category', 'instructor'])
            ->latest()
            ->paginate(10);

        return view('admin.courses.index-adminlte', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.courses.create-adminlte', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'level' => 'required|in:beginner,intermediate,advanced',
            'image' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['instructor_id'] = auth()->id();

        Course::create($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Khóa học đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['category', 'instructor', 'lessons']);
        return view('admin.courses.show-adminlte', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.courses.edit-adminlte', compact('course', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'level' => 'required|in:beginner,intermediate,advanced',
            'image' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $course->update($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Khóa học đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Khóa học đã được xóa thành công!');
    }
}
