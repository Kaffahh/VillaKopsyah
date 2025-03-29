<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request, $field)
    {
        $user = Auth::user();

        // Validasi data berdasarkan field
        $this->validate($request, [
            $field => 'required|string|max:255',
        ]);

        // Perbarui data pengguna
        $user->$field = $request->input($field);
        $user->save();

        return redirect()
            ->back()
            ->with('success', ucfirst($field) . ' berhasil diperbarui!');
    }
}
