@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    <h1 class="mb-3">Tambah Villa Baru</h1>
    <div class="card p-4 shadow-sm">
        <form action="{{ route('admin.villas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Pemilik Villa -->
            <div class="mb-3">
                <label class="form-label">Pemilik Villa:</label>
                <select name="user_id" class="form-select" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ ucwords(str_replace('_', ' ', $user->role)) }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Nama Villa -->
            <div class="mb-3">
                <label class="form-label">Nama Villa:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!-- Tipe Villa -->
            <div class="mb-3">
                <label class="form-label">Tipe Villa:</label>
                <select name="type_id" class="form-select" required>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
                <label class="form-label">Deskripsi:</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <!-- Harga per malam -->
            <div class="mb-3">
                <label class="form-label">Harga per malam:</label>
                <input type="number" name="price_per_night" class="form-control" required>
            </div>

            <!-- Kapasitas -->
            <div class="mb-3">
                <label class="form-label">Kapasitas (org):</label>
                <input type="number" name="capacity" class="form-control" required>
            </div>

            <!-- Lokasi -->
            <div class="mb-3">
                <label class="form-label">Lokasi:</label>
                <textarea name="location" class="form-control" rows="2"></textarea>
            </div>

            <!-- Fasilitas -->
            <div class="mb-3">
                <label class="form-label">Fasilitas:</label>
                <div class="row">
                    @foreach ($facilities as $facility)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" name="facilities[]" value="{{ $facility->id }}" class="form-check-input">
                                <label class="form-check-label">{{ $facility->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Gambar -->
            <div class="mb-3">
                <label class="form-label">Gambar (Opsional):</label>
                <input type="file" name="image" class="form-control" id="imageInput" onchange="previewImage(event)">
                <img id="imagePreview" src="#" alt="Preview Gambar" class="img-thumbnail rounded shadow-sm mt-2" style="display: none; width: 200px;">
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">Status:</label>
                <select name="status" class="form-select">
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                </select>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{route('admin.villas.index')}}" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</div>

<!-- JavaScript untuk Preview Gambar -->
<script>
    function previewImage(event) {
        var input = event.target;
        var preview = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
@endsection
