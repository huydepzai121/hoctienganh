<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tiếng Anh Giao Tiếp',
                'slug' => 'tieng-anh-giao-tiep',
                'description' => 'Học tiếng Anh giao tiếp hàng ngày, phù hợp cho người mới bắt đầu',
                'is_active' => true
            ],
            [
                'name' => 'Tiếng Anh Thương Mại',
                'slug' => 'tieng-anh-thuong-mai',
                'description' => 'Tiếng Anh chuyên ngành kinh doanh và thương mại',
                'is_active' => true
            ],
            [
                'name' => 'IELTS',
                'slug' => 'ielts',
                'description' => 'Luyện thi IELTS - International English Language Testing System',
                'is_active' => true
            ],
            [
                'name' => 'TOEIC',
                'slug' => 'toeic',
                'description' => 'Luyện thi TOEIC - Test of English for International Communication',
                'is_active' => true
            ],
            [
                'name' => 'Ngữ Pháp',
                'slug' => 'ngu-phap',
                'description' => 'Học ngữ pháp tiếng Anh từ cơ bản đến nâng cao',
                'is_active' => true
            ],
            [
                'name' => 'Từ Vựng',
                'slug' => 'tu-vung',
                'description' => 'Mở rộng vốn từ vựng tiếng Anh theo chủ đề',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
