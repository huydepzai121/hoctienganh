<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::with(['lesson.course', 'questions'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('admin.quizzes.index-adminlte', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lessons = Lesson::with('course')->get();
        return view('admin.quizzes.create-adminlte', compact('lessons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id' => 'required|exists:lessons,id',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.answers' => 'required|array|min:2',
            'questions.*.answers.*.answer' => 'required|string',
            'questions.*.answers.*.is_correct' => 'required|boolean',
        ]);

        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'lesson_id' => $request->lesson_id,
            'time_limit' => $request->time_limit,
            'passing_score' => $request->passing_score,
        ]);

        foreach ($request->questions as $questionData) {
            $question = $quiz->questions()->create([
                'question' => $questionData['question'],
                'question_type' => 'multiple_choice',
            ]);

            foreach ($questionData['answers'] as $answerData) {
                $question->answers()->create([
                    'answer' => $answerData['answer'],
                    'is_correct' => $answerData['is_correct'],
                ]);
            }
        }

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        $quiz->load(['lesson.course', 'questions', 'attempts.user']);
        return view('admin.quizzes.show-adminlte', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        $lessons = Lesson::with('course')->get();
        $quiz->load(['questions.answers']);
        return view('admin.quizzes.edit-adminlte', compact('quiz', 'lessons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id' => 'required|exists:lessons,id',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.answers' => 'required|array|min:2',
            'questions.*.answers.*.answer' => 'required|string',
            'questions.*.answers.*.is_correct' => 'required|boolean',
        ]);

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'lesson_id' => $request->lesson_id,
            'time_limit' => $request->time_limit,
            'passing_score' => $request->passing_score,
        ]);

        // Delete existing questions and answers
        $quiz->questions()->delete();

        // Create new questions and answers
        foreach ($request->questions as $questionData) {
            $question = $quiz->questions()->create([
                'question' => $questionData['question'],
                'question_type' => 'multiple_choice',
            ]);

            foreach ($questionData['answers'] as $answerData) {
                $question->answers()->create([
                    'answer' => $answerData['answer'],
                    'is_correct' => $answerData['is_correct'],
                ]);
            }
        }

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz đã được xóa thành công!');
    }
}
