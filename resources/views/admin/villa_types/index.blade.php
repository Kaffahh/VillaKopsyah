@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h1>Villa Types</h1>
        <a href="{{ route('admin.villa_types.create') }}" class="btn btn-primary mb-3">Add New Type</a>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($types as $type)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $type->name }}</td>
                        <td style="max-width">{{ $type->description }}</td>
                        <td>
                            <a href="{{ route('admin.villa_types.edit', $type->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.villa_types.destroy', $type->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this type?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
@endsection
