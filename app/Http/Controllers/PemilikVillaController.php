<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Image;
use App\Models\User;
use App\Models\Villa;
use App\Models\VillaType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PemilikVillaController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('petugas.profile.index', compact('user'));
    }

    public function pemilikVillaProfile()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function create()
    {
        $users = User::where('role', 'pemilik_villa')->get();
        $types = VillaType::all();
        $facilities = Facility::all();

        return view('pemilik_villa.dashboard', compact('users', 'types', 'facilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:villa_types,id',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric',
            'capacity' => 'required|numeric',
            'location' => 'nullable|string',
            'facilities' => 'array',
            'facilities.*' => 'exists:facilities,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // 'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'images' => 'required|array|max:4', // Pastikan maksimal hanya 4 gambar
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048', // Setiap file harus berupa gambar (2MB max)
            'status' => 'required|in:available,booked',
        ]);
        // dd($request->all());

        $villaData = $request->except(['facilities', 'price_per_night', 'capacity', 'images']);
        $villaData['user_id'] = Auth::id();
        $villaData['created_by'] = Auth::id();

        // Simpan thumbnail utama
        if ($request->hasFile('image')) {
            $villaData['image'] = $request->file('image')->store('villas', 'public');
        }

        $villa = Villa::create($villaData);

        $villa->prices()->create(['price_per_night' => $request->price_per_night]);
        $villa->capacities()->create(['capacity' => $request->capacity]);

        $villa->facilities()->attach($request->facilities ?? []);

        // Simpan foto lainnya (maksimal 4)
        if ($request->hasFile('images')) {
            foreach (array_slice($request->file('images'), 0, 4) as $file) {
                $path = $file->store('villa_images', 'public'); // Simpan di storage

                // Simpan ke database
                Image::create([
                    'villa_id' => $villa->id,
                    'url' => $path,
                ]);
            }
        }

        return redirect()->route('pemilik_villa.dashboard')->with('success', 'Villa berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $villa = Villa::with(['type', 'facilities', 'images', 'prices', 'capacities'])->findOrFail($id);

        // Pastikan hanya pemilik villa yang bisa mengedit
        if ($villa->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $types = VillaType::all();
        $facilities = Facility::all();

        return view('pemilik_villa.villas.edit', compact('villa', 'types', 'facilities'));
    }

    /**
     * Update data villa
     */
    public function update(Request $request, $id)
    {
        $villa = Villa::findOrFail($id);

        // Validasi kepemilikan
        if ($villa->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:villa_types,id',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric',
            'capacity' => 'required|numeric',
            'location' => 'nullable|string',
            'facilities' => 'array',
            'facilities.*' => 'exists:facilities,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images' => 'nullable|array|max:4',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:available,booked',
        ]);

        $villaData = $request->except(['facilities', 'price_per_night', 'capacity', 'images']);

        // Update thumbnail utama jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($villa->image) {
                Storage::disk('public')->delete($villa->image);
            }
            $villaData['image'] = $request->file('image')->store('villas', 'public');
        }

        $villa->update($villaData);

        // Update harga
        $villa->prices()->create(['price_per_night' => $request->price_per_night]);

        // Update kapasitas
        $villa->capacities()->create(['capacity' => $request->capacity]);

        // Sync fasilitas
        $villa->facilities()->sync($request->facilities ?? []);

        // Update foto lainnya (maksimal 4)
        if ($request->hasFile('images')) {
            // Hapus gambar lama
            foreach ($villa->images as $image) {
                Storage::disk('public')->delete($image->url);
                $image->delete();
            }

            // Simpan gambar baru
            foreach (array_slice($request->file('images'), 0, 4) as $file) {
                $path = $file->store('villa_images', 'public');
                Image::create([
                    'villa_id' => $villa->id,
                    'url' => $path,
                ]);
            }
        }

        return redirect()->route('pemilik_villa.dashboard')->with('success', 'Villa berhasil diperbarui!');
    }

    /**
     * Hapus villa
     */
    public function destroy($id)
    {
        $villa = Villa::findOrFail($id);

        // Validasi kepemilikan
        if ($villa->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus gambar utama
        if ($villa->image) {
            Storage::disk('public')->delete($villa->image);
        }

        // Hapus gambar lainnya
        foreach ($villa->images as $image) {
            Storage::disk('public')->delete($image->url);
            $image->delete();
        }

        // Hapus relasi
        $villa->prices()->delete();
        $villa->capacities()->delete();
        $villa->facilities()->detach();

        // Hapus villa
        $villa->delete();

        return redirect()->route('pemilik_villa.dashboard')->with('success', 'Villa berhasil dihapus!');
    }

    public function getFacilities($id)
    {
        $villa = Villa::findOrFail($id);
        return response()->json($villa->facilities->pluck('id'));
    }

    public function getImages($id)
    {
        $villa = Villa::findOrFail($id);
        return response()->json([
            'main_image' => $villa->image,
            'other_images' => $villa->images->pluck('url')
        ]);
    }
}
