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
    <div class="tab-content">
        <!-- Tab 1 -->
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

        <!-- Tab 2 -->
        <div id="tab2" style="display: none;">
            @include('admin.dashboard.tab2', [
                'topVillas' => $topVillas,
                'topOwners' => $topOwners,
                'weeklyData' => $weeklyData,
                'monthlyData' => $monthlyData,
            ])
        </div>

        <!-- Tab 3 -->
        <div id="tab3" style="display: none;">
            @include('admin.dashboard.tab3')
        </div>

        <!-- Tab 4 -->
        <div id="tab4" style="display: none;">
            @include('admin.dashboard.tab4')
        </div>
    </div>


<script>
    let villaChart;
    let ownerChart;

    function createOwnerChart(type) {
        const ctx = document.getElementById("pemilikVillaChart");
        if (!ctx) {
            console.log("Owner chart element not found");
            return;
        }

        const data = type === 'mingguan' ? @json($ownerWeeklyData) : @json($ownerMonthlyData);

        if (ownerChart) {
            ownerChart.destroy();
        }

        ownerChart = new Chart(ctx, {
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

    function tab(tabId, element) {
        console.log("Switching to tab:", tabId);

        // Hide all tabs
        document.querySelectorAll('[id^="tab"]').forEach(tab => {
            tab.style.display = 'none';
        });

        // Show selected tab
        const selectedTab = document.getElementById(tabId);
        if (selectedTab) {
            selectedTab.style.display = 'block';
            
            // Initialize appropriate chart based on tab
            if (tabId === 'tab1') {
                setTimeout(() => {
                    createOwnerChart('mingguan');
                }, 100);
            } else if (tabId === 'tab2') {
                setTimeout(() => {
                    createChart('mingguan');
                }, 100);
            }
        }

        // Update card styling
        document.querySelectorAll('.card').forEach(card => {
            card.classList.remove('card-selected');
            card.classList.add('card-default');
        });

        if (element) {
            element.classList.remove('card-default');
            element.classList.add('card-selected');
        }
    }

    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Set tab default dan inisialisasi grafik pertama
        tab('tab1', document.getElementById('cardRequest'));

        // Event listener untuk filter grafik pemilik villa (Tab 1)
        const ownerFilterSelect = document.getElementById('filterGrafik');
        if (ownerFilterSelect) {
            ownerFilterSelect.addEventListener('change', function() {
                createOwnerChart(this.value);
            });
        }

        // Event listener untuk filter grafik villa (Tab 2)
        const villaFilterSelect = document.getElementById('filterGrafikVilla');
        if (villaFilterSelect) {
            villaFilterSelect.addEventListener('change', function() {
                createChart(this.value);
            });
        }
    });

    // Fungsi createChart yang sudah ada untuk Tab 2
    function createChart(type) {
        const ctx = document.getElementById("villaChart");
        if (!ctx) return;

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
                    legend: { display: false }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    }
</script>
@endsection