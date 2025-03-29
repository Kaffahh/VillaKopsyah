@extends('layouts.pelanggan')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Gallery -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div id="villaCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('storage/' . $villa->image) }}" class="d-block w-100" alt="Main Image">
                        </div>
                        @foreach($villa->images as $image)
                        <div class="carousel-item">
                            <img src="{{ asset('storage/' . $image->url) }}" class="d-block w-100" alt="Villa Image">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#villaCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#villaCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Info dan Booking -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">{{ $villa->name }}</h3>
                    <p class="text-muted">{{ $villa->type->name }}</p>
                    <hr>
                    <div class="mb-3">
                        <h5 class="text-primary">
                            Rp {{ number_format($villa->prices->last()->price_per_night, 0, ',', '.') }}
                            <small class="text-muted">/malam</small>
                        </h5>
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-people"></i> Kapasitas: {{ $villa->capacities->last()->capacity }} Orang
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-geo-alt"></i> {{ $villa->location }}
                    </div>
                    <hr>
                    {{-- <form action="{{ route('customers.bookings.store') }}" method="POST"> --}}
                    <form action="" method="POST">
                        @csrf
                        <input type="hidden" name="villa_id" value="{{ $villa->id }}">
                        <div class="mb-3">
                            <label class="form-label">Check-in</label>
                            <input type="date" name="check_in" class="form-control" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Check-out</label>
                            <input type="date" name="check_out" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            Pesan Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Deskripsi dan Fasilitas -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Deskripsi</h5>
                    <p>{{ $villa->description }}</p>
                    <hr>
                    <h5>Fasilitas</h5>
                    <div class="row g-3">
                        @foreach($villa->facilities as $facility)
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                {{ $facility->name }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Villa Serupa -->
        @if($similarVillas->count() > 0)
        <div class="col-12">
            <h4 class="mb-3">Villa Serupa</h4>
            <div class="row g-4">
                @foreach($similarVillas as $similar)
                <div class="col-md-3">
                    <div class="card shadow-sm h-100">
                        <img src="{{ asset('storage/' . $similar->image) }}" class="card-img-top" alt="{{ $similar->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $similar->name }}</h5>
                            <p class="card-text">
                                Rp {{ number_format($similar->prices->last()->price_per_night, 0, ',', '.') }}/malam
                            </p>
                            <a href="{{ route('customers.villas.show', $similar->id) }}" class="btn btn-sm btn-outline-primary">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validasi tanggal check-out harus setelah check-in
    const checkIn = document.querySelector('input[name="check_in"]');
    const checkOut = document.querySelector('input[name="check_out"]');

    checkIn.addEventListener('change', function() {
        checkOut.min = this.value;
    });
});
</script>
@endpush
@endsection