@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <!-- Membatasi lebar form agar lebih ramping -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h4 class="mb-0">Edit Facility</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.facilities.update', $facility->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Fasilitas</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $facility->name ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail (Opsional)</label>
                            <textarea class="form-control" id="detail" name="detail" rows="3">{{ old('detail', $facility->detail ?? '') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-warning">Save</button>
                            <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection