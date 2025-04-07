@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit Customer</div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ $customer->user->name }}" 
                                class="form-control" 
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ $customer->user->email }}" 
                                class="form-control" 
                                required>
                        </div>

                        {{-- 
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control" 
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password:</label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="form-control" 
                                required>
                        </div>
                        --}}

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender:</label>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="Male" {{ $customer->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $customer->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <input 
                                type="text" 
                                id="address" 
                                name="address" 
                                value="{{ $customer->address }}" 
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="job" class="form-label">Job:</label>
                            <input 
                                type="text" 
                                id="job" 
                                name="job" 
                                value="{{ $customer->job }}" 
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Birthdate:</label>
                            <input 
                                type="date" 
                                id="birthdate" 
                                name="birthdate" 
                                value="{{ $customer->birthdate }}" 
                                class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection