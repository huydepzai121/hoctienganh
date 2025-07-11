<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::with('course')->latest()->paginate(10);
        return view('admin.lessons.index-adminlte', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::where('is_published', true)->get();
        return view('admin.lessons.create-adminlte', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'duration' => 'required|integer|min:1',
            'order' => 'required|integer|min:1',
            'video_url' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        Lesson::create($data);

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Bài học đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        $lesson->load('course');
        return view('admin.lessons.show-adminlte', compact('lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        $courses = Course::where('is_published', true)->get();
        return view('admin.lessons.edit-adminlte', compact('lesson', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'duration' => 'required|integer|min:1',
            'order' => 'required|integer|min:1',
            'video_url' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $lesson->update($data);

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Bài học đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Bài học đã được xóa thành công!');
    }
}
