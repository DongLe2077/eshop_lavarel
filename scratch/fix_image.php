<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$product = Product::find(11);
if ($product) {
    echo "Old image: " . $product->image . "\n";
    $product->image = 'https://images.unsplash.com/photo-1606760227091-3dd870d9701b?w=800&q=80'; // New silk scarf image
    $product->save();
    echo "New image: " . $product->image . "\n";
} else {
    echo "Product not found\n";
}
