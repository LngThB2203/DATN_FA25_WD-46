<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        $products = [
            [
                'name' => 'Chanel No. 5',
                'slug' => 'chanel-no-5',
                'description' => 'Nước hoa huyền thoại với hương thơm nữ tính và sang trọng, phù hợp cho mọi dịp.',
                'price' => 2500000,
                'sale_price' => 2000000,
                'brand' => 'Chanel',
                'volume' => '100ml',
                'gender' => 'women',
                'fragrance_notes' => 'Hoa hồng, Hoa nhài, Vanilla, Sandalwood',
                'images' => ['chanel-no-5-1.jpg', 'chanel-no-5-2.jpg'],
                'stock_quantity' => 50,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $categories->where('slug', 'nuoc-hoa-nu')->first()->id,
            ],
            [
                'name' => 'Dior Sauvage',
                'slug' => 'dior-sauvage',
                'description' => 'Nước hoa nam với hương thơm mạnh mẽ và quyến rũ, tạo nên sự tự tin.',
                'price' => 1800000,
                'brand' => 'Dior',
                'volume' => '100ml',
                'gender' => 'men',
                'fragrance_notes' => 'Bergamot, Pepper, Ambergris, Cedar',
                'images' => ['dior-sauvage-1.jpg', 'dior-sauvage-2.jpg'],
                'stock_quantity' => 30,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $categories->where('slug', 'nuoc-hoa-nam')->first()->id,
            ],
            [
                'name' => 'Tom Ford Black Orchid',
                'slug' => 'tom-ford-black-orchid',
                'description' => 'Nước hoa unisex với hương thơm bí ẩn và quyến rũ, phù hợp cho cả nam và nữ.',
                'price' => 3200000,
                'sale_price' => 2800000,
                'brand' => 'Tom Ford',
                'volume' => '50ml',
                'gender' => 'unisex',
                'fragrance_notes' => 'Black Orchid, Dark Chocolate, Patchouli, Vanilla',
                'images' => ['tom-ford-black-orchid-1.jpg'],
                'stock_quantity' => 25,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $categories->where('slug', 'nuoc-hoa-unisex')->first()->id,
            ],
            [
                'name' => 'Creed Aventus',
                'slug' => 'creed-aventus',
                'description' => 'Nước hoa cao cấp với hương thơm sang trọng và đẳng cấp.',
                'price' => 4500000,
                'brand' => 'Creed',
                'volume' => '100ml',
                'gender' => 'men',
                'fragrance_notes' => 'Pineapple, Black Currant, Apple, Rose, Patchouli',
                'images' => ['creed-aventus-1.jpg', 'creed-aventus-2.jpg'],
                'stock_quantity' => 15,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $categories->where('slug', 'nuoc-hoa-cao-cap')->first()->id,
            ],
            [
                'name' => 'Yves Saint Laurent Libre',
                'slug' => 'ysl-libre',
                'description' => 'Nước hoa nữ với hương thơm tự do và phóng khoáng.',
                'price' => 2200000,
                'brand' => 'Yves Saint Laurent',
                'volume' => '90ml',
                'gender' => 'women',
                'fragrance_notes' => 'Lavender, Orange Blossom, Vanilla, Ambergris',
                'images' => ['ysl-libre-1.jpg'],
                'stock_quantity' => 40,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $categories->where('slug', 'nuoc-hoa-nu')->first()->id,
            ],
            [
                'name' => 'Calvin Klein CK One',
                'slug' => 'calvin-klein-ck-one',
                'description' => 'Nước hoa unisex với hương thơm tươi mát và trẻ trung.',
                'price' => 800000,
                'brand' => 'Calvin Klein',
                'volume' => '100ml',
                'gender' => 'unisex',
                'fragrance_notes' => 'Green Tea, Lemon, Bergamot, Sandalwood',
                'images' => ['ck-one-1.jpg'],
                'stock_quantity' => 60,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $categories->where('slug', 'nuoc-hoa-unisex')->first()->id,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
