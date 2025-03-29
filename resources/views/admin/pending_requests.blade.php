@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Daftar Pengajuan Menjadi Pemilik Villa</h2>
        <table class="table table-bordered">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Dokumen</th>
                    <th>Foto Villa</th>
                    <th>Status</th>
                    <th>Expired At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (empty($requests) || $requests->isEmpty())
                    <tr class="text-center">
                        <td colspan="8">Tidak ada pengajuan</td>
                    </tr>
                @else
                    @if (session('success'))
                        <tr class="text-center">
                            <td colspan="8">
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            </td>
                        </tr>
                    @endif
                    @foreach ($requests as $request)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->user->email }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $request->ktp_image) }}" target="_blank">KTP</a> |
                                <a href="{{ asset('storage/' . $request->kk_image) }}" target="_blank">KK</a>
                            </td>
                            <td>
                                <img src="{{ asset('storage/' . $request->villa_image) }}" class="img-thumbnail image-cover" alt="Foto Villa" width="300">
                            </td>
                            <td class="text-center">
                                @if ($request->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif ($request->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($request->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif ($request->status == 'expired')
                                    <span class="badge bg-secondary">Expired</span>
                                @endif
                            </td>
                            {{-- <td>{{ $request->expired_at ? $request->expired_at->format('d M Y H:i') : '-' }}</td> --}}
                            <td>{{ $request->expired_at ? \Carbon\Carbon::parse($request->expired_at)->format('d M Y H:i') : '-' }}</td>
                            <td>
                                @if ($request->status == 'pending')
                                    <form method="POST" action="{{ route('admin.approve', $request->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.reject', $request->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                @else
                                    <span class="text-muted">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection