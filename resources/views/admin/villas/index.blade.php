@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-3">Daftar Villa</h1>

        <a href="{{ route('admin.villas.create') }}" class="btn btn-primary mb-3">Tambah Villa</a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Deskripsi</th>
                        <th>Harga/malam</th>
                        <th>Kapasitas</th>
                        <th>Lokasi</th>
                        <th>Fasilitas</th>
                        <th>Thumbnail</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($villas as $villa)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $villa->name ?? 'Tidak tersedia' }}</td>
                            <td>{{ optional($villa->type)->name ?? 'Tidak ada tipe' }}</td>
                            <td>{{ $villa->description ?? 'Tidak ada deskripsi' }}</td>
                            <td>Rp {{ number_format($villa->prices->last()->price_per_night, 0, ',', '.') }}</td>
                            <td>{{ $villa->capacities->last()->capacity ?? 'Tidak tersedia' }}</td>
                            <td>{{ $villa->location ?? 'Tidak tersedia' }}</td>
                            <td>
                                @if ($villa->facilities && $villa->facilities->isNotEmpty())
                                    <ul class="list-unstyled">
                                        @foreach ($villa->facilities as $facility)
                                            <li><span class="badge bg-primary">{{ $facility->name }}</span></li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Tidak ada fasilitas</span>
                                @endif
                            </td>
                            <td>
                                @if ($villa->image && file_exists(public_path('storage/' . $villa->image)))
                                    <img src="{{ asset('storage/' . $villa->image) }}" alt="Villa Image" class="img-thumbnail" style="width: 100px;">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $villa->status == 'available' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($villa->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.villas.edit', $villa->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.villas.destroy', $villa->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus villa ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($villas->isEmpty())
            <div class="alert alert-warning text-center mt-3">Tidak ada data villa tersedia.</div>
        @endif
    </div>
@endsection
