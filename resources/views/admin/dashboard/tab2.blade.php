<div class="row">
    <!-- Top 3 Villa Terbanyak Dikunjungi -->
    <div class="col-md-6 mb-3">
        <div class="card p-3 border-0 shadow-sm h-100">
            <h6 class="text-muted mb-3">Top 3 Villa Terbanyak Dikunjungi</h6>
            <div class="list-group list-group-flush">
                @forelse($topVillas as $villa)
                <div class="list-group-item list-group-item-action" 
                     data-bs-toggle="modal" 
                     data-bs-target="#villaDetailModal" 
                     onclick="showVillaDetail('{{ $villa->id }}')"
                     style="cursor: pointer;">
                    <div class="d-flex align-items-center p-2">
                        <img src="{{ asset('storage/' . $villa->image) }}" alt="Villa Image" 
                             class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $villa->name }}</h6>
                            <small class="text-muted">Pemilik: {{ $villa->user->name }}</small>
                        </div>
                        <span class="badge bg-primary">{{ $villa->transactions_count }} Transaksi</span>
                    </div>
                </div>
                @empty
                <div class="list-group-item text-center text-muted py-4">
                    <i class="bi bi-house-x" style="font-size: 24px;"></i>
                    <p class="mt-2 mb-0">Tidak ada data villa</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top 3 Pemilik Villa Terbanyak -->
    <div class="col-md-6 mb-3">
        <div class="card p-3 border-0 shadow-sm h-100">
            <h6 class="text-muted mb-3">Top 3 Pemilik Villa Terbanyak</h6>
            <div class="list-group list-group-flush">
                @forelse($topOwners as $owner)
                <div class="list-group-item list-group-item-action"
                     onclick="showOwnerDetail('{{ $owner->id }}')">
                    <div class="d-flex align-items-center p-2">
                        <i class="bi bi-person-circle text-secondary me-3" style="font-size: 35px;"></i>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $owner->name }}</h6>
                            <small class="text-muted">{{ $owner->email }}</small>
                        </div>
                        <span class="badge bg-warning text-dark">{{ $owner->villas_count }} Villa</span>
                    </div>
                </div>
                @empty
                <div class="list-group-item text-center text-muted py-4">
                    <i class="bi bi-person-x" style="font-size: 24px;"></i>
                    <p class="mt-2 mb-0">Tidak ada data pemilik villa</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Villa -->
<div class="modal fade" id="villaDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Villa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="villaDetailContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Pemilik -->
<div class="modal fade" id="ownerDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pemilik Villa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="ownerDetailContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Pertambahan Villa -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card p-3 border-0 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-muted mb-0">Grafik Pertambahan Villa</h6>
                <select id="filterGrafikVilla" class="form-select form-select-sm w-auto border">
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan">Bulanan</option>
                </select>
            </div>
            <div style="height: 300px;">
                <canvas id="villaChart"></canvas>
            </div>
        </div>
    </div>
</div>
