<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class MoreProductsSeeder extends Seeder
{
    public function run(): void
    {
        // === SỬA ẢNH BỊ LỖI ===
        $fixes = [
            38 => 'https://images.unsplash.com/photo-1556306535-0f09a537f0a3?w=600&h=600&fit=crop', // Mũ Bucket
            20 => 'https://images.unsplash.com/photo-1625910513413-5fc08ef62cb0?w=600&h=800&fit=crop', // Áo Polo
            33 => 'https://images.unsplash.com/photo-1583496661160-fb5886a0aebd?w=600&h=800&fit=crop', // Chân Váy Jean
            9  => 'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d44?w=600&h=800&fit=crop', // Váy A-Line
            39 => 'https://images.unsplash.com/photo-1609803384069-19f3e5a70e75?w=600&h=600&fit=crop', // Khăn Cashmere
            29 => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600&h=600&fit=crop', // Quần Tây Âu
        ];

        foreach ($fixes as $id => $image) {
            Product::where('id', $id)->update(['image' => $image]);
        }
        $this->command->info('Đã sửa ' . count($fixes) . ' ảnh bị lỗi.');

        // === THÊM 3 SẢN PHẨM MỖI DANH MỤC ===
        $products = [
            // ===== ÁO (category_id: 1) =====
            [
                'name' => 'Áo Cardigan Len Mỏng',
                'description' => 'Áo cardigan len mỏng nhẹ, cài khuy tròn, phong cách Hàn Quốc dịu dàng.',
                'image' => 'https://images.unsplash.com/photo-1434389677669-e08b4cda3a20?w=600&h=800&fit=crop',
                'price' => 380000,
                'quanlity' => 30,
                'category_id' => 1,
            ],
            [
                'name' => 'Áo Tank Top Thể Thao',
                'description' => 'Áo tank top tập gym chất liệu dri-fit, thoáng mát, co giãn 4 chiều.',
                'image' => 'https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=600&h=800&fit=crop',
                'price' => 190000,
                'quanlity' => 65,
                'category_id' => 1,
            ],
            [
                'name' => 'Áo Khoác Gió Nhẹ Xanh Navy',
                'description' => 'Áo khoác gió siêu nhẹ, gấp gọn bỏ túi, chống nước nhẹ, lý tưởng cho du lịch.',
                'image' => 'https://images.unsplash.com/photo-1545594861-3bef43ff2fc8?w=600&h=800&fit=crop',
                'price' => 450000,
                'quanlity' => 25,
                'category_id' => 1,
            ],

            // ===== QUẦN (category_id: 2) =====
            [
                'name' => 'Quần Legging Yoga Đen',
                'description' => 'Quần legging yoga cao cấp, cạp cao nâng mông, chất liệu nylon pha spandex.',
                'image' => 'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=600&h=800&fit=crop',
                'price' => 320000,
                'quanlity' => 45,
                'category_id' => 2,
            ],
            [
                'name' => 'Quần Baggy Jean Rách Gối',
                'description' => 'Quần baggy jean rách gối phong cách streetwear, wash xanh nhạt cá tính.',
                'image' => 'https://images.unsplash.com/photo-1604176354204-9268737828e4?w=600&h=800&fit=crop',
                'price' => 480000,
                'quanlity' => 30,
                'category_id' => 2,
            ],
            [
                'name' => 'Quần Đùi Thể Thao Đen',
                'description' => 'Quần đùi thể thao nam, chất thun mát, có túi khoá kéo và dây rút.',
                'image' => 'https://images.unsplash.com/photo-1562157873-818bc0726f68?w=600&h=800&fit=crop',
                'price' => 220000,
                'quanlity' => 55,
                'category_id' => 2,
            ],

            // ===== VÁY & ĐẦM (category_id: 3) =====
            [
                'name' => 'Váy Liền Hoa Retro',
                'description' => 'Váy liền in hoa retro cổ điển, cổ vuông tay phồng, chất cotton mềm mại.',
                'image' => 'https://images.unsplash.com/photo-1622122201714-77da0ca8e5d2?w=600&h=800&fit=crop',
                'price' => 550000,
                'quanlity' => 20,
                'category_id' => 3,
            ],
            [
                'name' => 'Đầm Hai Dây Satin',
                'description' => 'Đầm hai dây satin bóng mượt, dáng xoè nhẹ ngang gối, sang trọng dự tiệc.',
                'image' => 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=600&h=800&fit=crop',
                'price' => 620000,
                'quanlity' => 18,
                'category_id' => 3,
            ],
            [
                'name' => 'Chân Váy Xếp Li Dài',
                'description' => 'Chân váy xếp li dài qua gối, chất vải chiffon bay bổng, lưng chun thoải mái.',
                'image' => 'https://images.unsplash.com/photo-1594633313593-bab3825d0caf?w=600&h=800&fit=crop',
                'price' => 420000,
                'quanlity' => 28,
                'category_id' => 3,
            ],

            // ===== PHỤ KIỆN (category_id: 4) =====
            [
                'name' => 'Vòng Tay Bạc Minimalist',
                'description' => 'Vòng tay bạc 925 thiết kế tối giản, mặt khắc chữ, phù hợp làm quà tặng.',
                'image' => 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=600&h=800&fit=crop',
                'price' => 350000,
                'quanlity' => 35,
                'category_id' => 4,
            ],
            [
                'name' => 'Bông Tai Ngọc Trai',
                'description' => 'Bông tai ngọc trai nhân tạo thanh lịch, khoá bấm an toàn, không gây dị ứng.',
                'image' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=600&h=800&fit=crop',
                'price' => 180000,
                'quanlity' => 50,
                'category_id' => 4,
            ],
            [
                'name' => 'Ví Dài Da Nam',
                'description' => 'Ví dài da PU cao cấp, nhiều ngăn đựng thẻ và tiền, khoá kéo chắc chắn.',
                'image' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=600&h=800&fit=crop',
                'price' => 290000,
                'quanlity' => 40,
                'category_id' => 4,
            ],

            // ===== GIÀY DÉP (category_id: 5) =====
            [
                'name' => 'Giày Cao Gót Mũi Nhọn',
                'description' => 'Giày cao gót 7cm mũi nhọn thanh lịch, chất liệu da lộn, đệm mút êm.',
                'image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=600&h=800&fit=crop',
                'price' => 680000,
                'quanlity' => 20,
                'category_id' => 5,
            ],
            [
                'name' => 'Giày Slip-on Vải Canvas',
                'description' => 'Giày slip-on vải canvas thoáng mát, đế cao su dẻo, dễ mang tháo.',
                'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=600&h=800&fit=crop',
                'price' => 350000,
                'quanlity' => 40,
                'category_id' => 5,
            ],
            [
                'name' => 'Dép Xỏ Ngón Cao Su',
                'description' => 'Dép xỏ ngón cao su thiên nhiên, đế chống trượt, nhẹ bền cho mùa hè.',
                'image' => 'https://images.unsplash.com/photo-1603487742131-4160ec999306?w=600&h=800&fit=crop',
                'price' => 150000,
                'quanlity' => 80,
                'category_id' => 5,
            ],

            // ===== TÚI XÁCH (category_id: 6) =====
            [
                'name' => 'Túi Xách Tay Da Nữ',
                'description' => 'Túi xách tay nữ da PU mềm, quai kép chắc chắn, ngăn lót vải dù cao cấp.',
                'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=600&h=800&fit=crop',
                'price' => 750000,
                'quanlity' => 15,
                'category_id' => 6,
            ],
            [
                'name' => 'Túi Đựng iPad Vải Nỉ',
                'description' => 'Túi đựng iPad 11 inch chất liệu vải nỉ dày, chống xước, có quai cầm.',
                'image' => 'https://images.unsplash.com/photo-1559563458-527698bf5295?w=600&h=800&fit=crop',
                'price' => 220000,
                'quanlity' => 35,
                'category_id' => 6,
            ],
            [
                'name' => 'Túi Gym Duffel Thể Thao',
                'description' => 'Túi gym duffel chống nước, ngăn riêng đựng giày, dây đeo vai có đệm.',
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&h=800&fit=crop',
                'price' => 450000,
                'quanlity' => 25,
                'category_id' => 6,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('Đã thêm ' . count($products) . ' sản phẩm mới thành công!');
    }
}
