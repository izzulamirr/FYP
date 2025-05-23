<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{
    public function getProductByBarcode($barcode)
    {
        $product = Product::where('barcode', $barcode)->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'cost_price' => $product->cost_price,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'barcode' => $product->barcode,
                ],
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Product not found!'], 404);
    }

    public function updateQuantity(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Decrement the quantity but ensure it doesn't go below 0
    $newQuantity = max(0, $product->quantity - $request->input('quantity_to_decrement'));

    $product->update(['quantity' => $newQuantity]);

    return redirect()->back()->with('success', 'Product quantity updated successfully.');
}

public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->route('inventory.index')->with('success', 'Product deleted successfully.');
}
}
