<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === Tạo Danh Mục ===
        $categories = [
            'Áo' => 1,
            'Quần' => 2,
            'Váy & Đầm' => 3,
            'Phụ Kiện' => 4,
            'Giày Dép' => 5,
            'Túi Xách' => 6,
        ];

        foreach ($categories as $name => $id) {
            Category::updateOrCreate(['id' => $id], ['name' => $name]);
        }

        // === Tạo Sản Phẩm ===
        $products = [
            // Áo (category_id: 1)
            ['name' => 'Áo Blazer Len Cấu Trúc', 'description' => 'Áo blazer cao cấp với kiểu dáng cấu trúc, chất liệu len mịn, phù hợp cho các buổi họp và sự kiện.', 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=600&h=800&fit=crop', 'price' => 1200000, 'quanlity' => 15, 'view' => 120, 'category_id' => 1],
            ['name' => 'Áo Sơ Mi Linen Trắng', 'description' => 'Áo sơ mi linen thoáng mát, thiết kế tối giản sang trọng cho ngày hè.', 'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=600&h=800&fit=crop', 'price' => 650000, 'quanlity' => 30, 'view' => 89, 'category_id' => 1],
            ['name' => 'Áo Len Cashmere Cổ V', 'description' => 'Áo len cashmere siêu mềm mại, tông màu trung tính dễ phối đồ.', 'image' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=600&h=800&fit=crop', 'price' => 890000, 'quanlity' => 20, 'view' => 156, 'category_id' => 1],
            ['name' => 'Áo Khoác Denim Vintage', 'description' => 'Áo khoác denim phong cách vintage, wash nhẹ tạo cảm giác cổ điển.', 'image' => 'https://images.unsplash.com/photo-1551537482-f2075a1d41f2?w=600&h=800&fit=crop', 'price' => 780000, 'quanlity' => 12, 'view' => 67, 'category_id' => 1],

            // Quần (category_id: 2)
            ['name' => 'Quần Ống Rộng Xếp Li', 'description' => 'Quần ống rộng xếp li thanh lịch, chất liệu thoáng mát phù hợp mọi dịp.', 'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=600&h=800&fit=crop', 'price' => 720000, 'quanlity' => 25, 'view' => 94, 'category_id' => 2],
            ['name' => 'Quần Jeans Slim Fit', 'description' => 'Quần jeans slim fit classic, wash đậm tôn dáng.', 'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=600&h=800&fit=crop', 'price' => 550000, 'quanlity' => 40, 'view' => 203, 'category_id' => 2],
            ['name' => 'Quần Khaki Chino', 'description' => 'Quần khaki chino basic, phom dáng chuẩn dễ phối.', 'image' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=600&h=800&fit=crop', 'price' => 480000, 'quanlity' => 35, 'view' => 78, 'category_id' => 2],

            // Váy & Đầm (category_id: 3)
            ['name' => 'Đầm Midi Lụa Xếp Nếp', 'description' => 'Đầm midi lụa mềm mại với các nếp xếp tinh tế, phù hợp dự tiệc.', 'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=600&h=800&fit=crop', 'price' => 1350000, 'quanlity' => 10, 'view' => 178, 'category_id' => 3],
            ['name' => 'Váy A-Line Tối Giản', 'description' => 'Váy A-line thiết kế tối giản hiện đại, dễ mặc hàng ngày.', 'image' => 'https://images.unsplash.com/photo-1583496661160-fb5886a0aaaa?w=600&h=800&fit=crop', 'price' => 680000, 'quanlity' => 18, 'view' => 134, 'category_id' => 3],
            ['name' => 'Đầm Maxi Bohemian', 'description' => 'Đầm maxi phong cách bohemian tự do, hoàn hảo cho kỳ nghỉ.', 'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=600&h=800&fit=crop', 'price' => 950000, 'quanlity' => 8, 'view' => 112, 'category_id' => 3],

            // Phụ Kiện (category_id: 4)
            ['name' => 'Khăn Lụa Twill', 'description' => 'Khăn lụa twill in hoa văn tinh tế, điểm nhấn cho mọi trang phục.', 'image' => 'https://images.unsplash.com/photo-1601924921557-45e6ddf05b91?w=600&h=800&fit=crop', 'price' => 320000, 'quanlity' => 50, 'view' => 45, 'category_id' => 4],
            ['name' => 'Mũ Fedora Classic', 'description' => 'Mũ fedora kiểu dáng cổ điển, chất liệu len cao cấp.', 'image' => 'https://images.unsplash.com/photo-1521369909029-2afed882baee?w=600&h=800&fit=crop', 'price' => 450000, 'quanlity' => 20, 'view' => 56, 'category_id' => 4],
            ['name' => 'Kính Mát Aviator', 'description' => 'Kính mát aviator gọng kim loại, tròng phân cực chống UV.', 'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=600&h=800&fit=crop', 'price' => 580000, 'quanlity' => 25, 'view' => 89, 'category_id' => 4],

            // Giày Dép (category_id: 5)
            ['name' => 'Giày Loafer Da Bò', 'description' => 'Giày loafer da bò thật, đế cao su chống trượt, thiết kế thanh lịch.', 'image' => 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?w=600&h=800&fit=crop', 'price' => 1450000, 'quanlity' => 12, 'view' => 167, 'category_id' => 5],
            ['name' => 'Sandal Quai Ngang Minimal', 'description' => 'Sandal quai ngang thiết kế tối giản, êm chân cho mùa hè.', 'image' => 'https://images.unsplash.com/photo-1603487742131-4160ec999306?w=600&h=800&fit=crop', 'price' => 380000, 'quanlity' => 30, 'view' => 78, 'category_id' => 5],
            ['name' => 'Giày Sneaker Trắng', 'description' => 'Giày sneaker trắng basic, đa năng phối được với mọi outfit.', 'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600&h=800&fit=crop', 'price' => 920000, 'quanlity' => 22, 'view' => 234, 'category_id' => 5],

            // Túi Xách (category_id: 6)
            ['name' => 'Túi Tote Da Minimalist', 'description' => 'Túi tote da thật kiểu dáng tối giản, đựng được laptop 14 inch.', 'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=600&h=800&fit=crop', 'price' => 1680000, 'quanlity' => 8, 'view' => 189, 'category_id' => 6],
            ['name' => 'Túi Đeo Chéo Compact', 'description' => 'Túi đeo chéo nhỏ gọn, nhiều ngăn tiện dụng cho đi phố.', 'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&h=800&fit=crop', 'price' => 750000, 'quanlity' => 15, 'view' => 123, 'category_id' => 6],
            ['name' => 'Ba Lô Canvas Urban', 'description' => 'Ba lô canvas phong cách urban, chống nước nhẹ cho ngày mưa.', 'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&h=800&fit=crop', 'price' => 620000, 'quanlity' => 18, 'view' => 98, 'category_id' => 6],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        // === Tạo User mẫu ===
        User::updateOrCreate(
            ['email' => 'admin@atelier.com'],
            ['password' => 'admin123', 'role' => 'admin']
        );
        User::updateOrCreate(
            ['email' => 'user@atelier.com'],
            ['password' => 'user123', 'role' => 'customer']
        );
    }
}
