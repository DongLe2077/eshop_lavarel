<?php

use App\Models\User;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$email = 'admin@example.com'; // Bạn có thể đổi email này thành email bạn muốn làm admin

$user = User::where('email', $email)->first();

if ($user) {
    $user->role = 'admin';
    $user->save();
    echo "Đã cấp quyền Admin cho: $email\n";
} else {
    // Nếu chưa có thì tạo mới
    $user = new User();
    $user->email = $email;
    $user->password = \Illuminate\Support\Facades\Hash::make('admin123');
    $user->role = 'admin';
    $user->save();
    echo "Đã tạo mới tài khoản Admin:\nEmail: $email\nPass: admin123\n";
}
