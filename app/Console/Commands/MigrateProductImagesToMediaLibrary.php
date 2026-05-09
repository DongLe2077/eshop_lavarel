<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Exception;

class MigrateProductImagesToMediaLibrary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:migrate-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chuyển đổi URL ảnh từ cột image cũ sang Spatie MediaLibrary';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::whereNotNull('image')
            ->where('image', '!=', '')
            ->get();

        $this->info("Bắt đầu chuyển đổi cho " . $products->count() . " sản phẩm...");

        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        foreach ($products as $product) {
            // Kiểm tra xem sản phẩm đã có media chưa (tránh trùng lặp)
            if ($product->hasMedia('products')) {
                $bar->advance();
                continue;
            }

            try {
                // Tải ảnh từ URL và thêm vào MediaLibrary
                $product->addMediaFromUrl($product->image)
                    ->toMediaCollection('products');
            } catch (Exception $e) {
                $this->error("\nLỗi khi tải ảnh cho sản phẩm #{$product->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->info("\n✅ Hoàn thành chuyển đổi!");
    }
}
