<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\User;
use App\Models\Villa;
use App\Models\VillaType;
use App\Models\VillaPrice;
use App\Models\VillaCapacity;
use App\Models\VillaImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillaController extends Controller
{
    // Tampilkan daftar villa
    public function index()
    {
        // Ambil data villa beserta relasi type, facilities, prices, dan capacities
        $villas = Villa::with(['type', 'facilities', 'prices', 'capacities'])->get();
        return view('admin.villas.index', compact('villas'));
    }

    // Form untuk tambah villa
    public function create()
    {
        $users = User::whereIn('role', ['pemilik_villa', 'customers'])->get();
        $facilities = Facility::all(); // Ambil semua fasilitas
        $types = VillaType::all();
        return view('admin.villas.create', compact('types', 'users', 'facilities'));
    }

    // Simpan data villa baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:villa_types,id',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string',
            'facilities' => 'array',
            'facilities.*' => 'exists:facilities,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,booked',
        ]);

        // Simpan data villa
        $villaData = $request->except(['facilities', 'price_per_night', 'capacity']);

        if ($request->hasFile('image')) {
            $villaData['image'] = $request->file('image')->store('villas', 'public');
        }

        $villa = Villa::create($villaData);

        // Simpan harga ke tabel villa_prices
        $villa->prices()->create([
            'price_per_night' => $request->price_per_night,
        ]);

        // Simpan kapasitas ke tabel villa_capacities
        $villa->capacities()->create([
            'capacity' => $request->capacity,
        ]);

        // Attach facilities ke villa
        $villa->facilities()->attach($request->facilities ?? []);

        return redirect()->route('admin.villas.index')->with('success', 'Villa berhasil ditambahkan!');
    }

    // Form edit villa
    public function edit(Villa $villa)
    {
        // Load semua relasi yang diperlukan
        $villa->load(['type', 'facilities', 'prices', 'capacities', 'images', 'user']);

        // Ambil data yang diperlukan untuk form
        $types = VillaType::all();
        $facilities = Facility::all();
        $users = User::where('role', 'pemilik_villa')->get();

        // Ambil data terbaru
        $latestPrice = $villa->prices()->latest()->first();
        $latestCapacity = $villa->capacities()->latest()->first();

        return view('admin.villas.edit', compact(
            'villa',
            'types',
            'facilities',
            'users',
            'latestPrice',
            'latestCapacity'
        ));
    }

    // Update data villa
    public function update(Request $request, Villa $villa)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:villa_types,id',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string',
            'status' => 'required|in:available,booked',
            'facilities' => 'array',
            'facilities.*' => 'exists:facilities,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array|max:4',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update data villa
        $villaData = $request->except(['facilities', 'price_per_night', 'capacity', 'images']);

        // Update gambar utama jika ada
        if ($request->hasFile('image')) {
            if ($villa->image) {
                Storage::disk('public')->delete($villa->image);
            }
            $villaData['image'] = $request->file('image')->store('villas', 'public');
        }

        $villa->update($villaData);

        // Update harga
        if ($request->filled('price_per_night')) {
            $villa->prices()->create(['price_per_night' => $request->price_per_night]);
        }

        // Update kapasitas
        if ($request->filled('capacity')) {
            $villa->capacities()->create(['capacity' => $request->capacity]);
        }

        // Update fasilitas
        $villa->facilities()->sync($request->facilities ?? []);

        // Update gambar tambahan
        if ($request->hasFile('images')) {
            // Simpan gambar baru
            foreach ($request->file('images') as $file) {
                $path = $file->store('villa_images', 'public');
                $villa->images()->create(['url' => $path]);
            }
        }

        return redirect()
            ->route('admin.villas.index')
            ->with('success', 'Villa berhasil diperbarui!');
    }

    // Hapus villa
    public function destroy(Villa $villa)
    {
        // Hapus relasi fasilitas
        $villa->facilities()->detach();

        $villa->prices()->delete();
        $villa->capacities()->delete();

        // Hapus gambar dari penyimpanan
        if ($villa->image) {
            Storage::disk('public')->delete($villa->image);
        }

        $villa->delete();

        return redirect()->route('admin.villas.index')->with('success', 'Villa berhasil dihapus!');
    }

    public function show(Villa $villa)
    {
        // Load relasi yang diperlukan
        $villa->load([
            'type',
            'facilities',
            'prices' => function ($query) {
                $query->latest();
            },
            'capacities' => function ($query) {
                $query->latest();
            },
            'images',
            'user'
        ]);

        // Ambil villa serupa berdasarkan tipe
        $similarVillas = Villa::where('type_id', $villa->type_id)
            ->where('id', '!=', $villa->id)
            ->with(['prices', 'capacities'])
            ->limit(4)
            ->get();

        return view('admin.villas.show', compact('villa', 'similarVillas'));
    }

    public function deleteImage(VillaImage $image)
    {
        try {
            // Hapus file dari storage
            if (Storage::disk('public')->exists($image->url)) {
                Storage::disk('public')->delete($image->url);
            }

            // Hapus record dari database
            $image->delete();

            return redirect()->back()->with('success', 'Gambar berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus gambar');
        }
    }
}
