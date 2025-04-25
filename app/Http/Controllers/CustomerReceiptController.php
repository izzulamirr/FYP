<?php

namespace App\Http\Controllers;

use App\Models\CustomerReceipt;
use Illuminate\Http\Request;

class CustomerReceiptController extends Controller
{
    public function index()
    {
        $receipts = CustomerReceipt::all();
        return view('transactions.index', compact('receipts'));
    }

    public function create()
    {
        return view('transactions.create_receipt');
    }

    public function store(Request $request)
    {
        $request->validate([
            'receipt_number' => 'required',
            'receipt_date' => 'required|date',
            'sales_person' => 'required',
            'payment_method' => 'required',
            'amount' => 'required|numeric',
        ]);

        CustomerReceipt::create($request->all());
        return redirect()->route('transactions.index');
    }
}
