@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-3">Daftar Villa Saya</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createVillaModal">Tambah Villa</button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card p-4 shadow-sm">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Villa</th>
                    <th>Tipe</th>
                    <th>Harga / Malam</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($villas as $villa)
                <tr>
                    <td>{{ $villa->name }}</td>
                    <td>{{ $villa->type->name }}</td>
                    <td>Rp {{ number_format($villa->prices->last()->price_per_night ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $villa->capacities->last()->capacity ?? 0 }} orang</td>
                    <td>{{ ucfirst($villa->status) }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $villa->id }}" data-name="{{ $villa->name }}" data-type_id="{{ $villa->type_id }}" data-price="{{ $villa->prices->last()->price_per_night ?? 0 }}" data-capacity="{{ $villa->capacities->last()->capacity ?? 0 }}" data-description="{{ $villa->description }}" data-location="{{ $villa->location }}" data-status="{{ $villa->status }}">Edit</button>
                        <form action="{{ route('pemilik_villa.villas.destroy', $villa->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus villa ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create -->
@include('pemilik_villa.villas.modal_create')

<!-- Modal Edit -->
@include('pemilik_villa.villas.modal_edit')

<!-- jQuery Script -->
<script>
    $(document).ready(function () {
        $('.btn-edit').click(function () {
            $('#editVillaModal').modal('show');
            $('#editVillaForm').attr('action', '/pemilik_villa/villas/' + $(this).data('id'));
            $('#editVillaModal input[name="name"]').val($(this).data('name'));
            $('#editVillaModal select[name="type_id"]').val($(this).data('type_id'));
            $('#editVillaModal input[name="price_per_night"]').val($(this).data('price'));
            $('#editVillaModal input[name="capacity"]').val($(this).data('capacity'));
            $('#editVillaModal textarea[name="description"]').val($(this).data('description'));
            $('#editVillaModal textarea[name="location"]').val($(this).data('location'));
            $('#editVillaModal select[name="status"]').val($(this).data('status'));
        });
    });
</script>
@endsection
