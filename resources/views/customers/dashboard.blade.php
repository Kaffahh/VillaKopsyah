@extends('layouts.app')

@section('content')
    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <!-- Tampilkan Notifikasi -->
                    @if (auth()->user()->unreadNotifications->isNotEmpty())
                        <div class="alert alert-info m-3">
                            <h4>Notifikasi</h4>
                            <ul>
                                @foreach (auth()->user()->unreadNotifications as $notification)
                                    <li>
                                        {{ $notification->data['message'] }}
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info">Tandai Sudah Dibaca</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a href="{{ route('requests.create') }}" class="btn mb-2 btn-primary">Request Role <i class="bi bi-list-task"></i></a>

                        <h2>You are a Customer.</h2>
                    </div>
                    @if (Auth::user()->role == 'pemilik_villa')
                        <div class="card-footer">
                            <a href="{{ route('pemilik_villa.dashboard') }}" class="btn mb-2 btn-primary">Pergi ke Dashboard Pemilik Villa <i class="bi bi-speedometer2"></i></a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
