<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Villa;
use App\Models\VillaType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OwnerVillaController extends Controller
{
    public function index()
    {
        $villas = Villa::where('created_by', Auth::id())->with(['type', 'facilities'])->get();
        return view('owner.villas.index', compact('villas'));
    }

    public function create()
    {
        $types = VillaType::all();
        $facilities = Facility::all();
        return view('owner.villas.create', compact('types', 'facilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:villa_types,id',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string',
            'facilities' => 'array',
            'facilities.*' => 'exists:facilities,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,booked',
        ]);

        $villaData = $request->except(['facilities', 'price_per_night', 'capacity']);
        $villaData['user_id'] = Auth::id();
        $villaData['created_by'] = Auth::id();

        if ($request->hasFile('image')) {
            $villaData['image'] = $request->file('image')->store('villas', 'public');
        }

        $villa = Villa::create($villaData);

        $villa->prices()->create(['price_per_night' => $request->price_per_night]);
        $villa->capacities()->create(['capacity' => $request->capacity]);
        $villa->facilities()->attach($request->facilities ?? []);

        return redirect()->route('owner.villas.index')->with('success', 'Villa berhasil ditambahkan!');
    }
}
