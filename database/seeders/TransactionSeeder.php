<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Payment;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        // Create Example Transaction
        $transaction = Transaction::create([
            'customer_id' => 1, // Example customer ID
            'villa_id' => 1,    // Example villa ID
            'check_in' => '2025-02-10',
            'check_out' => '2025-02-15',
            'status' => 'Pending',
            'total_price' => 1500000, // Example price
        ]);

        // Create Payment for the Transaction
        Payment::create([
            'transaction_id' => $transaction->id,
            'price' => $transaction->total_price,
            'status' => 'Unpaid',
            'payment_method' => 'bank_transfer', // Example payment method
        ]);
    }
}
