<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    
    protected $table = 'suppliers'; // Table name
    protected $primaryKey = 'supplier_code'; // Set the primary key to supplier_code
    public $incrementing = false;  // Disable auto-incrementing for the primary key
    protected $keyType = 'string'; // Primary key is a string

    protected $fillable = ['supplier_code', 'name', 'email', 'phone'];

    // Relationship with Product
    public function products()
    {
        return $this->hasMany(Product::class, 'supplier_code', 'supplier_code');
    }

    public function list()
{
    $suppliers = Supplier::all(); // Fetch all suppliers from the database
    return view('System.SuppliersList', compact('suppliers'));
}
}
