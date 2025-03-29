@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Daftar Fasilitas</h2>

        <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary mb-3">Tambah Fasilitas</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Fasilitas</th>
                        <th>Detail</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facilities as $facility)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $facility->name }}</td>
                            <td>{{ $facility->detail ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.facilities.edit', $facility->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
