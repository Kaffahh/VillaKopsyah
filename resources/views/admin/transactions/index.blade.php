@extends('layouts.app')

@section('title', 'Kelola Transaksi')

@section('content')
<div class="container">
    <h2 class="my-4">Kelola Transaksi</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr class="text-center">
                <th>ID</th>
                <th>User</th>
                <th>Email</th>
                <th>Villa</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ optional($transaction->customer->user)->name }}</td>
                    <td>{{ optional($transaction->customer->user)->email }}</td>
                    <td>{{ optional($transaction->villa)->name }}</td>
                    <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge 
                            @if($transaction->status == 'Pending') bg-warning
                            @elseif($transaction->status == 'Paid') bg-success
                            @elseif($transaction->status == 'Cancelled') bg-danger
                            @else bg-info
                            @endif">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" class="d-inline">
                            @csrf @method('PUT')
                            <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $transaction->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $transactions->links() }}
</div>
@endsection
