@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <h2>Tambahkan Siswa</h2>

                            <form method="POST" action="{{ route('admin.siswa.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="fullname">Fullname</label>
                                    <input type="text" class="form-control" name="fullname" id="fullname">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="class">Class</label>
                                    <input type="text" class="form-control" name="class" id="class">
                                </div>
                                <div class="form-group">
                                    <label for="nisn">NISN</label>
                                    <input type="number" class="form-control @error('nisn') is-invalid @enderror" name="nisn" id="nisn" required value="{{ old('nisn') }}">
                                    @error('nisn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="absen">Absen</label>
                                    <input type="number" class="form-control @error('absen') is-invalid @enderror" name="absen" id="absen" required value="{{ old('absen') }}">
                                    @error('absen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="profile">Profile ( Max size 5mb )</label>
                                    <input type="file" class="form-control" name="profile" id="profile" accept="image/*" onchange="validateFileSize(this)">
                                    <script>
                                        function validateFileSize(input) {
                                            if (input.files[0].size > 5048000) {
                                                alert("Ukuran file terlalu besar! Maksimal 5MB.");
                                                input.value = "";
                                            }
                                        }
                                    </script>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
