@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header py-3"><h4 class="mb-0">Daftar Fasilitas</h4></div>
        <div class="card-body">
            <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary mb-3">Tambah Fasilitas</a>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
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
                                    <a href="{{ route('admin.facilities.edit', $facility->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
