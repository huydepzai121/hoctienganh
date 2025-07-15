<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get courses
        $courses = Course::published()->get();

        $sampleReviews = [
            [
                'rating' => 5,
                'comment' => 'Khóa học rất hay và bổ ích! Giảng viên giải thích rất dễ hiểu, nội dung được sắp xếp logic. Tôi đã học được rất nhiều kiến thức mới.'
            ],
            [
                'rating' => 4,
                'comment' => 'Nội dung khóa học tốt, phù hợp với người mới bắt đầu. Tuy nhiên, tôi mong muốn có thêm nhiều bài tập thực hành hơn.'
            ],
            [
                'rating' => 5,
                'comment' => 'Tuyệt vời! Đây là khóa học tiếng Anh tốt nhất mà tôi từng tham gia. Cảm ơn giảng viên đã tạo ra khóa học chất lượng này.'
            ],
            [
                'rating' => 4,
                'comment' => 'Khóa học có nội dung phong phú và cập nhật. Video bài giảng chất lượng cao, âm thanh rõ ràng. Rất đáng để đầu tư.'
            ],
            [
                'rating' => 3,
                'comment' => 'Khóa học ổn, có một số phần hay nhưng cũng có phần hơi khô khan. Mong giảng viên cải thiện thêm.'
            ],
            [
                'rating' => 5,
                'comment' => 'Xuất sắc! Tôi đã áp dụng được ngay những kiến thức học được vào công việc. Khóa học rất thực tế và hữu ích.'
            ],
            [
                'rating' => 4,
                'comment' => 'Giảng viên nhiệt tình, nội dung dễ hiểu. Tôi sẽ giới thiệu khóa học này cho bạn bè.'
            ],
            [
                'rating' => 5,
                'comment' => 'Khóa học vượt ngoài mong đợi của tôi. Từ vựng được giải thích rất chi tiết, có nhiều ví dụ thực tế.'
            ],
            [
                'rating' => 4,
                'comment' => 'Nội dung hay, cách trình bày hấp dẫn. Tuy nhiên, tôi mong muốn có thêm quiz để kiểm tra kiến thức.'
            ],
            [
                'rating' => 5,
                'comment' => 'Đây là khoản đầu tư tốt nhất cho việc học tiếng Anh của tôi. Cảm ơn rất nhiều!'
            ]
        ];

        foreach ($courses as $course) {
            // Get enrolled students for this course
            $enrolledStudents = $course->students()->take(rand(3, 8))->get();

            foreach ($enrolledStudents as $student) {
                // Not all enrolled students will review
                if (rand(1, 100) <= 70) { // 70% chance to review
                    $reviewData = $sampleReviews[array_rand($sampleReviews)];

                    Review::create([
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                        'rating' => $reviewData['rating'],
                        'comment' => $reviewData['comment'],
                        'is_approved' => rand(1, 100) <= 85, // 85% approved
                        'created_at' => now()->subDays(rand(1, 30)),
                        'updated_at' => now()->subDays(rand(1, 30))
                    ]);
                }
            }
        }

        $this->command->info('Reviews seeded successfully!');
    }
}
