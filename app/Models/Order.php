<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   // Set the primary key to 'order_id'
    protected $primaryKey = 'order_id';

    // Disable auto-incrementing if 'order_id' is not an integer
    public $incrementing = false;

    // Set the key type to string if 'order_id' is not an integer
    protected $keyType = 'string';

    // Fillable fields for mass assignment
    protected $fillable = [
        'order_id',        // Unique identifier for the order
        'supplier_name',   // Name of the supplier
        'total',           // Total price of the order
        'delivery_status', // Status of the delivery (e.g., pending, delivered)
        'order_date',      // Date the order was placed
        'completed_date',  // Date the order was completed
        'invoice_slip',    // Path to the invoice slip
        'products',        // JSON field for products in the order
    ];

    // Relationship with Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_code', 'supplier_code'); // Use supplier_code for the relationship
    }

     


}