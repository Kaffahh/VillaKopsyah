@extends('layouts.app')

@section('content')
<div class="mt-4">
    <div class="card shadow-sm">
        <div class="card-header py-3"><h4 class="mb-0">Villa Types</h4></div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-3">
                <a href="{{ route('admin.villa_types.create') }}" class="btn btn-primary btn-sm">Add New Type</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($types as $type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $type->name }}</td>
                                <td style="max-width: 250px;">{{ $type->description }}</td>
                                <td>
                                    <a href="{{ route('admin.villa_types.edit', $type->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.villa_types.destroy', $type->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this type?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No villa types available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection