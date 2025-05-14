<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // Explicitly define the table name (optional)

  protected $fillable = [
    'sku', 'name', 'quantity', 'cost_price', 'price', 'category', 'supplier_code', 'image', 'barcode',
];


  // Generate barcode dynamically
  public function generateBarcode()
  {
      return \DNS1D::getBarcodeHTML($this->barcode, 'C39');
  }

      // Relationship with Supplier
      public function supplier()
      {
          return $this->belongsTo(Supplier::class, 'supplier_code', 'id');
      }

        // Accessor for Image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-product.png');
    }

     public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
