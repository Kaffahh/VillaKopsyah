@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <!-- Batasi lebar konten agar lebih ramping -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h4 class="mb-0">Edit Villa Type</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.villa_types.update', $villaType->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ $villaType->name }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description:</label>
                            <textarea class="form-control" rows="4" name="description" required>{{ $villaType->description }}</textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-warning" type="submit">Update</button>
                            <a href="{{ route('admin.villa_types.index') }}" class="btn btn-secondary">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection