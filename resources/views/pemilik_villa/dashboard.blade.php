@extends('layouts.app')

@section('content')
    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <!-- Notifikasi -->
                    @if (auth()->user()->unreadNotifications->isNotEmpty())
                        <div class="alert alert-info m-3">
                            <h4>Notifikasi</h4>
                            <ul>
                                @foreach (auth()->user()->unreadNotifications as $notification)
                                    <li>
                                        {{ $notification->data['message'] }}
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info">Tandai Sudah Dibaca</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">
                        <h2>You are a Pemilik Villa.</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Villa -->
        <div class="mt-4">
            <h3>Daftar Villa Saya</h3>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createVillaModal">Tambah Villa</button>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card p-4 shadow-sm">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Nama Villa</th>
                            <th>Tipe</th>
                            <th>Harga / Malam</th>
                            <th>Kapasitas</th>
                            <th>Fasilitas</th>
                            <th>Foto Lainnya</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($villas as $villa)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $villa->image) }}" alt="Thumbnail" class="img-thumbnail" width="100">
                                    <br>{{ $villa->name }}
                                </td>
                                <td>{{ $villa->type->name }}</td>
                                <td>Rp {{ number_format($villa->prices->last()->price_per_night ?? 0, 0, ',', '.') }}</td>
                                <td>{{ $villa->capacities->last()->capacity ?? 0 }} orang</td>
                                <td>
                                    @if ($villa->facilities->isNotEmpty())
                                        <ul class="list-unstyled">
                                            @foreach ($villa->facilities as $facility)
                                                <li>- {{ $facility->name }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">Tidak ada fasilitas</span>
                                    @endif
                                </td>
                                <td>
                                    @foreach ($villa->images as $image)
                                        <img src="{{ asset('storage/' . $image->url) }}" class="img-thumbnail" width="150">
                                    @endforeach
                                </td>
                                <td>{{ ucfirst($villa->status) }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#editVillaModal" data-id="{{ $villa->id }}" data-name="{{ $villa->name }}" data-type_id="{{ $villa->type_id }}" data-price="{{ $villa->prices->last()->price_per_night ?? 0 }}" data-capacity="{{ $villa->capacities->last()->capacity ?? 0 }}" data-description="{{ $villa->description }}" data-location="{{ $villa->location }}" data-status="{{ $villa->status }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('pemilik_villa.villas.destroy', $villa->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus villa ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@section('modal')
    @include('pemilik_villa.villas.modal_create')
    @include('pemilik_villa.villas.modal_edit')
@endsection
<script>
    function previewMultipleImages(event) {
        var input = event.target;
        var previewContainer = document.getElementById('multipleImagesPreview');
        previewContainer.innerHTML = '';

        if (input.files) {
            let count = Math.min(input.files.length, 4); // Maksimal 4 gambar
            for (let i = 0; i < count; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'm-1', 'shadow-sm');
                    img.style.width = '100px';
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    }
</script>

@endsection
