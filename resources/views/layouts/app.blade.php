<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard Admin untuk Pengelolaan Villa BMI">
    <meta name="keywords" content="Dashboard, Admin, Villa BMI, Pengelolaan">
    <meta name="author" content="Tim Pengembang Villa BMI">
    <title>@yield('title') - Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <style>
        :root {
            --primary-color: #34495e;
            --secondary-color: #2c3e50;
            --background-color: #f4f4f4;
            --text-color: #333;
            --hover-color: #0000001e;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        header {
            z-index: 50;
            height: 69px;
            padding-right: 10px;
            background-color: #ffffff;
            color: var(--text-color);
            position: fixed;
            top: 0;
            width: calc(100% - 210px);
            margin-left: 210px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 20px;
        }

        .modal {
            z-index: 1050 !important;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5) !important;
        }
        
        .modal {
            background: rgba(0, 0, 0, 0.3);
        }
        
        .modal-dialog {
            margin: 1.75rem auto;
        }
        
        .modal-content {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    
        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .left-navbar {
            color: rgb(101, 101, 101);
        }

        .right-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .right-navbar a {
            text-decoration: none;
        }

        .massage {
            border-radius: 8px;
            font-size: 14px;
            color: #555;
            display: flex;
            align-items: center;
            padding: 10px;
            transition: transform 0.3s ease;
        }

        .massage:hover {
            background: var(--hover-color);
            transform: translateY(-5px);
        }

        .massage i {
            font-size: 28px;
        }

        .message-badge {
            background-color: red;
            color: white;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            font-size: 10px;
            display: flex;
            justify-content: center;
            position: fixed;
            margin-left: 21px;
            margin-top: -38px;
        }

        .profil h1 {
            margin: 5px;
            font-size: 18px;
            display: flex;
            align-items: center;
            transition: transform 0.2s ease;
        }

        .profil i {
            margin-left: 8px;
            font-size: 28px;
        }

        .profil {
            border-radius: 8px;
            cursor: pointer;
            color: rgb(54, 54, 54);
            padding: 10px;
            transition: transform 0.3s ease;
        }

        .profil:hover {
            background: var(--hover-color);
            transform: translateY(-5px);
        }

        /* Dropdown Profil */
        .profil-dropdown {
            position: relative;
            display: inline-block;
        }

        /* Animasi untuk dropdown */
        @keyframes fadeInSlideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profil-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #ffffff;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
            overflow: hidden;
            animation: fadeInSlideDown 0.3s ease-out forwards;
        }

        .profil-dropdown-content.show {
            display: block;
        }

        .profil-dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }

        .profil-dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .profil-dropdown:hover .profil-dropdown-content {
            display: block;
        }

        .profil-dropdown:hover .profil {
            background: var(--hover-color);
            transform: translateY(-5px);
        }

        .sidebar {
            background-color: var(--primary-color);
            width: 210px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar .titel {
            color: #ffffff;
            background-color: var(--secondary-color);
            height: 69px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sidebar ul a {
            color: white;
            padding: 13px 22px;
            margin: 10px 0px;
            display: block;
            text-decoration: none;
            transition: all 2.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar ul a.active {
            background: var(--background-color);
            border-radius: 50px 0px 0px 50px;
            color: var(--text-color);
            transform: translateX(10px);
        }

        .sidebar ul a.active::after {
            right: 100%;
        }

        .sidebar ul a.active i {
            transform: scale(1.2);
        }

        .sidebar ul a:hover {
            border-radius: 50px 0px 0px 50px;
            color: var(--text-color);
            transform: translateX(10px);
        }

        /* Efek overlay dari kanan ke kiri */
        .sidebar ul a::after {
            content: '';
            position: absolute;
            top: 0;
            right: -100%;
            /* Mulai dari luar elemen (kanan) */
            width: 100%;
            height: 100%;
            background: var(--background-color);
            /* Background putih */
            transition: right 0.45s ease;
            /* Animasi overlay */
            z-index: 1;
            /* Overlay di bawah text dan icon */
        }

        .sidebar ul a:hover::after {
            right: 0;
            /* Geser overlay ke kiri */
        }

        /* Text dan icon tetap terlihat */
        .sidebar ul a span,
        .sidebar ul a i {
            position: relative;
            z-index: 2;
            /* Text dan icon di atas overlay */
        }

        .sidebar ul a i {
            transition: transform 0.3s ease;
        }

        .sidebar ul a:hover i {
            transform: scale(1.2);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 5px 0;
        }

        main {
            z-index: 0;
            position: relative;
            margin-left: 210px;
            margin-top: 69px;
            margin-bottom: 50px;
            padding: 20px;
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

        footer {
            text-align: center;
            background-color: #ffffff;
            color: var(--text-color);
            position: fixed;
            bottom: 0;
            width: calc(100% - 210px);
            margin-left: 210px;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px;
        }

        .jump {
            transition: transform 0.3s ease;
        }

        .jump:hover {
            transform: translateY(-5px);
        }

        .profil p {
            font-size: 14px;
            position: absolute;
            margin: 0;
            text-align: right;
            color: #777;
            right: 48px;
            bottom: 5px;
            width: 150px;
            /* Memberikan ruang lebih untuk text */
            direction: rtl;
            /* Membuat text mulai dari kanan */
        }

        /* Modal styles */
        .modal-header {
            border-bottom: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }

        /* Loading spinner */
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>

<body>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    showConfirmButton: true,
                });
            });
        </script>
    @endif

    <header class="z-50">
        <div class="left-navbar">
            <h2>
                <b>
                    @if (Auth::user()->role == 'admin')
                        {{ implode(' - ', array_map('ucfirst', array_slice(explode('.', Route::currentRouteName()), 1))) }}
                    @else
                        {{ ucfirst(str_replace('.', ' - ', Route::currentRouteName())) }}
                    @endif
                </b>
            </h2>
        </div>

        <div class="right-navbar">
            <a href="#">
                <div class="massage">
                    <i class="bi bi-envelope"><span class="message-badge">3</span></i>
                </div>
            </a>

            <div class="profil-dropdown">
                <div class="profil">
                    <h1>
                        Hai, {{ Auth::user()->name }} <i class="bi bi-person-circle"></i>
                    </h1>
                    <p>{{ ucfirst(Auth::user()->role) }}</p>
                </div>
                <div class="profil-dropdown-content">
                    @if (Auth::user()->role == 'admin')
                        <a href="{{ route('admin.profile') }}"><i class="bi bi-person"></i> Profil</a>
                    @elseif (Auth::user()->role == 'petugas')
                        <a href="{{ route('petugas.profile') }}"><i class="bi bi-person"></i> Profil</a>
                    @elseif (Auth::user()->role == 'pemilik_villa')
                        <a href="{{ route('pemilik_villa.profile') }}"><i class="bi bi-person"></i> Profil</a>
                    @elseif (Auth::user()->role == 'customers')
                        <a href="{{ route('customers.profile') }}"><i class="bi bi-person"></i> Profil</a>
                    @else
                        <a href="{{ route('profile') }}"><i class="bi bi-person"></i> Profil</a>
                    @endif
                    <a href="/logout"><i class="bi bi-box-arrow-right"></i> Log Out</a>
                </div>
            </div>
        </div>
    </header>

    <div class="sidebar">
        <div class="titel">
            <h2><b>Villa BMI</b></h2>
        </div>

        <ul>
            @if (Auth::user()->role == 'admin')
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pemilik_villa.index') }}" class="{{ request()->routeIs('admin.pemilik_villa.*') ? 'active' : '' }}">
                        <i class="bi bi-person"></i> <span>Data Pemilik Villa</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.petugas.index') }}" class="{{ request()->routeIs('admin.petugas.*') ? 'active' : '' }}">
                        <i class="bi bi-person"></i> <span>Data Petugas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.customers.index') }}" class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> <span>Data Customer</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.villas.index') }}" class="{{ request()->routeIs('admin.villas.index') ? 'active' : '' }}">
                        <i class="bi bi-house"></i> <span>Data Villa</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.villa_types.index') }}" class="{{ request()->routeIs('admin.villa_types.index') ? 'active' : '' }}">
                        <i class="bi bi-house"></i> <span>Data Type Villa</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.facilities.index') }}" class="{{ request()->routeIs('admin.facilities.index') ? 'active' : '' }}">
                        <i class="bi bi-router"></i> <span>Fasilitas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.transactions.index') }}" class="{{ request()->routeIs('admin.transactions.index') ? 'active' : '' }}">
                        <i class="bi bi-wallet2"></i> <span>Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.requests') }}" class="{{ request()->routeIs('admin.requests') ? 'active' : '' }}">
                        <i class="bi bi-list-task"></i> <span>Request Role</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="{{ request()->routeIs('admin.laporan_keuangan') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart"></i> <span>Laporan Keuangan</span>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'pemilik_villa')
                <li>
                    <a href="{{ route('pemilik_villa.dashboard') }}" class="{{ Str::startsWith(request()->url(), route('pemilik_villa.dashboard')) ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-house"></i> <span>Data Villa</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-person"></i> <span>Data Petugas</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-people"></i> <span>Data Pelanggan</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-card-list"></i> <span>Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-bar-chart"></i> <span>Laporan Keuangan</span>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'petugas')
                <li>
                    <a href="{{ route('petugas.dashboard') }}" class="{{ Str::startsWith(request()->url(), route('petugas.dashboard')) ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-house"></i> <span>Data Villa</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-people"></i> <span>Data Pelanggan</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-card-list"></i> <span>Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-bar-chart"></i> <span>Laporan Keuangan</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <main class="z-0">
        @yield('content')
    </main>
    @yield('modal')
    <footer>
        &copy; 2025 Penyewaan Villa BMI. Semua Hak Dilindungi.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const main = document.querySelector('main');
            if (main) {
                main.style.animation = 'fadeIn 0.5s ease-out forwards';
            }

            // Toggle dropdown profil
            const profilDropdown = document.querySelector('.profil-dropdown');
            const dropdownContent = document.querySelector('.profil-dropdown-content');

            profilDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownContent.classList.toggle('show');
            });

            // Tutup dropdown saat klik di luar
            document.addEventListener('click', function() {
                dropdownContent.classList.remove('show');
            });
        });
    </script>
</body>

</html>
