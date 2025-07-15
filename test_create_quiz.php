<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Lesson;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Creating sample quiz...\n";

try {
    // Get first lesson
    $lesson = Lesson::first();
    if (!$lesson) {
        echo "No lesson found!\n";
        exit(1);
    }

    // Create quiz
    $quiz = Quiz::create([
        'title' => 'Quiz Tiếng Anh Cơ Bản',
        'description' => 'Bài kiểm tra về từ vựng và ngữ pháp cơ bản',
        'lesson_id' => $lesson->id,
        'time_limit' => 15,
        'max_attempts' => 3,
        'passing_score' => 70
    ]);

    // Create questions
    $questions = [
        [
            'question' => 'What is the past tense of "go"?',
            'answers' => [
                ['answer' => 'went', 'is_correct' => true],
                ['answer' => 'goes', 'is_correct' => false],
                ['answer' => 'going', 'is_correct' => false],
                ['answer' => 'gone', 'is_correct' => false]
            ]
        ],
        [
            'question' => 'Choose the correct sentence:',
            'answers' => [
                ['answer' => 'I am student', 'is_correct' => false],
                ['answer' => 'I am a student', 'is_correct' => true],
                ['answer' => 'I am an student', 'is_correct' => false],
                ['answer' => 'I student', 'is_correct' => false]
            ]
        ],
        [
            'question' => 'What does "beautiful" mean?',
            'answers' => [
                ['answer' => 'Xấu xí', 'is_correct' => false],
                ['answer' => 'Đẹp', 'is_correct' => true],
                ['answer' => 'Thông minh', 'is_correct' => false],
                ['answer' => 'Nhanh', 'is_correct' => false]
            ]
        ],
        [
            'question' => 'Complete: "She _____ to school every day"',
            'answers' => [
                ['answer' => 'go', 'is_correct' => false],
                ['answer' => 'goes', 'is_correct' => true],
                ['answer' => 'going', 'is_correct' => false],
                ['answer' => 'gone', 'is_correct' => false]
            ]
        ],
        [
            'question' => 'What is the plural of "child"?',
            'answers' => [
                ['answer' => 'childs', 'is_correct' => false],
                ['answer' => 'childrens', 'is_correct' => false],
                ['answer' => 'children', 'is_correct' => true],
                ['answer' => 'child', 'is_correct' => false]
            ]
        ]
    ];

    foreach ($questions as $index => $questionData) {
        $question = $quiz->questions()->create([
            'question' => $questionData['question'],
            'question_type' => 'multiple_choice',
            'points' => 1,
            'order' => $index + 1
        ]);

        foreach ($questionData['answers'] as $answerIndex => $answerData) {
            $question->answers()->create([
                'answer' => $answerData['answer'],
                'is_correct' => $answerData['is_correct'],
                'order' => $answerIndex + 1
            ]);
        }
    }

    echo "✅ Quiz created successfully!\n";
    echo "Quiz ID: {$quiz->id}\n";
    echo "Title: {$quiz->title}\n";
    echo "Questions: " . $quiz->questions()->count() . "\n";
    echo "Quiz URL: /quizzes/{$quiz->id}\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}