@extends('layouts.pelanggan')

@section('title', 'Profil Pengguna')

@section('content')
  <style>
    .order-status {
      font-size: 12px;
      font-weight: bold;
      padding: 4px 10px;
      border-radius: 15px;
      display: inline-block;
      min-width: 80px;
      text-align: center;
    }
    .Panding { color: #f1c40f; background: rgba(241, 196, 15, 0.2); }
    .Confirmed { color: #28a745; background: rgba(40, 167, 69, 0.2); }
    .completed { color: #007bff; background: rgba(0, 123, 255, 0.2); }
    .cancelled { color: #dc3545; background: rgba(220, 53, 69, 0.2); }
    .search-box {
      max-width: 500px;
    }
    .card-header span {
      font-weight: bold; /* Menebalkan teks tanggal */
    }
  </style>
  <div class="container py-4">
    <h4 class="mb-3 text-center">Riwayat Pemesanan</h4>

    <!-- Search Box -->
    <div class="input-group search-box mb-3">
      <span class="input-group-text">
        <i class="bi bi-search"></i>
      </span>
      <input type="text" class="form-control" placeholder="Cari villa yang pernah kamu pesan" aria-label="Cari villa" id="searchInput">
    </div>

    <!-- Filter by Month and Status -->
    <div class="mb-3 d-flex gap-2">
      <select class="form-select w-auto rounded-5 bg-light" id="monthFilter">
        <option value="">Semua Bulan</option>
        <option value="01">Januari</option>
        <option value="02">Februari</option>
        <option value="03">Maret</option>
        <option value="04">April</option>
        <option value="05">Mei</option>
        <option value="06">Juni</option>
        <option value="07">Juli</option>
        <option value="08">Agustus</option>
        <option value="09">September</option>
        <option value="10">Oktober</option>
        <option value="11">November</option>
        <option value="12">Desember</option>
      </select>

      <select class="form-select w-auto rounded-5 bg-light" id="statusFilter">
        <option value="">Semua Status</option>
        <option value="Panding">Pending</option>
        <option value="Confirmed">Confirmed</option>
        <option value="completed">Completed</option>
        <option value="cancelled">Cancelled</option>
      </select>
    </div>
    <!-- Order Cards -->
    <div class="card mb-3" data-date="2025-02-11" data-status="Panding">
      <div class="card-header d-flex justify-content-between align-items-center py-2">
        <span>11 Februari 2025</span>
        <div class="d-flex align-items-center gap-2">
          <span class="order-status Panding">Pending</span>
          <button class="btn btn-danger btn-sm" title="Laporkan"><i class="bi bi-exclamation-triangle"></i></button>
        </div>
      </div>
      <div class="card-body">
        <h5 class="card-title">Villa Lembang Asri</h5>
        <p class="card-text">Durasi:23 Februari 2025 - 24 Februari 2025</p>
        <div class="d-flex justify-content-between align-items-center">
          <p class="card-text mb-0">Total: <strong>Rp 2.500.000</strong></p>
          <div class="d-flex gap-2">
            <a href="https://wa.me/628xxxxxxxxx" class="btn btn-success btn-sm">Hubungi</a>
            <button class="btn btn-danger btn-sm">Cancelled</button>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3" data-date="2025-02-10" data-status="Confirmed">
      <div class="card-header d-flex justify-content-between align-items-center py-2">
        <span>10 Februari 2025</span>
        <div class="d-flex align-items-center gap-2">
          <span class="order-status Confirmed">Confirmed</span>
          <button class="btn btn-danger btn-sm" title="Laporkan"><i class="bi bi-exclamation-triangle"></i></button>
        </div>
      </div>
      <div class="card-body">
        <h5 class="card-title">Villa Puncak Indah</h5>
        <p class="card-text">Durasi: 21 Februari 2025 - 22 Februari 2025</p>
        <div class="d-flex justify-content-between align-items-center">
          <p class="card-text mb-0">Total: <strong>Rp 3.750.000</strong></p>
          <a href="https://wa.me/628xxxxxxxxx" class="btn btn-success btn-sm">Hubungi</a>
        </div>
      </div>
    </div>
    
    <div class="card mb-3" data-date="2025-02-12" data-status="Confirmed">
      <div class="card-header d-flex justify-content-between align-items-center py-2">
        <span>12 Februari 2025</span>
        <div class="d-flex align-items-center gap-2">
          <span class="order-status Confirmed">Checked-in</span>
          <button class="btn btn-danger btn-sm" title="Laporkan"><i class="bi bi-exclamation-triangle"></i></button>
        </div>
      </div>
      <div class="card-body">
        <h5 class="card-title">Villa Puncak BMI</h5>
        <p class="card-text">Durasi: 12 Februari 2025 - 15 Februari 2025</p>
        <div class="d-flex justify-content-between align-items-center">
          <p class="card-text mb-0">Total: <strong>Rp 2.750.000</strong></p>
          <a href="https://wa.me/628xxxxxxxxx" class="btn btn-success btn-sm">Hubungi</a>
        </div>
      </div>
    </div>



    <div class="card mb-3" data-date="2025-1-20" data-status="completed">
      <div class="card-header d-flex justify-content-between align-items-center py-2">
        <span>20 Januari 2024</span>
        <div class="d-flex align-items-center gap-2">
          <span class="order-status completed">Completed</span>
          <button class="btn btn-danger btn-sm" title="Laporkan"><i class="bi bi-exclamation-triangle"></i></button>
        </div>
      </div>
      <div class="card-body">
        <h5 class="card-title">Villa Anyer Beach</h5>
        <p class="card-text">Durasi: 20 Januari 2024 - 21 Januari 2024</p>
        <div class="d-flex justify-content-between align-items-center">
          <p class="card-text mb-0">Total: <strong>Rp 1.200.000</strong></p>
          <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm">Ulasan</button>
            <button class="btn btn-primary btn-sm">Pesan lagi</button>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3" data-date="2024-12-10" data-status="cancelled">
      <div class="card-header d-flex justify-content-between align-items-center py-2">
        <span>10 Desember 2024</span>
        <div class="d-flex align-items-center gap-2">
          <span class="order-status cancelled">Cancelled</span>
          <button class="btn btn-danger btn-sm" title="Laporkan"><i class="bi bi-exclamation-triangle"></i></button>
        </div>
      </div>
      <div class="card-body">
        <h5 class="card-title">Villa Bali Sunset</h5>
        <p class="card-text">Durasi: 10 Desember 2024 - 12 Desember 2024</p>
        <p class="card-text">Total: <strong>Rp 2.800.000</strong></p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Fungsi untuk filter berdasarkan bulan, status, dan pencarian
    const monthFilter = document.getElementById('monthFilter');
    const statusFilter = document.getElementById('statusFilter');
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.card');

    function filterCards() {
      const selectedMonth = monthFilter.value;
      const selectedStatus = statusFilter.value;
      const searchTerm = searchInput.value.toLowerCase();

      cards.forEach(card => {
        const cardDate = card.getAttribute('data-date');
        const cardMonth = cardDate.split('-')[1]; // Ambil bulan dari data-date
        const cardStatus = card.getAttribute('data-status'); // Ambil status dari data-status
        const cardTitle = card.querySelector('.card-title').textContent.toLowerCase();

        const monthMatch = selectedMonth === "" || cardMonth === selectedMonth;
        const statusMatch = selectedStatus === "" || cardStatus === selectedStatus;
        const searchMatch = cardTitle.includes(searchTerm);

        if (monthMatch && statusMatch && searchMatch) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    }

    // Event listeners untuk filter
    monthFilter.addEventListener('change', filterCards);
    statusFilter.addEventListener('change', filterCards);
    searchInput.addEventListener('input', filterCards);
  </script>
@endsection