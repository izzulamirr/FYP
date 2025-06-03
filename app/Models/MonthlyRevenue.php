<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyRevenue extends Model
{
    use HasFactory;

     protected $fillable = [
        'year',
        'month',
        'revenue',
        'total_sales',
    'total_cost',
    ];
}
