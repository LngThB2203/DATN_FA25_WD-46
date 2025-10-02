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
                'name' => 'Nước hoa Nam',
                'slug' => 'nuoc-hoa-nam',
                'description' => 'Bộ sưu tập nước hoa dành cho nam giới với hương thơm mạnh mẽ và quyến rũ',
                'is_active' => true,
            ],
            [
                'name' => 'Nước hoa Nữ',
                'slug' => 'nuoc-hoa-nu',
                'description' => 'Bộ sưu tập nước hoa dành cho nữ giới với hương thơm nữ tính và tinh tế',
                'is_active' => true,
            ],
            [
                'name' => 'Nước hoa Unisex',
                'slug' => 'nuoc-hoa-unisex',
                'description' => 'Nước hoa phù hợp cho cả nam và nữ với hương thơm trung tính',
                'is_active' => true,
            ],
            [
                'name' => 'Nước hoa Cao cấp',
                'slug' => 'nuoc-hoa-cao-cap',
                'description' => 'Bộ sưu tập nước hoa cao cấp từ các thương hiệu nổi tiếng thế giới',
                'is_active' => true,
            ],
            [
                'name' => 'Nước hoa Trẻ em',
                'slug' => 'nuoc-hoa-tre-em',
                'description' => 'Nước hoa nhẹ nhàng và an toàn dành cho trẻ em',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
