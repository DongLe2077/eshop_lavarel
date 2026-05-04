<?php

use App\Models\User;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$admin = User::where('email', 'admin')->first();
if ($admin) {
    $admin->email = 'admin@gmail.com';
    $admin->save();
    echo "Cập nhật admin@gmail.com thành công.\n";
}

$user1 = User::where('email', 'user1')->first();
if ($user1) {
    $user1->email = 'user1@gmail.com';
    $user1->save();
    echo "Cập nhật user1@gmail.com thành công.\n";
}
