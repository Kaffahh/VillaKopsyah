@extends('layouts.app')

@section('title', 'Data Petugas')

@section('content')
    <div class="card mb-3">
        <div class="card-body d-flex align-items-center">
            <!-- Dropdown Pilihan Villa -->
            <select id="villaSelector" class="form-select me-2" style="max-width: 300px;">
                <option value="" selected>Pilih Villa</option>
                @foreach($villas as $villa)
                    <option value="{{ $villa->id }}">{{ $villa->name }}</option>
                @endforeach
            </select>            
            <!-- Tombol Cari Villa -->
            {{-- <a href="{{ route('admin.data_petugas.villacantik') }}"> --}}
            <a href="#">
                <button class="btn btn-success">
                    <i class="bi bi-search"></i> Cari Villa
                </button>
            </a>
        </div>
    </div>

    <div class="mb-3">
        <div class="row">
            <div class="col-md-10 d-flex align-items-stretch">
                <div class="card card-default w-100">
                    <div class="card-body px-5 d-flex align-items-center">
                        <div>
                            <h1 class="card-title">Semua Petugas</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-stretch text-center">
                <div class="card card-default w-100">
                    <div class="card-body">
                        <i class="bi bi-person-fill" style="font-size: 60px; color: #007bff;"></i>
                        <h5 class="card-title">Total Petugas</h5>
                        <p class="card-text fw-bold" style="font-size: 30px;">{{ $petugas_villas->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary">Tambah Petugas</a>
                </div>
                    <input type="text" id="searchInput" class="form-control w-25 me-2 mb-4" placeholder="Cari nama petugas...">
            </div>
            <!-- Tabel Data Petugas -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" id="petugasTable">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($petugas_villas as $petugas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $petugas->user->name }}</td>
                                <td>{{ $petugas->user->email }}</td>
                                <td>{{ $petugas->user->role }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPetugasModal">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="deletePetugas({{ $petugas->id }})">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Tidak ada data petugas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Pencarian data petugas
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('petugasTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            for (let i = 0; i < rows.length; i++) {
                const nameCell = rows[i].getElementsByTagName('td')[1];
                if (nameCell) {
                    const name = nameCell.textContent.toLowerCase();
                    if (name.indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        });

        // Modal foto KTP
        const viewKTPModal = document.getElementById('viewKTPModal');
        viewKTPModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const ktpSrc = button.getAttribute('data-ktp-src');
            const ktpImage = document.getElementById('ktpImage');
            ktpImage.src = ktpSrc;
        });
    </script>
@endsection

<!-- Modal Tambah Petugas -->
<div class="modal fade" id="addPetugasModal" tabindex="-1" aria-labelledby="addPetugasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPetugasModalLabel">Tambah Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" placeholder="Masukkan nama lengkap petugas">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Masukkan username petugas">
                    </div>
                    <div class="mb-3">
                        <label for="nomor" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="nomor" placeholder="Masukkan nomor telepon petugas">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Masukkan email petugas">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Masukkan password petugas">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirm_password" placeholder="Konfirmasi password">
                    </div>
                    <div class="mb-3">
                        <label for="foto_ktp" class="form-label">Foto KTP</label>
                        <input type="file" class="form-control" id="foto_ktp">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan Petugas</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Petugas -->
<div class="modal fade" id="editPetugasModal" tabindex="-1" aria-labelledby="editPetugasModalLabel" aria-hidden="true">
    <div class <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPetugasModalLabel">Edit Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="edit_nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit_nama_lengkap" placeholder="Masukkan nama lengkap petugas">
                    </div>
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit_username" placeholder="Masukkan username petugas">
                    </div>
                    <div class="mb-3">
                        <label for="edit_nomor" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="edit_nomor" placeholder="Masukkan nomor telepon petugas">
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" placeholder="Masukkan email petugas">
                    </div>
                    <div class="mb-3">
                        <label for="edit_foto_ktp" class="form-label">Foto KTP</label>
                        <input type="file" class="form-control" id="edit_foto_ktp">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Petugas -->
<div class="modal fade" id="deletePetugasModal" tabindex="-1" aria-labelledby="deletePetugasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePetugasModalLabel">Hapus Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus petugas <strong><span id="petugas-name"></span></strong>?</p>
                <p>Proses ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Foto KTP -->
<div class="modal fade" id="viewKTPModal" tabindex="-1" aria-labelledby="viewKTPModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewKTPModalLabel">Lihat Foto KTP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" alt="Foto KTP" id="ktpImage" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
    // Pencarian data petugas
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('petugasTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();
        for (let i = 0; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByTagName('td')[1];
            if (nameCell) {
                const name = nameCell.textContent.toLowerCase();
                if (name.indexOf(filter) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
    const villaSelector = document.getElementById("villaSelector");
    const cariVillaBtn = document.querySelector(".btn-success");

    cariVillaBtn.addEventListener("click", function () {
        const selectedVilla = villaSelector.value;

        if (selectedVilla) {
            // Kirim permintaan AJAX untuk mengecek apakah villa memiliki petugas
            fetch(`/admin/petugas/check/${selectedVilla}`)
                .then(response => response.json())
                .then(data => {
                    if (data.hasPetugas) {
                        // Jika ada petugas, arahkan ke halaman villa
                        window.location.href = `/admin/petugas/${selectedVilla}`;
                    } else {
                        // Jika tidak ada petugas, tampilkan peringatan
                        alert("Villa belum memiliki petugas!");
                    }
                })
                .catch(error => console.error("Error:", error));
        } else {
            alert("Silakan pilih villa terlebih dahulu!");
        }
    });
});


    // 2. Filter Pencarian Petugas
    const searchInput = document.getElementById("searchInput");
    const tableRows = document.querySelectorAll("#petugasTable tbody tr");

    searchInput.addEventListener("keyup", function () {
        const filter = searchInput.value.toLowerCase();
        tableRows.forEach((row) => {
            const name = row.cells[1]?.textContent.toLowerCase() || "";
            row.style.display = name.includes(filter) ? "" : "none";
        });
    });

    // 3. Modal Edit Petugas (Ambil Data Saat Diklik)
    const editModal = document.getElementById("editPetugasModal");
    editModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const row = button.closest("tr");
        const name = row.cells[1].textContent;
        const email = row.cells[2].textContent;
        const role = row.cells[3].textContent;

        document.getElementById("edit_nama_lengkap").value = name;
        document.getElementById("edit_email").value = email;
    });

    // 4. Konfirmasi Hapus Petugas
    const deleteModal = document.getElementById("deletePetugasModal");
    deleteModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const row = button.closest("tr");
        const petugasName = row.cells[1].textContent;
        document.getElementById("petugas-name").textContent = petugasName;
    });

    // 5. Modal Foto KTP
    const ktpModal = document.getElementById("viewKTPModal");
    ktpModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const ktpSrc = button.getAttribute("data-ktp-src");
        document.getElementById("ktpImage").src = ktpSrc;
    });
});

</script>
