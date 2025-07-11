<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructor = User::where('email', 'instructor@hoctienganh.com')->first();
        $categories = Category::all();

        $courses = [
            [
                'title' => 'Tiếng Anh Giao Tiếp Cơ Bản',
                'slug' => 'tieng-anh-giao-tiep-co-ban',
                'description' => 'Khóa học tiếng Anh giao tiếp cơ bản dành cho người mới bắt đầu. Bạn sẽ học được các cụm từ, câu nói thông dụng trong cuộc sống hàng ngày.',
                'short_description' => 'Học tiếng Anh giao tiếp từ cơ bản đến thành thạo',
                'level' => 'beginner',
                'price' => 0,
                'duration_hours' => 20,
                'is_published' => true,
                'is_featured' => true,
                'category_id' => $categories->where('slug', 'tieng-anh-giao-tiep')->first()->id,
                'instructor_id' => $instructor->id,
            ],
            [
                'title' => 'IELTS Speaking Band 7+',
                'slug' => 'ielts-speaking-band-7',
                'description' => 'Khóa học chuyên sâu về IELTS Speaking, giúp bạn đạt band 7+ trong kỳ thi IELTS. Bao gồm các chiến lược làm bài, từ vựng chuyên ngành và luyện tập thực hành.',
                'short_description' => 'Chinh phục IELTS Speaking với band điểm cao',
                'level' => 'intermediate',
                'price' => 1500000,
                'duration_hours' => 40,
                'is_published' => true,
                'is_featured' => true,
                'category_id' => $categories->where('slug', 'ielts')->first()->id,
                'instructor_id' => $instructor->id,
            ],
            [
                'title' => 'Tiếng Anh Thương Mại Chuyên Nghiệp',
                'slug' => 'tieng-anh-thuong-mai-chuyen-nghiep',
                'description' => 'Khóa học tiếng Anh thương mại dành cho những người làm việc trong môi trường doanh nghiệp. Học cách viết email, thuyết trình và đàm phán bằng tiếng Anh.',
                'short_description' => 'Nâng cao kỹ năng tiếng Anh trong kinh doanh',
                'level' => 'advanced',
                'price' => 2000000,
                'duration_hours' => 35,
                'is_published' => true,
                'is_featured' => false,
                'category_id' => $categories->where('slug', 'tieng-anh-thuong-mai')->first()->id,
                'instructor_id' => $instructor->id,
            ],
            [
                'title' => 'Ngữ Pháp Tiếng Anh Từ A-Z',
                'slug' => 'ngu-phap-tieng-anh-tu-a-z',
                'description' => 'Khóa học ngữ pháp tiếng Anh toàn diện từ cơ bản đến nâng cao. Giải thích dễ hiểu với nhiều ví dụ thực tế và bài tập thực hành.',
                'short_description' => 'Nắm vững ngữ pháp tiếng Anh một cách hệ thống',
                'level' => 'beginner',
                'price' => 800000,
                'duration_hours' => 30,
                'is_published' => true,
                'is_featured' => true,
                'category_id' => $categories->where('slug', 'ngu-phap')->first()->id,
                'instructor_id' => $instructor->id,
            ],
            [
                'title' => 'TOEIC 900+ Chiến Lược Thi',
                'slug' => 'toeic-900-chien-luoc-thi',
                'description' => 'Khóa học luyện thi TOEIC với mục tiêu đạt 900+ điểm. Bao gồm tất cả kỹ năng Listening và Reading với các mẹo làm bài hiệu quả.',
                'short_description' => 'Đạt điểm cao TOEIC với chiến lược tối ưu',
                'level' => 'intermediate',
                'price' => 1200000,
                'duration_hours' => 45,
                'is_published' => true,
                'is_featured' => false,
                'category_id' => $categories->where('slug', 'toeic')->first()->id,
                'instructor_id' => $instructor->id,
            ],
            [
                'title' => '3000 Từ Vựng Thiết Yếu',
                'slug' => '3000-tu-vung-thiet-yeu',
                'description' => 'Khóa học từ vựng tiếng Anh với 3000 từ vựng thiết yếu nhất. Học từ vựng theo chủ đề với phương pháp ghi nhớ hiệu quả.',
                'short_description' => 'Mở rộng vốn từ vựng tiếng Anh hiệu quả',
                'level' => 'beginner',
                'price' => 0,
                'duration_hours' => 25,
                'is_published' => true,
                'is_featured' => true,
                'category_id' => $categories->where('slug', 'tu-vung')->first()->id,
                'instructor_id' => $instructor->id,
            ]
        ];

        foreach ($courses as $courseData) {
            // Kiểm tra xem course đã tồn tại chưa
            $existingCourse = Course::where('slug', $courseData['slug'])->first();

            if (!$existingCourse) {
                $course = Course::create($courseData);
                // Tạo một số bài học mẫu cho mỗi khóa học
                $this->createSampleLessons($course);
            } else {
                echo "Course '{$courseData['title']}' already exists, skipping...\n";
            }
        }
    }

    private function createSampleLessons($course)
    {
        $lessonTemplates = [
            [
                'title' => 'Giới thiệu khóa học',
                'content' => 'Chào mừng bạn đến với khóa học. Trong bài học này, chúng ta sẽ tìm hiểu về mục tiêu và cấu trúc của khóa học.',
                'summary' => 'Tổng quan về khóa học và mục tiêu học tập',
                'duration_minutes' => 15,
                'order' => 1,
                'is_published' => true,
                'is_free' => true,
            ],
            [
                'title' => 'Bài học cơ bản số 1',
                'content' => 'Đây là nội dung bài học cơ bản đầu tiên. Chúng ta sẽ học về những kiến thức nền tảng quan trọng.',
                'summary' => 'Kiến thức nền tảng và các khái niệm cơ bản',
                'duration_minutes' => 30,
                'order' => 2,
                'is_published' => true,
                'is_free' => false,
            ],
            [
                'title' => 'Thực hành và ứng dụng',
                'content' => 'Trong bài học này, chúng ta sẽ thực hành những gì đã học và ứng dụng vào các tình huống thực tế.',
                'summary' => 'Bài tập thực hành và ứng dụng kiến thức',
                'duration_minutes' => 45,
                'order' => 3,
                'is_published' => true,
                'is_free' => false,
            ]
        ];

        foreach ($lessonTemplates as $lessonData) {
            $lessonData['course_id'] = $course->id;
            $lessonData['slug'] = Str::slug($lessonData['title']) . '-' . $course->id . '-' . $lessonData['order'];

            // Kiểm tra xem lesson đã tồn tại chưa
            $existingLesson = Lesson::where('slug', $lessonData['slug'])->first();

            if (!$existingLesson) {
                Lesson::create($lessonData);
            }
        }
    }
}
