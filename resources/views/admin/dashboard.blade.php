@extends('layouts.app')

@section('content')
    <div class="container mb-4">
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

                        <h2>You are a Admin User.</h2>

                        <a href="{{ route('admin.pemilik_villa.index') }}" class="btn btn-primary">Lihat Pemilik Villa</a>
                        <a href="{{ route('admin.petugas.index') }}" class="btn btn-primary">Lihat Petugas</a>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-primary">Lihat Customer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
