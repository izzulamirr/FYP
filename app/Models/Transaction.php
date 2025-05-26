<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'products',
        'quantity',
        'total_price',
        'payment_method',
        'payment_time', // Ensure this is fillable
    ];

    protected $casts = [
        'payment_time' => 'datetime', // Cast payment_time to a datetime instance
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
