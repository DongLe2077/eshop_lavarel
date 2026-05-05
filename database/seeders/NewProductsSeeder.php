<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class NewProductsSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // ===== DANH MỤC 1: ÁO =====
            [
                'name' => 'Áo Polo Pique Classic',
                'description' => 'Áo polo nam chất liệu pique cao cấp, cổ bẻ lịch lãm, phù hợp đi làm và dạo phố.',
                'image' => 'https://images.unsplash.com/photo-1625910513413-5fc08ef62cb0?w=600&h=600&fit=crop',
                'price' => 320000,
                'quanlity' => 45,
                'category_id' => 1,
            ],
            [
                'name' => 'Áo Khoác Bomber Xanh Rêu',
                'description' => 'Áo khoác bomber phong cách streetwear, chất liệu gió nhẹ, lót lưới thoáng mát.',
                'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=600&h=600&fit=crop',
                'price' => 680000,
                'quanlity' => 20,
                'category_id' => 1,
            ],
            [
                'name' => 'Áo Sơ Mi Linen Trắng',
                'description' => 'Áo sơ mi linen tự nhiên, thoáng khí mùa hè, phom regular fit thanh lịch.',
                'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=600&h=600&fit=crop',
                'price' => 450000,
                'quanlity' => 35,
                'category_id' => 1,
            ],
            [
                'name' => 'Áo Hoodie Oversize Đen',
                'description' => 'Áo hoodie oversize unisex, nỉ bông dày dặn, mũ trùm 2 lớp, túi kangaroo tiện dụng.',
                'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=600&h=600&fit=crop',
                'price' => 390000,
                'quanlity' => 50,
                'category_id' => 1,
            ],
            [
                'name' => 'Áo Thun Graphic Art',
                'description' => 'Áo thun cotton 100% in hoạ tiết nghệ thuật độc quyền, form boxy hiện đại.',
                'image' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=600&h=600&fit=crop',
                'price' => 250000,
                'quanlity' => 60,
                'category_id' => 1,
            ],

            // ===== DANH MỤC 2: QUẦN =====
            [
                'name' => 'Quần Jeans Slim Fit Xanh Đậm',
                'description' => 'Quần jeans nam slim fit co giãn nhẹ, wash đậm trẻ trung, dễ phối đồ.',
                'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=600&h=600&fit=crop',
                'price' => 520000,
                'quanlity' => 40,
                'category_id' => 2,
            ],
            [
                'name' => 'Quần Kaki Chinos Be',
                'description' => 'Quần kaki chinos ống đứng, chất vải mềm mịn, thích hợp đi làm công sở.',
                'image' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=600&h=600&fit=crop',
                'price' => 420000,
                'quanlity' => 35,
                'category_id' => 2,
            ],
            [
                'name' => 'Quần Jogger Thể Thao',
                'description' => 'Quần jogger thun nỉ, bo gấu năng động, túi khoá kéo an toàn.',
                'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=600&h=600&fit=crop',
                'price' => 350000,
                'quanlity' => 55,
                'category_id' => 2,
            ],
            [
                'name' => 'Quần Short Cargo Xám',
                'description' => 'Quần short cargo nhiều túi hộp phong cách quân đội, vải ripstop bền bỉ.',
                'image' => 'https://images.unsplash.com/photo-1591195853828-11db59a44f6b?w=600&h=600&fit=crop',
                'price' => 290000,
                'quanlity' => 40,
                'category_id' => 2,
            ],
            [
                'name' => 'Quần Tây Âu Đen Công Sở',
                'description' => 'Quần tây âu đen ống suông, ly ép sắc nét, chất liệu polyester blend cao cấp.',
                'image' => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=600&h=600&fit=crop',
                'price' => 480000,
                'quanlity' => 30,
                'category_id' => 2,
            ],

            // ===== DANH MỤC 3: VÁY & ĐẦM =====
            [
                'name' => 'Đầm Maxi Hoa Nhí Vintage',
                'description' => 'Đầm maxi hoạ tiết hoa nhí phong cách vintage, chất vải voan nhẹ nhàng bay bổng.',
                'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=600&h=600&fit=crop',
                'price' => 650000,
                'quanlity' => 25,
                'category_id' => 3,
            ],
            [
                'name' => 'Váy Midi A-line Trắng',
                'description' => 'Váy midi xoè form A thanh lịch, chất liệu linen pha cotton, có lót trong.',
                'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=600&h=600&fit=crop',
                'price' => 480000,
                'quanlity' => 30,
                'category_id' => 3,
            ],
            [
                'name' => 'Đầm Body Đen Cổ Vuông',
                'description' => 'Đầm body tôn dáng cổ vuông nữ tính, chất thun gân co giãn tốt.',
                'image' => 'https://images.unsplash.com/photo-1568252542512-9fe8fe9c87bb?w=600&h=600&fit=crop',
                'price' => 380000,
                'quanlity' => 35,
                'category_id' => 3,
            ],
            [
                'name' => 'Chân Váy Jean Chữ A',
                'description' => 'Chân váy jean ngắn chữ A, wash nhẹ trẻ trung, kết hợp hoàn hảo với áo croptop.',
                'image' => 'https://images.unsplash.com/photo-1583496661160-fb5886a0aebd?w=600&h=600&fit=crop',
                'price' => 320000,
                'quanlity' => 40,
                'category_id' => 3,
            ],
            [
                'name' => 'Đầm Sơ Mi Caro Nâu',
                'description' => 'Đầm sơ mi dài tay hoạ tiết caro vintage, thắt eo nơ, phù hợp mùa thu đông.',
                'image' => 'https://images.unsplash.com/photo-1612336307429-8a898d10e223?w=600&h=600&fit=crop',
                'price' => 520000,
                'quanlity' => 20,
                'category_id' => 3,
            ],

            // ===== DANH MỤC 4: PHỤ KIỆN =====
            [
                'name' => 'Kính Mát Gọng Kim Loại',
                'description' => 'Kính mát thời trang gọng kim loại vàng hồng, tròng polarized chống UV400.',
                'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=600&h=600&fit=crop',
                'price' => 280000,
                'quanlity' => 50,
                'category_id' => 4,
            ],
            [
                'name' => 'Đồng Hồ Dây Da Nâu',
                'description' => 'Đồng hồ nam mặt tròn minimalist, dây da thật màu nâu cognac, chống nước 3ATM.',
                'image' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=600&h=600&fit=crop',
                'price' => 1250000,
                'quanlity' => 15,
                'category_id' => 4,
            ],
            [
                'name' => 'Thắt Lưng Da Bò Đen',
                'description' => 'Thắt lưng da bò thật 100%, khoá kim tự động, bề mặt nhám sang trọng.',
                'image' => 'https://images.unsplash.com/photo-1624222247344-550fb9c1c9c5?w=600&h=600&fit=crop',
                'price' => 350000,
                'quanlity' => 40,
                'category_id' => 4,
            ],
            [
                'name' => 'Mũ Bucket Vải Canvas',
                'description' => 'Mũ bucket vải canvas dày dặn, chống nắng tốt, phong cách casual unisex.',
                'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c334e67a?w=600&h=600&fit=crop',
                'price' => 180000,
                'quanlity' => 60,
                'category_id' => 4,
            ],
            [
                'name' => 'Khăn Choàng Len Cashmere',
                'description' => 'Khăn choàng cổ len cashmere mềm mại, giữ ấm mùa đông, nhiều màu thời trang.',
                'image' => 'https://images.unsplash.com/photo-1601924994987-69e26d50dc26?w=600&h=600&fit=crop',
                'price' => 420000,
                'quanlity' => 25,
                'category_id' => 4,
            ],

            // ===== DANH MỤC 5: GIÀY DÉP =====
            [
                'name' => 'Giày Thể Thao Trắng Classic',
                'description' => 'Giày sneaker trắng tinh giản, đế cao su chống trượt, phù hợp mọi outfit.',
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600&h=600&fit=crop',
                'price' => 890000,
                'quanlity' => 30,
                'category_id' => 5,
            ],
            [
                'name' => 'Giày Oxford Da Nâu',
                'description' => 'Giày oxford da bò thật, đế cao su đúc, thiết kế brogue cổ điển cho quý ông.',
                'image' => 'https://images.unsplash.com/photo-1614252369475-531eba835eb1?w=600&h=600&fit=crop',
                'price' => 1450000,
                'quanlity' => 15,
                'category_id' => 5,
            ],
            [
                'name' => 'Dép Quai Ngang Minimal',
                'description' => 'Dép quai ngang đế dày thiết kế tối giản, chất liệu EVA nhẹ và êm chân.',
                'image' => 'https://images.unsplash.com/photo-1603487742131-4160ec999306?w=600&h=600&fit=crop',
                'price' => 250000,
                'quanlity' => 50,
                'category_id' => 5,
            ],
            [
                'name' => 'Boots Chelsea Da Đen',
                'description' => 'Giày boots chelsea da PU cao cấp, cổ chun co giãn dễ mang, đế block 4cm.',
                'image' => 'https://images.unsplash.com/photo-1638247025967-b4e38f787b76?w=600&h=600&fit=crop',
                'price' => 1280000,
                'quanlity' => 18,
                'category_id' => 5,
            ],
            [
                'name' => 'Giày Chạy Bộ Ultra Boost',
                'description' => 'Giày chạy bộ đế foam siêu nhẹ, upper knit thoáng khí, hỗ trợ vòm chân.',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&h=600&fit=crop',
                'price' => 1650000,
                'quanlity' => 22,
                'category_id' => 5,
            ],

            // ===== DANH MỤC 6: TÚI XÁCH =====
            [
                'name' => 'Túi Đeo Chéo Mini Da',
                'description' => 'Túi đeo chéo mini da PU mềm, khoá kéo chắc chắn, dây đeo điều chỉnh.',
                'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&h=600&fit=crop',
                'price' => 420000,
                'quanlity' => 35,
                'category_id' => 6,
            ],
            [
                'name' => 'Ba Lô Laptop Chống Nước',
                'description' => 'Ba lô laptop 15.6 inch, vải oxford chống nước, ngăn chống sốc, cổng sạc USB.',
                'image' => 'https://images.unsplash.com/photo-1581605405803-3ca5df4f5d6d?w=600&h=600&fit=crop',
                'price' => 580000,
                'quanlity' => 28,
                'category_id' => 6,
            ],
            [
                'name' => 'Túi Tote Canvas In Chữ',
                'description' => 'Túi tote vải canvas dày, in chữ typography thời trang, ngăn trong có khoá kéo.',
                'image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=600&h=600&fit=crop',
                'price' => 180000,
                'quanlity' => 70,
                'category_id' => 6,
            ],
            [
                'name' => 'Clutch Dự Tiệc Ánh Kim',
                'description' => 'Clutch dự tiệc ánh kim sang trọng, khoá cài nam châm, dây xích đeo vai.',
                'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=600&h=600&fit=crop',
                'price' => 520000,
                'quanlity' => 15,
                'category_id' => 6,
            ],
            [
                'name' => 'Túi Bao Tử Thể Thao',
                'description' => 'Túi bao tử đeo hông chất liệu nylon chống thấm, 3 ngăn tiện dụng cho outdoor.',
                'image' => 'https://images.unsplash.com/photo-1622560480654-d96214fdc887?w=600&h=600&fit=crop',
                'price' => 280000,
                'quanlity' => 45,
                'category_id' => 6,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('Đã thêm ' . count($products) . ' sản phẩm mới thành công!');
    }
}
