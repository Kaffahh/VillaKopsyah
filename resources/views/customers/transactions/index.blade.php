@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Transaction List</h1>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Transaction ID</th>
                    <th>Customer</th>
                    <th>Villa</th>
                    <th>Status</th>
                    <th>Total Price</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->customer->fullname }}</td>
                        <td>{{ $transaction->villa->name }}</td>
                        <td>
                            @if ($transaction->status === 'Pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($transaction->status === 'Completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif ($transaction->status === 'Cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-secondary">{{ $transaction->status }}</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td>
                            @if ($transaction->payment)
                                @if ($transaction->payment->status === 'Paid')
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-danger">Unpaid</span>
                                @endif
                            @else
                                <span class="badge bg-secondary">No Payment</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
