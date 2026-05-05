<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    public $timestamps = false;

    protected $fillable = [
        'quanlity',
        'price',
        'order_detailscol',
        'order_id',
        'product_id',
    ];

    protected $casts = [
        'price' => 'double',
        'quanlity' => 'integer',
    ];

    /**
     * Lấy đơn hàng chứa chi tiết này.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Lấy sản phẩm trong chi tiết đơn hàng.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
