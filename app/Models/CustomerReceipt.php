<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'receipt_date',
        'sales_person',
        'payment_method',
        'amount',
    ];
}
