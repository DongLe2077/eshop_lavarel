<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Bắt đầu băm mật khẩu...\n";

$users = User::all();
$count = 0;

foreach ($users as $user) {
    // Kiểm tra xem mật khẩu đã được băm chưa (Bcrypt thường bắt đầu bằng $2y$)
    if (!Hash::info($user->password)['algoName']) {
        echo "Đang băm mật khẩu cho user: {$user->email}\n";
        $user->password = Hash::make($user->password);
        $user->save();
        $count++;
    }
}

echo "Hoàn thành! Đã băm mới $count mật khẩu.\n";
