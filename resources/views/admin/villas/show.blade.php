@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Detail Villa</h4>
                        <a href="{{ route('admin.villas.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="row">
                        <!-- Gallery -->
                        <div class="col-md-6 mb-4">
                            <div id="villaCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('storage/' . $villa->image) }}" 
                                             class="d-block w-100 rounded" 
                                             alt="Main Image"
                                             style="height: 400px; object-fit: cover;">
                                    </div>
                                    @foreach($villa->images as $image)
                                    <div class="carousel-item">
                                        <img src="{{ asset('storage/' . $image->url) }}" 
                                             class="d-block w-100 rounded" 
                                             alt="Villa Image"
                                             style="height: 400px; object-fit: cover;">
                                    </div>
                                    @endforeach
                                </div>
                                @if($villa->images->count() > 0)
                                <button class="carousel-control-prev" type="button" data-bs-target="#villaCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#villaCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                                @endif
                            </div>
                        </div>

                        <!-- Informasi Villa -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $villa->name }}</h5>
                                    <p class="text-muted">{{ $villa->type->name }}</p>
                                    
                                    <hr>
                                    
                                    <div class="mb-3">
                                        <strong>Pemilik:</strong>
                                        <p>{{ $villa->user->name }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Harga per Malam:</strong>
                                        <p class="text-primary">
                                            Rp {{ number_format($villa->prices->last()->price_per_night, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Kapasitas:</strong>
                                        <p>{{ $villa->capacities->last()->capacity }} Orang</p>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        <span class="badge bg-{{ $villa->status === 'available' ? 'success' : 'warning' }}">
                                            {{ $villa->status === 'available' ? 'Tersedia' : 'Dibooking' }}
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Lokasi:</strong>
                                        <p>{{ $villa->location }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Deskripsi:</strong>
                                        <p>{{ $villa->description ?: 'Tidak ada deskripsi' }}</p>
                                    </div>

                                    <hr>

                                    <div class="mb-3">
                                        <strong>Fasilitas:</strong>
                                        <div class="row mt-2">
                                            @forelse($villa->facilities as $facility)
                                            <div class="col-md-6 mb-2">
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                {{ $facility->name }}
                                            </div>
                                            @empty
                                            <div class="col-12">
                                                <p class="text-muted">Tidak ada fasilitas</p>
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <a href="{{ route('admin.villas.edit', $villa->id) }}" 
                                           class="btn btn-primary me-2">
                                            <i class="bi bi-pencil"></i> Edit Villa
                                        </a>
                                        <form action="{{ route('admin.villas.destroy', $villa->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus villa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash"></i> Hapus Villa
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Villa Serupa -->
                    @if($similarVillas->count() > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Villa Serupa</h5>
                            <div class="row">
                                @foreach($similarVillas as $similarVilla)
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="{{ asset('storage/' . $similarVilla->image) }}" 
                                             class="card-img-top"
                                             alt="{{ $similarVilla->name }}"
                                             style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $similarVilla->name }}</h6>
                                            <p class="card-text">
                                                Rp {{ number_format($similarVilla->prices->last()->price_per_night, 0, ',', '.') }}/malam
                                            </p>
                                            <a href="{{ route('admin.villas.show', $similarVilla->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection