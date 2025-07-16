<?php

namespace Database\Seeders;

use App\Models\DiscussionCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscussionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hỏi đáp chung',
                'slug' => 'hoi-dap-chung',
                'description' => 'Các câu hỏi và thảo luận chung về học tiếng Anh',
                'color' => '#007bff',
                'icon' => 'fas fa-question-circle',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Ngữ pháp',
                'slug' => 'ngu-phap',
                'description' => 'Thảo luận về ngữ pháp tiếng Anh',
                'color' => '#28a745',
                'icon' => 'fas fa-book',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Từ vựng',
                'slug' => 'tu-vung',
                'description' => 'Học và thảo luận về từ vựng tiếng Anh',
                'color' => '#ffc107',
                'icon' => 'fas fa-spell-check',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Phát âm',
                'slug' => 'phat-am',
                'description' => 'Thảo luận về cách phát âm tiếng Anh',
                'color' => '#dc3545',
                'icon' => 'fas fa-microphone',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Luyện thi',
                'slug' => 'luyen-thi',
                'description' => 'Thảo luận về các kỳ thi TOEIC, IELTS, TOEFL',
                'color' => '#6f42c1',
                'icon' => 'fas fa-graduation-cap',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'name' => 'Giao tiếp',
                'slug' => 'giao-tiep',
                'description' => 'Thảo luận về kỹ năng giao tiếp tiếng Anh',
                'color' => '#17a2b8',
                'icon' => 'fas fa-comments',
                'sort_order' => 6,
                'is_active' => true
            ],
            [
                'name' => 'Tài liệu học tập',
                'slug' => 'tai-lieu-hoc-tap',
                'description' => 'Chia sẻ và thảo luận về tài liệu học tiếng Anh',
                'color' => '#fd7e14',
                'icon' => 'fas fa-file-alt',
                'sort_order' => 7,
                'is_active' => true
            ],
            [
                'name' => 'Kinh nghiệm học tập',
                'slug' => 'kinh-nghiem-hoc-tap',
                'description' => 'Chia sẻ kinh nghiệm và phương pháp học tiếng Anh',
                'color' => '#20c997',
                'icon' => 'fas fa-lightbulb',
                'sort_order' => 8,
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            DiscussionCategory::create($category);
        }
    }
}
