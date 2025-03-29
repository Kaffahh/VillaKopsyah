@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Add Villa Type</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            
            <form action="{{ route('admin.villa_types.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description:</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.villa_types.index') }}" class="btn btn-secondary">Back to List</a>
            </form>
        </div>
    </div>
</div>

@endsection
