<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\DiscussionCategoryController as AdminDiscussionCategoryController;
use App\Http\Controllers\Admin\DiscussionController as AdminDiscussionController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\DiscussionReplyController;
use App\Http\Controllers\DiscussionVoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

// Protected Frontend Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::get('/my-courses', [CourseController::class, 'myCourses'])->name('courses.my');
    Route::get('/lessons/{lesson:slug}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('/lessons/{lesson}/complete', [LessonController::class, 'complete'])->name('lessons.complete');
    
    // Quiz Routes
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes/{quiz}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::get('/quiz-attempts/{attempt}', [QuizController::class, 'take'])->name('quizzes.take');
    Route::post('/quiz-attempts/{attempt}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quiz-attempts/{attempt}/result', [QuizController::class, 'result'])->name('quizzes.result');
    
    // Leaderboard Routes
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
    Route::get('/leaderboard/quiz/{quiz}', [LeaderboardController::class, 'quiz'])->name('leaderboard.quiz');
    Route::get('/leaderboard/user/{user}', [LeaderboardController::class, 'user'])->name('leaderboard.user');

    // Review Routes
    Route::post('/courses/{course}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Discussions
Route::resource('discussions', DiscussionController::class)->parameters(['discussions' => 'discussion:slug']);

// Discussion Replies
Route::middleware('auth')->group(function () {
    Route::post('discussions/{discussion}/replies', [DiscussionReplyController::class, 'store'])->name('discussion-replies.store');
    Route::patch('discussion-replies/{reply}', [DiscussionReplyController::class, 'update'])->name('discussion-replies.update');
    Route::delete('discussion-replies/{reply}', [DiscussionReplyController::class, 'destroy'])->name('discussion-replies.destroy');
    Route::patch('discussion-replies/{reply}/best-answer', [DiscussionReplyController::class, 'markAsBestAnswer'])->name('discussion-replies.best-answer');
    Route::patch('discussion-replies/{reply}/solution', [DiscussionReplyController::class, 'markAsSolution'])->name('discussion-replies.solution');
});

// Discussion Voting
Route::middleware('auth')->group(function () {
    Route::post('discussions/{discussion}/vote', [DiscussionVoteController::class, 'voteDiscussion'])->name('discussions.vote');
    Route::post('discussion-replies/{reply}/vote', [DiscussionVoteController::class, 'voteReply'])->name('discussion-replies.vote');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes with AdminLTE
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Categories Management
    Route::resource('categories', AdminCategoryController::class);

    // Courses Management
    Route::resource('courses', AdminCourseController::class);

    // Lessons Management
    Route::resource('lessons', AdminLessonController::class);

    // Quizzes Management
    Route::resource('quizzes', AdminQuizController::class);

    // Users Management
    Route::resource('users', AdminUserController::class);

    // Reviews Management
    Route::resource('reviews', AdminReviewController::class)->only(['index', 'show', 'destroy']);
    Route::patch('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::patch('reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::post('reviews/bulk-approve', [AdminReviewController::class, 'bulkApprove'])->name('reviews.bulk-approve');
    Route::post('reviews/bulk-reject', [AdminReviewController::class, 'bulkReject'])->name('reviews.bulk-reject');
    Route::post('reviews/bulk-delete', [AdminReviewController::class, 'bulkDelete'])->name('reviews.bulk-delete');

    // Discussion Categories Management
    Route::resource('discussion-categories', AdminDiscussionCategoryController::class);
    Route::patch('discussion-categories/{discussionCategory}/toggle-status', [AdminDiscussionCategoryController::class, 'toggleStatus'])->name('discussion-categories.toggle-status');

    // Discussions Management
    Route::resource('discussions', AdminDiscussionController::class)->only(['index', 'show', 'destroy']);
    Route::patch('discussions/{discussion}/status', [AdminDiscussionController::class, 'updateStatus'])->name('discussions.update-status');
    Route::patch('discussions/{discussion}/toggle-pin', [AdminDiscussionController::class, 'togglePin'])->name('discussions.toggle-pin');
    Route::patch('discussions/{discussion}/toggle-featured', [AdminDiscussionController::class, 'toggleFeatured'])->name('discussions.toggle-featured');
    Route::post('discussions/bulk-action', [AdminDiscussionController::class, 'bulkAction'])->name('discussions.bulk-action');
});

require __DIR__.'/auth.php';
