<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $user = \App\Models\User::create([
        'name' => 'Test User 2',
        'email' => 'test2@test.com',
        'password' => \Illuminate\Support\Facades\Hash::make('123456'),
        'role' => 'customer'
    ]);
    
    $user->syncRoles('customer');
    echo "SUCCESS\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
