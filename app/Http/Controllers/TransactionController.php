<?php
namespace App\Http\Controllers;

use App\Models\Order; // Import the Order model
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        $orders = Order::all();
        return view('System.Transactions.index', compact('transactions', 'orders'));
    }

    public function showSupplierInvoice($id)
    {
        $order = \App\Models\Order::findOrFail($id); // Fetch the order by ID
        return view('System.Invoice', compact('order')); // Pass the order to the Invoice view
    }
}