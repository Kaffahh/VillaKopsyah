@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="{{ route('admin.pemilik_villa.create') }}" class="btn btn-primary btn-sm ">Tambahkan Pemilik Villa</a>

                        <h2>Daftar Pemilik Villa</h2>
                        <table class="table" border="1">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" class="text-center">Gender</th>
                                    <th scope="col" class="text-center">Birthdate</th>
                                    {{-- <th scope="col" class="text-center">Profile</th> --}}
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pemilik_villas as $pemilik_villa)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $pemilik_villa->user->name }}</td>
                                        <td>{{ $pemilik_villa->user->email }}</td>
                                        <td class="text-center">{{ $pemilik_villa->gender }}</td>
                                        <td class="text-center">{{ $pemilik_villa->birthdate }}</td>
                                        {{-- <td>
                                            @if ($pemilik_villa->profile == null)
                                                <img src="{{ asset('storage/profiles/blank-user.jpg') }}" alt="Profile" width="100">
                                            @else
                                                <img src="{{ asset('storage/' . $pemilik_villa->profile) }}" alt="Profile" width="100">
                                            @endif
                                        </td> --}}
                                        <td class="text-center">
                                            <a href="{{ route('admin.pemilik_villa.edit', $pemilik_villa->id) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('admin.pemilik_villa.destroy', $pemilik_villa->id) }}" method="POST" style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
