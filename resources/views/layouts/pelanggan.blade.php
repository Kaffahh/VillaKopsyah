<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Villa BMI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<style>
    .profile:hover .dropdown-menu {
        display: block;
        top: 80%;
    }

    main {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeIn 0.5s ease-out forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 992px) {

        .container,
        .container-lg,
        .container-md,
        .container-sm {
            max-width: 100%;
        }
    }
</style>

<body>
    {{-- navbar benerin biar nempel dia tas --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Villa BMI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="/villas">Villa</a></li>
                    <li class="nav-item"><a class="nav-link" href="/fasilitas">Fasilitas</a></li>
                    <li class="nav-item"><a class="nav-link" href="/kontak">Kontak</a></li>
                </ul>
                {{-- Profile --}}
                <div class="d-flex align-items-center profile">
                    @auth
                        <div class="text-end me-2">
                            <span class="fw-bold d-block mb-0">Hai, {{ Auth::user()->name }}</span>
                            @if (Auth::user()->code_kopsyah)
                                <span class="text-success small d-block ">Pelanggan Kopsyah</span>
                            @else
                                <span class="text-secondary small d-block ">Pelanggan Biasa</span>
                            @endif
                        </div>

                        <!-- Dropdown profile menu -->
                        <!-- Dropdown profile menu -->
                        <img src="{{ Auth::user()->photo ?? '' }}" alt="User Avatar" class="rounded-circle cursor-pointer" width="50" height="50" onerror="this.onerror=null; this.outerHTML='<i class=\'bi bi-person-circle fs-2\'></i>'" aria-expanded="false" data-bs-toggle="dropdown" aria-haspopup="true">

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person-circle"></i> Profile</a></li>

                            @if (Auth::user()->role == 'pemilik_villa')
                                <li><a class="dropdown-item" href="/register_pemilik_villa"><i class="bi bi-house-door"></i> Tambah Villa Anda</a></li>
                                <li><a class="dropdown-item" href="/pemilik_villa"><i class="bi bi-house-door"></i> Villa Anda</a></li>
                            @endif

                            @if (Auth::user()->role == 'pengelola_villa')
                                <li><a class="dropdown-item" href="/kelola_villa"><i class="bi bi-gear"></i> Kelola Villa</a></li>
                            @endif

                            @if (Auth::user()->role == 'admin')
                                <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-speedometer"></i> Admin Dashboard</a></li>
                            @endif

                            <li><a class="dropdown-item" href="/riwayat_pemesanan"><i class="bi bi-clock-history"></i> Riwayat Pemesanan</a></li>
                            <li><a class="dropdown-item" href="/change-password"><i class="bi bi-key"></i> Ubah Password</a></li>
                            <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right"></i> Log Out</a></li>
                        </ul>
                    @else
                        <a href="/login" class="btn btn-outline-primary me-2">Masuk</a>
                        <a href="/register" class="btn btn-primary">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <main class="container">
        @yield('content')
    </main>
    @yield('modal')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
