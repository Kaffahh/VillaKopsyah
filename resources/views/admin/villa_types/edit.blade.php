@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Villa Type</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.villa_types.update', $villaType->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <input type="text" name="name" class="form-control" value="{{ $villaType->name }}" required><br>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description:</label>
                        <textarea class="form-control" rows="4" name="description">{{ $villaType->description }}</textarea><br>
                    </div>

                    <button class="btn btn-warning" type="submit">Update</button>
                    <a href="{{ route('admin.villa_types.index') }}" class="btn btn-secondary">Back to List</a>
                </form>
            </div>
        </div>
    </div>
@endsection
