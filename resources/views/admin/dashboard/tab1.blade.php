<div class="row">
    <!-- Card Total Pemilik Villa Baru Hari Ini -->
    <div class="col-md-4 mb-3">
        <div class="card p-3 mb-3 border-0 shadow-sm">
            <div class="d-flex justify-content-around align-items-center">
                <div class="text-center">
                    <h6 class="text-muted mb-2">Total Pemilik Villa Baru Hari Ini</h6>
                    <h2 class="fw-bold text-primary" id="totalPemilikHariIni">{{ $newVillaOwnersToday }}</h2>
                </div>
                <i class="bi bi-house-door text-primary opacity-25" style="font-size: 50px;"></i>
            </div>
        </div>

        <div class="card p-3 d-flex flex-column border-0 shadow-sm" style="height: 350px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-muted mb-0">Grafik Pemilik Villa Baru</h6>
                <select id="filterGrafik" class="form-select form-select-sm w-auto border">
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan">Bulanan</option>
                </select>
            </div>
            <div class="flex-grow-1">
                <canvas id="pemilikVillaChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Daftar Data Pengajuan -->
    <div class="col-md-8 mb-3">
        <div class="card p-3 h-100 border-0 shadow-sm">
            <ul class="nav nav-tabs mb-3" id="requestTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                        <i class="bi bi-hourglass-split me-1"></i> Pending
                        <span class="badge bg-warning ms-1">{{ $pendingRequests->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="processed-tab" data-bs-toggle="tab" data-bs-target="#processed" type="button" role="tab">
                        <i class="bi bi-clipboard-check me-1"></i> Diproses
                        <span class="badge bg-primary ms-1">{{ $processedRequests->count() }}</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="requestTabsContent">
                <!-- Tab Pending Requests -->
                <div class="tab-pane fade show active" id="pending" role="tabpanel">
                    @if ($pendingRequests->isEmpty())
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 48px;"></i>
                            <p class="mt-2">Tidak ada pengajuan pending</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach ($pendingRequests as $request)
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="position-relative">
                                                <i class="bi bi-person-circle text-secondary" style="font-size: 35px;"></i>
                                                @if ($request->expired_at && now()->gt($request->expired_at))
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                        Expired
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ $request->user->name }}</h6>
                                            <small class="text-muted">{{ $request->user->email }}</small>
                                        </div>
                                        <div class="text-end">
                                            <!-- Ganti onclick dengan data-bs-toggle -->
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-{{ $request->id }}">
                                                <i class="bi bi-gear"></i> Tindakan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Tab Processed Requests -->
                <div class="tab-pane fade" id="processed" role="tabpanel">
                    @if ($processedRequests->isEmpty())
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 48px;"></i>
                            <p class="mt-2">Tidak ada request yang sudah diproses</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach ($processedRequests as $request)
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-circle text-secondary flex-shrink-0" style="font-size: 35px;"></i>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ $request->user->name }}</h6>
                                            <small class="text-muted">{{ $request->user->email }}</small>
                                        </div>
                                        <div class="text-end">
                                            @if ($request->status == 'approved')
                                                <span class="badge bg-success bg-opacity-10 text-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-10 text-danger">Ditolak</span>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-outline-secondary ms-2" data-bs-toggle="modal" data-bs-target="#modal-{{ $request->id }}">
                                                <i class="bi bi-eye"></i> Detail
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('modal')
    <!-- Modals -->
    @foreach ($requests as $request)
        <div class="modal fade" id="modal-{{ $request->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $request->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="modalLabel-{{ $request->id }}">Detail Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-0 mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title text-dark mb-3"><i class="bi bi-person-lines-fill me-2"></i>Informasi Pemohon</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="text-muted" style="width: 120px;">Nama</td>
                                                <td class="text-dark">{{ $request->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Email</td>
                                                <td class="text-dark">{{ $request->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Status</td>
                                                <td>
                                                    @if ($request->status == 'pending')
                                                        <span class="badge bg-warning bg-opacity-10 text-warning">Pending</span>
                                                    @elseif($request->status == 'approved')
                                                        <span class="badge bg-success bg-opacity-10 text-success">Disetujui</span>
                                                    @elseif($request->status == 'rejected')
                                                        <span class="badge bg-danger bg-opacity-10 text-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tanggal</td>
                                                <td class="text-dark">{{ $request->created_at->format('d M Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <h6 class="card-title text-dark mb-3"><i class="bi bi-files me-2"></i>Dokumen</h6>
                                        <div class="mb-3">
                                            <label class="form-label text-muted">KTP</label>
                                            <a href="{{ asset('storage/' . $request->ktp_image) }}" target="_blank" class="d-block">
                                                <img src="{{ asset('storage/' . $request->ktp_image) }}" class="img-thumbnail w-100" alt="KTP">
                                            </a>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Kartu Keluarga</label>
                                            <a href="{{ asset('storage/' . $request->kk_image) }}" target="_blank" class="d-block">
                                                <img src="{{ asset('storage/' . $request->kk_image) }}" class="img-thumbnail w-100" alt="KK">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <h6 class="card-title text-dark mb-3"><i class="bi bi-house me-2"></i>Foto Villa</h6>
                                        <a href="{{ asset('storage/' . $request->villa_image) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $request->villa_image) }}" class="img-fluid rounded" alt="Foto Villa">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        @if ($request->status == 'pending')
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                            <form method="POST" action="{{ route('admin.reject', $request->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="bi bi-x-circle"></i> Tolak
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.approve', $request->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Setujui
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
{{-- @section('scripts')
    <script>
        // Pastikan modal diinisialisasi setelah DOM siap
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi semua modal
            var modals = document.querySelectorAll('.modal');

            modals.forEach(function(modal) {
                // Periksa apakah modal sudah diinisialisasi
                if (!modal._modal) {
                    modal._modal = new bootstrap.Modal(modal);
                }
            });

            // Alternatif: Inisialisasi modal saat tombol diklik
            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    var target = this.getAttribute('data-bs-target');
                    var modal = document.querySelector(target);
                    var bsModal = new bootstrap.Modal(modal);
                    bsModal.show();
                });
            });
        });
    </script>
@endsection --}}

{{-- @section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById("pemilikVillaChart").getContext("2d");

            // Data dari controller
            const weeklyData = @json($ownerWeeklyData);
            const monthlyData = @json($ownerMonthlyData);

            let chart;

            function createChart(type) {
                const data = type === 'mingguan' ? weeklyData : monthlyData;

                if (chart) {
                    chart.destroy();
                }

                chart = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: "Pemilik Villa Baru (" + type + ")",
                            data: data.data,
                            backgroundColor: "rgba(54, 162, 235, 0.2)",
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 2,
                            tension: 0.4,
                            pointRadius: 5,
                            pointBackgroundColor: "rgba(54, 162, 235, 1)"
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }

            // Inisialisasi grafik mingguan
            createChart("mingguan");

            // Event listener untuk dropdown
            document.getElementById("filterGrafik").addEventListener("change", function() {
                createChart(this.value);
            });
        });
    </script>
@endsection --}}