@extends('layouts.pelanggan')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section dengan background gambar villa -->
    <div class="jumbotron jumbotron-fluid d-flex align-items-center justify-content-center text-center text-white position-relative" id="heroBackground" style="background: url('{{ asset('storage/images/villa-bg.jpg') }}') no-repeat center center; background-size: cover; height: 500px;">
        <!-- Overlay -->

        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
        <div class="container position-relative z-1">
            <h1 class="display-4 fw-bold">Selamat Datang di Villa BMI</h1>
            <p class="lead">Nikmati pengalaman menginap yang tak terlupakan di villa mewah kami</p>
            <!-- Form Pencarian -->
            <div class="d-inline-block bg-white p-3 rounded-5 w-75">
                <form action="/cari" method="GET">
                    <div class="row g-2 justify-content-center">
                        <!-- Input Lokasi -->
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="lokasi" class="form-control rounded-3" placeholder="Mau nginep di mana?">
                            </div>
                        </div>
                        <!-- Input Tanggal (Awal dan Akhir) -->
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                <input type="text" id="tanggal_range" class="form-control rounded-3" placeholder="Pilih tanggal" readonly onclick="openModal()">
                            </div>
                        </div>
                        <!-- Tombol Cari -->
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100 rounded-3">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Section Card untuk menampilkan villa -->
    <div class="container bg-light rounded-top-5 py-4 position-relative" style="margin-top: -30px; z-index: 1;">
        <h2 class="text-center mb-4">Daftar Villa Unggulan</h2>
        <div class="row px-4">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm rounded-4 overflow-hidden">
                    <img src="{{ asset('storage/images/villa-bg.jpg') }}" class="card-img-top" alt="Villa Sunset">
                    <div class="card-body">
                        <h5 class="card-title">Villa Sunset</h5>
                        <p class="card-text">
                            <span class="text-warning">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i> (4.0)
                            </span>
                        </p>
                        <p class="card-text">Harga: Rp 2.500.000/malam</p>
                        <p class="card-text"><small class="text-muted">Jl. Sunset Road No. 123, Bali</small></p>
                        <a href="https://maps.app.goo.gl/aHRE3YNZreZPxr9GA" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Lokasi</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm rounded-4 overflow-hidden">
                    <img src="{{ asset('storage/images/villa-bg.jpg') }}" class="card-img-top" alt="Villa Sunset">
                    <div class="card-body">
                        <h5 class="card-title">Villa Sunset</h5>
                        <p class="card-text">
                            <span class="text-warning">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i> (3.0)
                            </span>
                        </p>
                        <p class="card-text">Harga: Rp 2.500.000/malam</p>
                        <p class="card-text"><small class="text-muted">Jl. Sunset Road No. 123, Bali</small></p>
                        <a href="https://maps.app.goo.gl/aHRE3YNZreZPxr9GA" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Lokasi</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm rounded-4 overflow-hidden">
                    <img src="{{ asset('storage/images/villa-bg.jpg') }}" class="card-img-top" alt="Villa Sunset">
                    <div class="card-body">
                        <h5 class="card-title">Villa Sunset</h5>
                        <p class="card-text">
                            <span class="text-warning">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i> (4.0)
                            </span>
                        </p>
                        <p class="card-text">Harga: Rp 2.500.000/malam</p>
                        <p class="card-text"><small class="text-muted">Jl. Sunset Road No. 123, Bali</small></p>
                        <a href="https://maps.app.goo.gl/aHRE3YNZreZPxr9GA" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Lokasi</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm rounded-4 overflow-hidden">
                    <img src="{{ asset('storage/images/villa-bg.jpg') }}" class="card-img-top" alt="Villa Sunset">
                    <div class="card-body">
                        <h5 class="card-title">Villa Sunset</h5>
                        <p class="card-text">
                            <span class="text-warning">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i> (4.0)
                            </span>
                        </p>
                        <p class="card-text">Harga: Rp 2.500.000/malam</p>
                        <p class="card-text"><small class="text-muted">Jl. Sunset Road No. 123, Bali</small></p>
                        <a href="https://maps.app.goo.gl/aHRE3YNZreZPxr9GA" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Lokasi</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm rounded-4 overflow-hidden">
                    <img src="{{ asset('storage/images/villa-bg.jpg') }}" class="card-img-top" alt="Villa Sunset">
                    <div class="card-body">
                        <h5 class="card-title">Villa Sunset</h5>
                        <p class="card-text">
                            <span class="text-warning">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i> (4.0)
                            </span>
                        </p>
                        <p class="card-text">Harga: Rp 2.500.000/malam</p>
                        <p class="card-text"><small class="text-muted">Jl. Sunset Road No. 123, Bali</small></p>
                        <a href="https://maps.app.goo.gl/aHRE3YNZreZPxr9GA" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Lokasi</a>
                    </div>
                </div>
            </div>

            <!-- Tambahkan lebih banyak card sesuai data villa Anda -->
        </div>
    </div>
    <!-- JavaScript untuk Mengelola Modal dan Input Tanggal -->
    <script>
        // Daftar gambar villa
        const images = [
            '/assets/images/villa-bg.jpg',
            '/assets/images/villa-bg2.jpg',
            '/assets/images/villa-bg3.jpg',
        ];

        let currentIndex = 0; // Indeks gambar saat ini

        // Fungsi untuk mengubah background
        function changeBackground() {
            const heroBackground = document.getElementById('heroBackground');
            heroBackground.style.backgroundImage = url('${images[currentIndex]}');

            // Update indeks untuk gambar berikutnya
            currentIndex = (currentIndex + 1) % images.length;
        }

        // Jalankan fungsi changeBackground setiap 5 detik
        setInterval(changeBackground, 5000);





        // Fungsi untuk membuka modal
        function openModal() {
            const modal = new bootstrap.Modal(document.getElementById('dateRangeModal'));
            modal.show();
        }

        // Fungsi untuk memformat tanggal menjadi "17 Feb"
        function formatTanggal(dateString) {
            const date = new Date(dateString);
            const day = date.getDate(); // Ambil tanggal (1-31)
            const month = date.toLocaleString('default', {
                month: 'short'
            }); // Ambil bulan dalam format pendek (Jan, Feb, dst.)
            return $ {
                day
            }
            $ {
                month
            }; // Format: "17 Feb"
        }

        // Fungsi untuk menyimpan tanggal yang dipilih
        function saveDateRange() {
            const tanggalAwal = document.getElementById('tanggal_awal').value;
            const tanggalAkhir = document.getElementById('tanggal_akhir').value;

            if (!tanggalAwal || !tanggalAkhir) {
                alert('Harap pilih tanggal awal dan tanggal akhir!');
                return;
            }

            // Format tanggal menjadi "17 Feb - 20 Feb"
            const formattedDateRange = $ {
                formatTanggal(tanggalAwal)
            } - $ {
                formatTanggal(tanggalAkhir)
            };

            // Isi input tanggal_range dengan nilai yang dipilih
            document.getElementById('tanggal_range').value = formattedDateRange;

            // Tutup modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('dateRangeModal'));
            modal.hide();
        }
    </script>
@endsection
@section('modal')
    <!-- Modal untuk Memilih Tanggal -->
    <div class="modal fade" id="dateRangeModal" tabindex="-1" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateRangeModalLabel">Pilih Tanggal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Input Tanggal Awal -->
                    <div class="mb-3">
                        <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                        <input type="date" id="tanggal_awal" class="form-control">
                    </div>
                    <!-- Input Tanggal Akhir -->
                    <div class="mb-3">
                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                        <input type="date" id="tanggal_akhir" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveDateRange()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
