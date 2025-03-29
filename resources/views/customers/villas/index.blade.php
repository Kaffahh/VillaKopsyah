@extends('layouts.pelanggan')

@section('content')
<div class="container py-4">
    <!-- Filter Section -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('customers.villas.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="location" class="form-control" value="{{ request('location') }}" placeholder="Cari lokasi...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipe Villa</label>
                        <select name="type" class="form-select">
                            <option value="">Semua Tipe</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" name="capacity" class="form-control" value="{{ request('capacity') }}" min="1">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Rentang Harga</label>
                        <div class="d-flex gap-2">
                            <input type="number" name="price_min" class="form-control" placeholder="Min" value="{{ request('price_min') }}">
                            <input type="number" name="price_max" class="form-control" placeholder="Max" value="{{ request('price_max') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Cari Villa
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Villa List -->
    <div class="row g-4">
        @forelse($villas as $villa)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm hover-scale">
                <img src="{{ asset('storage/' . $villa->image) }}" class="card-img-top" alt="{{ $villa->name }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $villa->name }}</h5>
                    <p class="card-text text-muted">{{ $villa->type->name }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-primary fw-bold">
                            Rp {{ number_format($villa->prices->last()->price_per_night, 0, ',', '.') }}/malam
                        </span>
                        <span class="badge bg-info">
                            <i class="bi bi-people"></i> {{ $villa->capacities->last()->capacity }} Orang
                        </span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-geo-alt"></i> {{ $villa->location }}
                        </small>
                        <a href="{{ route('customers.villas.show', $villa->id) }}" class="btn btn-sm btn-outline-primary">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-house-x display-1 text-muted"></i>
            <p class="mt-3">Tidak ada villa yang tersedia</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $villas->links() }}
    </div>
</div>
@endsection