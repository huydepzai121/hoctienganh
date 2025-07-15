<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Quiz $quiz)
    {
        // Check if user is enrolled in the course
        $user = Auth::user();
        $enrollment = $user->enrollments()->where('course_id', $quiz->lesson->course_id)->first();

        if (!$enrollment) {
            return redirect()->route('courses.show', $quiz->lesson->course->slug)
                           ->with('error', 'Bạn cần đăng ký khóa học để làm bài quiz.');
        }

        // Get user's previous attempts
        $attempts = $quiz->attempts()->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $canAttempt = $attempts->count() < $quiz->max_attempts;
        $bestScore = $attempts->map(function($attempt) {
            return $attempt->score_percentage;
        })->max() ?? 0;

        return view('quizzes.show', compact('quiz', 'attempts', 'canAttempt', 'bestScore'));
    }

    public function start(Quiz $quiz)
    {
        $user = Auth::user();

        // Check if user can attempt
        $attemptCount = $quiz->attempts()->where('user_id', $user->id)->count();
        if ($attemptCount >= $quiz->max_attempts) {
            return redirect()->route('quizzes.show', $quiz)
                           ->with('error', 'Bạn đã hết lượt làm bài quiz này.');
        }

        // Create new attempt
        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'answers' => [],
            'total_points' => $quiz->questions->sum('points'),
            'started_at' => now(),
        ]);

        return redirect()->route('quizzes.take', $attempt);
    }

    public function take(QuizAttempt $attempt)
    {
        // Check if attempt belongs to current user
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if already completed
        if ($attempt->completed_at) {
            return redirect()->route('quizzes.result', $attempt);
        }

        $quiz = $attempt->quiz;
        $questions = $quiz->questions()->orderBy('order')->get();

        return view('quizzes.take', compact('attempt', 'quiz', 'questions'));
    }

    public function submit(Request $request, QuizAttempt $attempt)
    {
        // Check if attempt belongs to current user
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if already completed
        if ($attempt->completed_at) {
            return redirect()->route('quizzes.result', $attempt);
        }

        $answers = $request->input('answers', []);
        $score = 0;
        $quiz = $attempt->quiz;

        // Calculate score
        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? '';
            if ($question->isCorrectAnswer($userAnswer)) {
                $score += $question->points;
            }
        }

        // Update attempt
        $attempt->update([
            'answers' => $answers,
            'score' => $score,
            'completed_at' => now(),
            'time_taken' => now()->diffInSeconds($attempt->started_at),
            'is_passed' => ($score / $attempt->total_points * 100) >= $quiz->passing_score,
        ]);

        return redirect()->route('quizzes.result', $attempt);
    }

    public function result(QuizAttempt $attempt)
    {
        // Check if attempt belongs to current user
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        $quiz = $attempt->quiz;
        $questions = $quiz->questions()->orderBy('order')->get();

        return view('quizzes.result', compact('attempt', 'quiz', 'questions'));
    }
}
