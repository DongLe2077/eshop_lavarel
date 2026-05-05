<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'order';

    public $timestamps = false;

    protected $fillable = [
        'code', 
        'status', 
        'user_id', 
        'first_name', 
        'last_name', 
        'email', 
        'phone', 
        'address', 
        'city', 
        'zip', 
        'total_price'
    ];

    /**
     * Lấy người dùng đã đặt đơn hàng.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Lấy chi tiết đơn hàng.
     */
    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
