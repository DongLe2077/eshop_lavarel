<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$keyword = 'áo';
$keywords = explode(' ', $keyword);
$query = Product::with('category');

$query->where(function ($q) use ($keywords) {
    foreach ($keywords as $word) {
        if (trim($word) == '') continue;
        $q->where(function ($sub) use ($word) {
            $sub->where('name', 'like', "%{$word}%")
                ->orWhere('description', 'like', "%{$word}%")
                ->orWhereHas('category', function ($catQuery) use ($word) {
                    $catQuery->where('name', 'like', "%{$word}%");
                });
        });
    }
});

$products = $query->take(5)->get();
echo "Found " . $products->count() . " products for 'áo'\n";
foreach ($products as $p) {
    echo "- " . $p->name . "\n";
}
