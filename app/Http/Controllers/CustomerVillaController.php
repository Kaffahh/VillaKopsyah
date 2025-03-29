<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use App\Models\VillaType;
use Illuminate\Http\Request;

class CustomerVillaController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar
        $query = Villa::with(['type', 'facilities', 'prices', 'capacities'])
            ->where('status', 'available');

        // Filter berdasarkan lokasi
        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filter berdasarkan tipe villa
        if ($request->has('type')) {
            $query->where('type_id', $request->type);
        }

        // Filter berdasarkan kapasitas
        if ($request->has('capacity')) {
            $query->whereHas('capacities', function ($q) use ($request) {
                $q->where('capacity', '>=', $request->capacity);
            });
        }

        // Filter berdasarkan rentang harga
        if ($request->has('price_min') && $request->has('price_max')) {
            $query->whereHas('prices', function ($q) use ($request) {
                $q->whereBetween('price_per_night', [$request->price_min, $request->price_max]);
            });
        }

        // Ambil data villa
        $villas = $query->latest()->paginate(12);
        $types = VillaType::all();

        return view('customers.villas.index', compact('villas', 'types'));
    }

    public function show($id)
    {
        $villa = Villa::with([
            'type',
            'facilities',
            'prices',
            'capacities',
            'images',
            'user'
        ])->findOrFail($id);

        // Ambil villa serupa berdasarkan tipe
        $similarVillas = Villa::where('type_id', $villa->type_id)
            ->where('id', '!=', $villa->id)
            ->limit(4)
            ->get();

        return view('customers.villas.show', compact('villa', 'similarVillas'));
    }
}
