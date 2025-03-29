@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Tambah Customer</a>
                        <h2>Daftar Customer</h2>
                        <table class="table" border="1">
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Address</th>
                                <th scope="col" class="text-center">Gender</th>
                                <th scope="col" class="text-center">Job</th>
                                <th scope="col" class="text-center">Birthdate</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->user->name }}</td>
                                    <td>{{ $customer->user->email }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td class="text-center">{{ $customer->gender }}</td>
                                    <td class="text-center">{{ $customer->job }}</td>
                                    <td class="text-center">{{ $customer->birthdate }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
