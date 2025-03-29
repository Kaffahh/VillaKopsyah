@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Create Facility</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.facilities.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Fasilitas</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $facility->name ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="detail" class="form-label">Detail (Opsional)</label>
                        <textarea class="form-control" id="detail" name="detail">{{ old('detail', $facility->detail ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">Back to List</a>

                </form>
            </div>
        </div>
    </div>
@endsection
