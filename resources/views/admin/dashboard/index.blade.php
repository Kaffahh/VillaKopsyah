@extends('layouts.app')

@section('content')
<style>
    .card-body {
        cursor: pointer;
    }

    .card-default {
        border: 3px solid #d0d0d0;
    }

    .card-selected {
        border: 3px solid #007bff;
    }

    .jump:hover {
        transform: translateY(-5px);
        transition: transform 0.2s ease;
    }
</style>
    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card card-default jump" id="cardRequest" onclick="tab('tab1', this)">
                <div class="card-body d-flex justify-content-around align-items-center">
                    <div>
                        <span class="card-title fs-5">Request</span>
                        <p class="card-text fw-bold fs-3">{{ $pendingRequests->count() }}</p>
                    </div>
                    <i class="bi bi-person-badge text-primary" style="font-size: 60px;"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-default jump" id="cardVilla" onclick="tab('tab2', this)">
                <div class="card-body d-flex justify-content-around align-items-center">
                    <div>
                        <span class="card-title fs-5">Villa</span>
                        <p class="card-text fw-bold fs-3">{{ $villaOwners }}</p>
                    </div>
                    <i class="bi bi-house-fill text-primary" style="font-size: 60px;"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-default jump" id="cardTab3" onclick="tab('tab3', this)">
                <div class="card-body d-flex justify-content-around align-items-center">
                    <div>
                        <span class="card-title fs-5">Tab 3</span>
                        <p class="card-text fw-bold fs-3">0</p>
                    </div>
                    <i class="bi bi-door-closed-fill text-primary" style="font-size: 60px;"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-default jump" id="cardTab4" onclick="tab('tab4', this)">
                <div class="card-body d-flex justify-content-around align-items-center">
                    <div>
                        <span class="card-title fs-5">Tab 4</span>
                        <p class="card-text fw-bold fs-3">0</p>
                    </div>
                    <i class="bi bi-door-closed-fill text-primary" style="font-size: 60px;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div id="tab1" style="display: block;">
        @include('admin.dashboard.tab1', [
            'pendingRequests' => $pendingRequests,
            'processedRequests' => $processedRequests,
            'requests' => $requests,
            'newVillaOwnersToday' => $newVillaOwnersToday,
            'ownerWeeklyData' => $ownerWeeklyData,
            'ownerMonthlyData' => $ownerMonthlyData,
        ])
    </div>



<div id="tab2" style="display: none;">
    @include('admin.dashboard.tab2', [
        'topVillas' => $topVillas,
        'topOwners' => $topOwners,
        'weeklyData' => $weeklyData,
        'monthlyData' => $monthlyData,
    ])
</div>

<div id="tab3" style="display: none;">
    @include('admin.dashboard.tab3')
</div>

<div id="tab4" style="display: none;">
    @include('admin.dashboard.tab4')
</div>


<script>
    let villaChart; // Deklarasi global untuk chart

    function createChart(type) {
        const ctx = document.getElementById("villaChart");
        if (!ctx) return; // Cek apakah element ada

        const data = type === 'mingguan' ? @json($weeklyData) : @json($monthlyData);

        if (villaChart) {
            villaChart.destroy();
        }

        villaChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: data.labels,
                datasets: [{
                    label: "Pertambahan Villa (" + type + ")",
                    data: data.data,
                    borderColor: "rgba(75, 192, 192, 1)",
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderWidth: 2,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(75, 192, 192, 1)",
                    tension: 0.4
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

    function tab(tabId, element) {
        // Hide all tabs
        document.querySelectorAll('[id^="tab"]').forEach(tab => {
            tab.style.display = 'none';
        });

        // Show selected tab
        document.getElementById(tabId).style.display = 'block';

        // Remove selected class from all cards
        document.querySelectorAll('.card').forEach(card => {
            card.classList.remove('card-selected');
            card.classList.add('card-default');
        });

        // Add selected class to clicked card
        element.classList.remove('card-default');
        element.classList.add('card-selected');

        // Inisialisasi ulang chart jika di tab2
        if (tabId === 'tab2') {
            setTimeout(() => {
                createChart('mingguan');

                // Event listener untuk dropdown filter
                const filterSelect = document.getElementById("filterGrafikVilla");
                if (filterSelect) {
                    filterSelect.addEventListener("change", function() {
                        createChart(this.value);
                    });
                }
            }, 100);
        }
    }

    // Set default tab on load
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi modal Bootstrap
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            new bootstrap.Modal(modal, {
                backdrop: true,
                keyboard: true,
                focus: true
            });
        });

        // Set tab default
        tab('tab1', document.getElementById('cardRequest'));

        // Initialize tooltips
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(tooltip => {
            new bootstrap.Tooltip(tooltip);
        });

        // Inisialisasi fungsi untuk detail villa dan owner
        window.showVillaDetail = function(villaId) {
            const modal = new bootstrap.Modal(document.getElementById('villaDetailModal'));
            $('#villaDetailContent').html('<div class="text-center py-5"><i class="bi bi-hourglass-split"></i> Loading...</div>');
            modal.show();

            $.ajax({
                url: /admin/villas/${villaId}/detail,
                method: 'GET',
                success: function(response) {
                    // ... existing villa detail code ...
                },
                error: function() {
                    $('#villaDetailContent').html('<div class="text-center text-danger py-5">Gagal memuat data</div>');
                }
            });
        };

        window.showOwnerDetail = function(ownerId) {
            const modal = new bootstrap.Modal(document.getElementById('ownerDetailModal'));
            $('#ownerDetailContent').html('<div class="text-center py-5"><i class="bi bi-hourglass-split"></i> Loading...</div>');
            modal.show();

            $.ajax({
                url: /admin/pemilik_villa/${ownerId}/detail,
                method: 'GET',
                success: function(response) {
                    // ... existing owner detail code ...
                },
                error: function() {
                    $('#ownerDetailContent').html('<div class="text-center text-danger py-5">Gagal memuat data</div>');
                }
            });
        };
    });
</script>
@endsection