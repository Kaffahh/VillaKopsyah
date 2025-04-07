@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    
                        <div class="card-header d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Edit Villa</h4>
                            <a href="{{ route('admin.villas.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('admin.villas.update', $villa->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        <!-- Pemilik Villa -->
                                        <div class="mb-3">
                                            <label class="form-label">Pemilik Villa</label>
                                            <select name="user_id"
                                                class="form-select @error('user_id') is-invalid @enderror" required>
                                                <option value="">Pilih Pemilik Villa</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ $villa->user_id == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Nama Villa -->
                                        <div class="mb-3">
                                            <label class="form-label">Nama Villa</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name', $villa->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Tipe Villa -->
                                        <div class="mb-3">
                                            <label class="form-label">Tipe Villa</label>
                                            <select name="type_id"
                                                class="form-select @error('type_id') is-invalid @enderror" required>
                                                <option value="">Pilih Tipe Villa</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ $villa->type_id == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('type_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Harga per Malam -->
                                        <div class="mb-3">
                                            <label class="form-label">Harga per Malam</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" name="price_per_night"
                                                    class="form-control @error('price_per_night') is-invalid @enderror"
                                                    value="{{ old('price_per_night', $latestPrice->price_per_night ?? '') }}"
                                                    required>
                                            </div>
                                            @error('price_per_night')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Kapasitas -->
                                        <div class="mb-3">
                                            <label class="form-label">Kapasitas (Orang)</label>
                                            <input type="number" name="capacity"
                                                class="form-control @error('capacity') is-invalid @enderror"
                                                value="{{ old('capacity', $latestCapacity->capacity ?? '') }}" required>
                                            @error('capacity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6">
                                        <!-- Lokasi -->
                                        <div class="mb-3">
                                            <label class="form-label">Lokasi</label>
                                            <input type="text" name="location"
                                                class="form-control @error('location') is-invalid @enderror"
                                                value="{{ old('location', $villa->location) }}" required>
                                            @error('location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select @error('status') is-invalid @enderror"
                                                required>
                                                <option value="available"
                                                    {{ $villa->status == 'available' ? 'selected' : '' }}>
                                                    Tersedia
                                                </option>
                                                <option value="booked" {{ $villa->status == 'booked' ? 'selected' : '' }}>
                                                    Dibooking
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Deskripsi -->
                                        <div class="mb-3">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $villa->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Fasilitas -->
                                        <div class="mb-3">
                                            <label class="form-label">Fasilitas</label>
                                            <div class="row">
                                                @foreach ($facilities as $facility)
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="facilities[]"
                                                                value="{{ $facility->id }}" class="form-check-input"
                                                                {{ in_array($facility->id, $villa->facilities->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                            <label class="form-check-label">{{ $facility->name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('facilities')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Gambar Utama -->
                                        <div class="mb-3">
                                            <label class="form-label">Gambar Utama</label>
                                            @if ($villa->image)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $villa->image) }}"
                                                        class="img-thumbnail" style="height: 100px;">
                                                </div>
                                            @endif
                                            <input type="file" name="image"
                                                class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah
                                                gambar</small>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Gambar Tambahan -->
                                        <div class="mb-3">
                                            <label class="form-label">Gambar Tambahan (Maksimal 4)</label>

                                            <!-- Preview Gambar yang Ada -->
                                            @if ($villa->images->count() > 0)
                                                <div class="row mb-3">
                                                    @foreach ($villa->images as $image)
                                                        <div class="col-md-3 mb-2">
                                                            <div class="position-relative">
                                                                <img src="{{ asset('storage/' . $image->url) }}"
                                                                    class="img-thumbnail w-100"
                                                                    style="height: 150px; object-fit: cover;">
                                                                <!-- Tombol Hapus -->
                                                                <form
                                                                    action="{{ route('admin.villa.image.delete', $image->id) }}"
                                                                    method="POST" class="position-absolute"
                                                                    style="top: 5px; right: 5px;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Yakin ingin menghapus gambar ini?')">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <!-- Upload Gambar Baru -->
                                            <div class="mb-2">
                                                <input type="file" name="images[]"
                                                    class="form-control @error('images.*') is-invalid @enderror"
                                                    accept="image/*" multiple>
                                                <small class="text-muted">
                                                    Upload beberapa gambar sekaligus. Format: JPG, PNG, GIF (Max: 2MB per
                                                    gambar)
                                                </small>
                                            </div>
                                            @error('images.*')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
