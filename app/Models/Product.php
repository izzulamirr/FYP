<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // Explicitly define the table name (optional)

    protected $fillable = [
    'sku', 
    'name',
    'quantity', 
    'price', 
    'category',
    'supplier_code'];

      // Relationship with Supplier
      public function supplier()
      {
          return $this->belongsTo(Supplier::class, 'supplier_code', 'id');
      }
}
