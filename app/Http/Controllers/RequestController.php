<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as VillaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RequestController extends Controller
{
    public function create()
    {
        $user_id = Auth::id();

        // Cek apakah user sudah memiliki request sebelumnya
        $existingRequest = VillaRequest::where('user_id', $user_id)->first();

        if ($existingRequest && $existingRequest->status === 'approved') {
            return redirect()->back()->with('error', 'Anda sudah menjadi Pemilik Villa, tidak dapat mengajukan lagi.');
        }
    
        if ($existingRequest) {
            return view('requests.create', compact('existingRequest'));
        }

        return view('requests.create', ['existingRequest' => null]);
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();

        // Cek apakah user sudah mengajukan permintaan sebelumnya
        $existingRequest = VillaRequest::where('user_id', $user_id)->first();

        if ($existingRequest) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan permintaan, harap tunggu persetujuan dari admin.');
        }

        $request->validate([
            'ktp_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'kk_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'villa_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'other_documents' => 'nullable|file|max:2048',
        ]);

        $ktpPath = $request->file('ktp_image')->store('documents', 'public');
        $kkPath = $request->file('kk_image')->store('documents', 'public');
        $villaPath = $request->file('villa_image') ? $request->file('villa_image')->store('documents', 'public') : null;

        // Simpan data ke database
        VillaRequest::create([
            'user_id' => $user_id,
            'ktp_image' => $ktpPath,
            'kk_image' => $kkPath,
            'villa_image' => $villaPath,
            'status' => 'pending',
            'expired_at' => now()->addHours(24),
        ]);

        return redirect()->route('customers.dashboard')->with('success', 'Pengajuan Anda telah dikirim. Menunggu persetujuan admin.');
    }
}
