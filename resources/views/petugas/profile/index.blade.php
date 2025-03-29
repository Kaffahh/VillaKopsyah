@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
    <style>
        .card {
            border-radius: 15px;
            /* Memberikan sudut tumpul pada card */
            overflow: hidden;
            /* Agar gambar tidak keluar dari card */
        }

        .card-body {
            padding: 30px;
        }

        h4 {
            font-weight: bold;
        }

        .form-group p {
            font-size: 16px;
            color: #555;
        }

        .form-group label {
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .form-group i {
            margin-left: 8px;
            /* Memberikan jarak antara ikon dan label */
            font-size: 18px;
        }

        .form-group label:hover {
            cursor: pointer;
            /* Menunjukkan bahwa label bisa diinteraksi */
        }
    </style>

    <div class="container ">
        
        <!-- Menampilkan pesan sukses jika ada -->
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        <div class="card shadow-lg">
            <h2 class="card-title text-center mt-3">Profile Pengguna</h2>
            <div class="card-body">
                <div class="row">
                    <!-- Kolom Kiri: Foto Profil -->
                    <div class="col-md-4 text-center">
                        <!-- Menampilkan foto profil atau ikon jika foto tidak ada -->
                        @if ($user->foto_profile)
                            <img src="{{ asset('storage/image/profile/' . $user->foto_profile) }}" alt="Foto Profile"
                                class="img-fluid rounded-circle" width="200">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 150px; color: #bbb;"></i>
                        @endif
                        <!-- Nama Lengkap di bawah foto -->
                        <h4 class="mt-3 text-dark">{{ $user->nama_lengkap }}</h4>
                    </div>
                    

                    <!-- Kolom Kanan: Informasi Pengguna -->
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">
                                Name <i class="bi bi-pencil-square"></i>
                            </label>
                            <p>{{ $user->name }}</p>
                        </div>

                        <div class="form-group">
                            <label for="email">
                                Email <i class="bi bi-pencil-square"></i>
                            </label>
                            <p>{{ $user->email }}</p>
                        </div>

                        <div class="form-group">
                            <label for="role">
                                Role <i class="bi bi-pencil-square"></i>
                            </label>
                            <p>{{ ucfirst($user->role) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<div class="modal fade" id="ktpModal" tabindex="-1" aria-labelledby="ktpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ktpModalLabel">Foto KTP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Menampilkan foto KTP -->
                @if ($user->foto_ktp)
                    <img src="{{ asset('storage/ktp_photos/' . $user->foto_ktp) }}" alt="Foto KTP"
                        class="img-fluid mb-3" width="100%">
                @else
                    <p>Tidak ada foto KTP yang diunggah.</p>
                @endif
            </div>
            <div class="modal-footer">
                <!-- Tombol Edit Foto KTP -->
                <a href="" class="btn btn-warning">Edit Foto KTP</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>