<?php

namespace App\Http\Controllers;

use App\Models\SupplierInvoice;
use Illuminate\Http\Request;

class SupplierInvoiceController extends Controller
{
    public function index()
    {
        $invoices = SupplierInvoice::all();
        return view('transactions.index', compact('invoices'));
    }

    public function create()
    {
        return view('transactions.create_invoice');
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required',
            'invoice_date' => 'required|date',
            'supplier_name' => 'required',
            'payment_method' => 'required',
            'amount_due' => 'required|numeric',
        ]);

        SupplierInvoice::create($request->all());
        return redirect()->route('transactions.index');
    }
}
