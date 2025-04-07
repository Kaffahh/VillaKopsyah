@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3"><h4 class="mb-0">Daftar Customer</h4></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Tambah Customer</a>
                    </div>
                    
                    <table class="table table-bordered table-hover text-center table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Address</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Job</th>
                                <th scope="col">Birthdate</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->user->name }}</td>
                                    <td>{{ $customer->user->email }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->gender }}</td>
                                    <td>{{ $customer->job }}</td>
                                    <td>{{ $customer->birthdate }}</td>
                                    <td>
                                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        
                                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada customer ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection