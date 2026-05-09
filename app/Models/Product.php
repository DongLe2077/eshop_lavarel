<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'products';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'quanlity',
        'view',
        'category_id',
    ];

    protected $casts = [
        'price' => 'double',
        'quanlity' => 'integer',
        'view' => 'integer',
    ];

    /**
     * Đăng ký media collections cho sản phẩm.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('products')
            ->singleFile(); // Mỗi sản phẩm chỉ có 1 ảnh chính

        $this->addMediaCollection('gallery'); // Ảnh phụ (gallery)
    }

    /**
     * Lấy URL ảnh sản phẩm (ưu tiên MediaLibrary, fallback về cột image cũ).
     */
    public function getImageUrlAttribute(): string
    {
        $mediaUrl = $this->getFirstMediaUrl('products');
        if ($mediaUrl) {
            return $mediaUrl;
        }
        return $this->image ?: 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=600&h=800&fit=crop';
    }

    /**
     * Tự động tạo slug khi lưu sản phẩm.
     */
    protected static function booted()
    {
        static::saving(function ($product) {
            if (empty($product->slug) || $product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
                
                // Đảm bảo slug là duy nhất (nếu cần xử lý trùng lặp phức tạp hơn có thể thêm ở đây)
                $originalSlug = $product->slug;
                $count = 1;
                while (static::where('slug', $product->slug)->where('id', '!=', $product->id)->exists()) {
                    $product->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }

    /**
     * Sử dụng slug thay cho id trong route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Lấy danh mục của sản phẩm.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Lấy các hình ảnh phụ của sản phẩm.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
    }

    /**
     * Format giá tiền hiển thị.
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.') . 'đ';
    }
}
