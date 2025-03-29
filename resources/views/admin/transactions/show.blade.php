@extends('layouts.app')

@section('title', 'Detail Transaksi Admin')

@section('content')
    <div class="container">
        <div class="card shadow-lg p-4">
            <h2 class="mb-4">Detail Transaksi #{{ $transaction->id }}</h2>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>User:</strong> {{ $transaction->customer->user->name }}</p>
                    <p><strong>Email:</strong> {{ $transaction->customer->user->email }}</p>
                    <p><strong>Villa:</strong> {{ optional($transaction->villa)->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Total Harga:</strong> <span class="fw-bold text-success">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span></p>
                    <p><strong>Status:</strong>
                        <span class="badge 
                        @if ($transaction->status == 'pending') bg-warning
                        @elseif($transaction->status == 'paid') bg-success
                        @elseif($transaction->status == 'cancelled') bg-danger
                        @else bg-info @endif">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </p>
                    <p><strong>Tanggal Booking:</strong> {{ $transaction->booking_date }}</p>
                    <p><strong>Dibuat Pada:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <h3 class="mt-4">Update Status</h3>
            <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <select name="status" class="form-select">
                            <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $transaction->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </div>
            </form>

            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
@endsection
