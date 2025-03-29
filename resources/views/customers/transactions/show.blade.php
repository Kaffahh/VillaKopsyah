@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>Transaction #{{ $transaction->id }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Customer:</strong> {{ $transaction->customer->fullname }}</p>
                <p><strong>Villa:</strong> {{ $transaction->villa->name }}</p>
                <p><strong>Check-In:</strong> {{ \Carbon\Carbon::parse($transaction->check_in)->format('d M Y') }}</p>
                <p><strong>Check-Out:</strong> {{ \Carbon\Carbon::parse($transaction->check_out)->format('d M Y') }}</p>
                <p>
                    <strong>Status:</strong>
                    @if ($transaction->status === 'Pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif ($transaction->status === 'Completed')
                        <span class="badge bg-success">Completed</span>
                    @elseif ($transaction->status === 'Cancelled')
                        <span class="badge bg-danger">Cancelled</span>
                    @else
                        <span class="badge bg-secondary">{{ $transaction->status }}</span>
                    @endif
                </p>
                <p><strong>Total Price:</strong> Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>

                <hr>

                <h4>Payment Information</h4>
                @if ($transaction->payment)
                    <p>
                        <strong>Status:</strong>
                        @if ($transaction->payment->status === 'Paid')
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-danger">Unpaid</span>
                        @endif
                    </p>
                    <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $transaction->payment->payment_method)) }}</p>

                    @if ($transaction->payment->payment_proof)
                        <p><strong>Payment Proof:</strong></p>
                        <img src="{{ asset('storage/' . $transaction->payment->payment_proof) }}" class="img-fluid" style="max-width: 300px;">
                    @endif
                @else
                    <p class="text-danger">No Payment Data Available.</p>
                @endif

                @if ($transaction->payment && $transaction->payment->status == 'Unpaid')
                    <hr>
                    <h5>Upload Payment Proof</h5>
                    <form action="{{ route('transactions.updatePayment', $transaction->payment->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Upload Payment Proof:</label>
                            <input type="file" name="payment_proof" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Submit Payment</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
