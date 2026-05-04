<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Bắt đầu dọn dẹp và tạo tài khoản mới...\n";

try {
    // 1. Xóa hết user cũ
    // Tạm thời tắt check foreign key nếu cần (thường users có liên kết với orders)
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    User::truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    echo "Đã xóa toàn bộ tài khoản cũ.\n";

    // 2. Tạo tài khoản admin
    $admin = new User();
    $admin->email = 'admin'; // Dùng 'admin' làm định danh theo yêu cầu
    $admin->password = Hash::make('123');
    $admin->role = 'admin';
    $admin->save();
    echo "Đã tạo tài khoản: admin / 123 (Role: admin)\n";

    // 3. Tạo tài khoản user1
    $user1 = new User();
    $user1->email = 'user1'; // Dùng 'user1' làm định danh theo yêu cầu
    $user1->password = Hash::make('123');
    $user1->role = 'customer';
    $user1->save();
    echo "Đã tạo tài khoản: user1 / 123 (Role: customer)\n";

    echo "Hoàn thành!\n";
} catch (\Exception $e) {
    echo "Lỗi: " . $e->getMessage() . "\n";
}
