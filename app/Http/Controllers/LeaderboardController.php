<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $courses = Course::with('category')->published()->get();
        $selectedCourse = $request->get('course_id');
        
        // Get top performers overall
        $topPerformers = $this->getTopPerformers($selectedCourse);
        
        // Get recent quiz attempts
        $recentAttempts = $this->getRecentAttempts($selectedCourse);
        
        // Get quiz statistics
        $quizStats = $this->getQuizStats($selectedCourse);
        
        return view('leaderboard.index', compact(
            'courses', 
            'selectedCourse', 
            'topPerformers', 
            'recentAttempts', 
            'quizStats'
        ));
    }

    public function quiz(Quiz $quiz)
    {
        $attempts = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('completed_at', '!=', null)
            ->with('user')
            ->selectRaw('*, CASE WHEN total_points > 0 THEN (score / total_points) * 100 ELSE 0 END as score_percentage')
            ->orderByRaw('CASE WHEN total_points > 0 THEN (score / total_points) * 100 ELSE 0 END DESC')
            ->orderBy('time_taken', 'asc')
            ->get();

        $userRank = null;
        $userBestAttempt = null;

        if (auth()->check()) {
            $userBestAttempt = QuizAttempt::where('quiz_id', $quiz->id)
                ->where('user_id', auth()->id())
                ->where('completed_at', '!=', null)
                ->selectRaw('*, CASE WHEN total_points > 0 THEN (score / total_points) * 100 ELSE 0 END as score_percentage')
                ->orderByRaw('CASE WHEN total_points > 0 THEN (score / total_points) * 100 ELSE 0 END DESC')
                ->orderBy('time_taken', 'asc')
                ->first();

            if ($userBestAttempt) {
                $userRank = $attempts->search(function ($attempt) use ($userBestAttempt) {
                    return $attempt->id === $userBestAttempt->id;
                });
                $userRank = $userRank !== false ? $userRank + 1 : null;
            }
        }

        return view('leaderboard.quiz', compact(
            'quiz', 
            'attempts', 
            'userRank', 
            'userBestAttempt'
        ));
    }

    public function user(User $user)
    {
        $attempts = QuizAttempt::where('user_id', $user->id)
            ->where('completed_at', '!=', null)
            ->with(['quiz.lesson.course'])
            ->orderBy('completed_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_attempts' => $attempts->total(),
            'passed_attempts' => QuizAttempt::where('user_id', $user->id)
                ->where('is_passed', true)
                ->count(),
            'average_score' => QuizAttempt::where('user_id', $user->id)
                ->where('completed_at', '!=', null)
                ->selectRaw('AVG(CASE WHEN total_points > 0 THEN (score / total_points) * 100 ELSE 0 END) as avg_score')
                ->value('avg_score'),
            'best_score' => QuizAttempt::where('user_id', $user->id)
                ->where('completed_at', '!=', null)
                ->selectRaw('MAX(CASE WHEN total_points > 0 THEN (score / total_points) * 100 ELSE 0 END) as max_score')
                ->value('max_score'),
            'total_time' => QuizAttempt::where('user_id', $user->id)
                ->where('completed_at', '!=', null)
                ->sum('time_taken')
        ];

        return view('leaderboard.user', compact('user', 'attempts', 'stats'));
    }

    private function getTopPerformers($courseId = null)
    {
        $query = User::select([
            'users.id',
            'users.name',
            'users.email',
            'users.avatar',
            DB::raw('COUNT(quiz_attempts.id) as total_attempts'),
            DB::raw('COUNT(CASE WHEN quiz_attempts.is_passed = 1 THEN 1 END) as passed_attempts'),
            DB::raw('AVG(CASE WHEN quiz_attempts.total_points > 0 THEN (quiz_attempts.score / quiz_attempts.total_points) * 100 ELSE 0 END) as average_score'),
            DB::raw('MAX(CASE WHEN quiz_attempts.total_points > 0 THEN (quiz_attempts.score / quiz_attempts.total_points) * 100 ELSE 0 END) as best_score'),
            DB::raw('SUM(quiz_attempts.time_taken) as total_time')
        ])
        ->join('quiz_attempts', 'users.id', '=', 'quiz_attempts.user_id')
        ->join('quizzes', 'quiz_attempts.quiz_id', '=', 'quizzes.id')
        ->join('lessons', 'quizzes.lesson_id', '=', 'lessons.id')
        ->where('quiz_attempts.completed_at', '!=', null);

        if ($courseId) {
            $query->where('lessons.course_id', $courseId);
        }

        return $query->groupBy('users.id', 'users.name', 'users.email', 'users.avatar')
            ->orderBy('average_score', 'desc')
            ->orderBy('total_attempts', 'desc')
            ->limit(10)
            ->get();
    }

    private function getRecentAttempts($courseId = null)
    {
        $query = QuizAttempt::with(['user', 'quiz.lesson.course'])
            ->where('completed_at', '!=', null);

        if ($courseId) {
            $query->whereHas('quiz.lesson', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            });
        }

        return $query->orderBy('completed_at', 'desc')
            ->limit(10)
            ->get();
    }

    private function getQuizStats($courseId = null)
    {
        $query = QuizAttempt::where('completed_at', '!=', null);

        if ($courseId) {
            $query->whereHas('quiz.lesson', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            });
        }

        $baseQuery = clone $query;

        return [
            'total_attempts' => $query->count(),
            'passed_attempts' => (clone $baseQuery)->where('is_passed', true)->count(),
            'average_score' => $baseQuery->selectRaw('AVG(CASE WHEN total_points > 0 THEN (score / total_points) * 100 ELSE 0 END) as avg_score')->value('avg_score'),
            'average_time' => $baseQuery->avg('time_taken')
        ];
    }
}