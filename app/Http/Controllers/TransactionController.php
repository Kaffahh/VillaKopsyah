<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function customerTransactions()
    {
        $user = Auth::user();

        // Ambil transaksi berdasarkan customer_id yang sesuai dengan user yang login
        $transactions = Transaction::whereHas('customer', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['customer', 'villa', 'payment'])->get();

        return view('customers.transactions.index', compact('transactions'));
    }
    public function customerTransactionShow($id)
    {
        $user = Auth::user();

        $transaction = Transaction::whereHas('customer', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['customer', 'villa', 'payment'])->findOrFail($id);

        return view('customers.transactions.show', compact('transaction'));
    }

    /**
     * Mengupdate bukti pembayaran.
     */
    public function updatePayment(Request $request, $paymentId)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $payment = Payment::findOrFail($paymentId);

        // Pastikan hanya pelanggan yang terkait dengan transaksi ini yang dapat mengunggah bukti pembayaran
        if ($payment->transaction->customer->user_id !== Auth::id()) {
            return redirect()->route('customer.transactions.index')->with('error', 'Unauthorized action.');
        }

        // Simpan bukti pembayaran
        if ($request->hasFile('payment_proof')) {
            // Hapus bukti pembayaran lama jika ada
            if ($payment->payment_proof) {
                Storage::delete($payment->payment_proof);
            }

            // Simpan file baru
            $filePath = $request->file('payment_proof')->store('payment_proofs', 'public');
            $payment->payment_proof = $filePath;
            $payment->status = 'Pending'; // Status menjadi pending sampai admin memverifikasi
            $payment->save();
        }

        return redirect()->route('customer.transactions.show', $payment->transaction_id)->with('success', 'Payment proof uploaded successfully. Please wait for admin verification.');
    }
}

    // public function index()
    // {
    //     $transactions = Transaction::with(['customer.user', 'villa', 'payment'])->get();
    //     return view('transactions.index', compact('transactions'));
    // }

    // public function create()
    // {
    //     return view('transactions.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'customer_id' => 'required',
    //         'villa_id' => 'required',
    //         'check_in' => 'required|date',
    //         'check_out' => 'required|date|after:check_in',
    //         'total_price' => 'required|numeric',
    //     ]);

    //     $transaction = Transaction::create($request->all());

    //     Payment::create([
    //         'transaction_id' => $transaction->id,
    //         'price' => $transaction->total_price,
    //         'status' => 'Unpaid',
    //         'payment_method' => $request->payment_method,
    //     ]);

    //     return redirect()->route('transactions.index');
    // }

    // public function show($id)
    // {
    //     $transaction = Transaction::with(['customer.user', 'villa', 'payment'])->findOrFail($id);
    //     return view('transactions.show', compact('transaction'));
    // }

    // public function updatePayment(Request $request, $id)
    // {
    //     $request->validate([
    //         'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     $payment = Payment::findOrFail($id);

    //     // Simpan gambar ke storage/app/public/payment_proofs/
    //     if ($request->hasFile('payment_proof')) {
    //         $file = $request->file('payment_proof');
    //         $filePath = $file->store('payment_proofs', 'public'); // Simpan ke storage/public/payment_proofs

    //         // Simpan path ke database
    //         $payment->payment_proof = $filePath;
    //         $payment->status = 'Paid'; // Ubah status menjadi Paid
    //         $payment->save();
    //     }

    //     return redirect()->back()->with('success', 'Payment proof uploaded successfully!');
    // }
// }
