<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = \App\Models\Product::take(10)->get();
        
        $galleryImages = [
            'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80',
            'https://images.unsplash.com/photo-1539109132313-3915830d1c6a?w=800&q=80',
            'https://images.unsplash.com/photo-1434389677669-e08b4cda3a20?w=800&q=80',
            'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80',
            'https://images.unsplash.com/photo-1543087622-3a5282b996f2?w=800&q=80',
        ];

        foreach ($products as $product) {
            // Add 3 images for each product
            $randomImages = (array) array_rand(array_flip($galleryImages), 3);
            foreach ($randomImages as $index => $image) {
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $image,
                    'sort_order' => $index
                ]);
            }
        }
    }
}
