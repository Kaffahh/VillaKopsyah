@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header py-3"><h4 class="mb-0">Daftar Pemilik Villa</h4></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('admin.pemilik_villa.create') }}" class="btn btn-primary btn-sm mb-3">Tambahkan Pemilik
                        Villa</a>
                    <table class="table table-bordered table-hover text-center table-striped" border="1">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Birthdate</th>
                                {{-- <th scope="col">Profile</th> --}}
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemilik_villas as $pemilik_villa)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pemilik_villa->user->name }}</td>
                                    <td>{{ $pemilik_villa->user->email }}</td>
                                    <td>{{ $pemilik_villa->gender }}</td>
                                    <td>{{ $pemilik_villa->birthdate }}</td>
                                    {{-- <td>
                                            @if ($pemilik_villa->profile == null)
                                                <img src="{{ asset('storage/profiles/blank-user.jpg') }}" alt="Profile" width="100">
                                            @else
                                                <img src="{{ asset('storage/' . $pemilik_villa->profile) }}" alt="Profile" width="100">
                                            @endif
                                        </td> --}}
                                    <td>
                                        <a href="{{ route('admin.pemilik_villa.edit', $pemilik_villa->id) }}"
                                            class="btn btn-primary">Edit</a>
                                        <form action="{{ route('admin.pemilik_villa.destroy', $pemilik_villa->id) }}"
                                            method="POST" style="display: inline-block">
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
@endsection
