<?php

use App\Models\Product;
use Illuminate\Support\Str;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Generating slugs for existing products...\n";

$products = Product::all();
foreach ($products as $product) {
    if (empty($product->slug)) {
        $product->slug = Str::slug($product->name);
        
        // Handle uniqueness
        $originalSlug = $product->slug;
        $count = 1;
        while (Product::where('slug', $product->slug)->where('id', '!=', $product->id)->exists()) {
            $product->slug = $originalSlug . '-' . $count++;
        }
        
        $product->save();
        echo "Generated slug for ID {$product->id}: {$product->slug}\n";
    } else {
        echo "ID {$product->id} already has slug: {$product->slug}\n";
    }
}

echo "Done!\n";
