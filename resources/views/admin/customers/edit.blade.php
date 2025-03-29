@extends('layouts.app')

@section('content')
<div class="container mb-4">
    <h2>Edit Customer</h2>
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name:</label>
        <input type="text" name="name" value="{{ $customer->user->name }}" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $customer->user->email }}" required><br>
{{-- 
        <label>Password:</label>
        <input type="password" name="password" required><br>
        
        <label>Confirm Password:</label>
        <input type="password" name="password_confirmation" required><br> --}}
        
        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male" {{ $customer->gender == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ $customer->gender == 'Female' ? 'selected' : '' }}>Female</option>
        </select><br>

        <label>Address:</label>
        <input type="text" name="address" value="{{ $customer->address }}"><br>

        <label>Job:</label>
        <input type="text" name="job" value="{{ $customer->job }}"><br>

        <label>Birthdate:</label>
        <input type="date" name="birthdate" value="{{ $customer->birthdate }}"><br>

        <button type="submit">Update</button>
    </form>
</div>
@endsection