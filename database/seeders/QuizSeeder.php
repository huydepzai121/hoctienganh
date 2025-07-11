<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessons = Lesson::all();

        foreach ($lessons as $lesson) {
            // Kiểm tra xem quiz đã tồn tại chưa
            $existingQuiz = Quiz::where('lesson_id', $lesson->id)->first();

            if (!$existingQuiz) {
                // Tạo quiz cho mỗi bài học
                $quiz = Quiz::create([
                    'title' => 'Kiểm tra: ' . $lesson->title,
                    'description' => 'Bài kiểm tra kiến thức cho bài học: ' . $lesson->title,
                    'lesson_id' => $lesson->id,
                    'time_limit' => 10, // 10 phút
                    'max_attempts' => 3,
                    'passing_score' => 70,
                    'is_active' => true,
                ]);

                // Tạo câu hỏi mẫu cho quiz
                $this->createSampleQuestions($quiz);
            } else {
                echo "Quiz for lesson '{$lesson->title}' already exists, skipping...\n";
            }


        }
    }

    private function createSampleQuestions($quiz)
    {
        $questionTemplates = [
            [
                'question' => 'Chọn câu trả lời đúng nhất cho bài học này:',
                'type' => 'multiple_choice',
                'options' => [
                    'A' => 'Đây là lựa chọn A',
                    'B' => 'Đây là lựa chọn B (đúng)',
                    'C' => 'Đây là lựa chọn C',
                    'D' => 'Đây là lựa chọn D',
                ],
                'correct_answer' => 'B',
                'explanation' => 'Lựa chọn B là đáp án đúng vì...',
                'points' => 2,
                'order' => 1,
            ],
            [
                'question' => 'Câu sau đây đúng hay sai: "Nội dung bài học rất hữu ích"?',
                'type' => 'true_false',
                'options' => [
                    'true' => 'Đúng',
                    'false' => 'Sai',
                ],
                'correct_answer' => 'true',
                'explanation' => 'Câu này đúng vì nội dung bài học được thiết kế để hữu ích cho học viên.',
                'points' => 1,
                'order' => 2,
            ],
            [
                'question' => 'Điền vào chỗ trống: "Tiếng Anh là ngôn ngữ _____ quan trọng."',
                'type' => 'fill_blank',
                'options' => null,
                'correct_answer' => 'rất',
                'explanation' => 'Từ "rất" phù hợp nhất trong ngữ cảnh này.',
                'points' => 1,
                'order' => 3,
            ],
        ];

        foreach ($questionTemplates as $questionData) {
            QuizQuestion::create(array_merge($questionData, [
                'quiz_id' => $quiz->id,
            ]));
        }
    }
}
