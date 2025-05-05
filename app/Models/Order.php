<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_name',
        'total',
        'delivery_status',
        'order_date',
        'completed_date',
        'invoice_slip',
    ];
}