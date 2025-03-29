@extends('layouts.app')

@section('content')
<div class="container mb-4">
    <h1>Add Customer</h1>
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="address">Address:</label>
        <input type="text" name="address" required><br>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br>

        <label for="job">Job:</label>
        <input type="text" name="job" required><br>

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate" required><br>

        <button type="submit">Save</button>
    </form>
    <a href="{{ route('customers.index') }}">Back to List</a>
</div>
@endsection