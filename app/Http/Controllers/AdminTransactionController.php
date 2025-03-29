<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminTransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index()
    {
        $transactions = Transaction::with('customer', 'villa')->latest()->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        return view('admin.transactions.create');
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'villa_id' => 'required|exists:villas,id',
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,approved,rejected'
        ]);

        Transaction::create($request->all());

        Session::flash('success', 'Transaksi berhasil ditambahkan!');
        return redirect()->route('admin.transactions.index');
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(Transaction $transaction)
    {
        return view('admin.transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $transaction->update($request->all());

        Session::flash('success', 'Transaksi berhasil diperbarui!');
        return redirect()->route('admin.transactions.index');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        Session::flash('success', 'Transaksi berhasil dihapus!');
        return redirect()->route('admin.transactions.index');
    }
}
