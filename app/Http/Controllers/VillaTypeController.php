<?php

namespace App\Http\Controllers;

use App\Models\VillaType;
use Illuminate\Http\Request;

class VillaTypeController extends Controller
{
    public function index()
    {
        $types = VillaType::all();
        return view('admin.villa_types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.villa_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        VillaType::create($request->all());
        return redirect()->route('admin.villa_types.index')->with('success', 'Villa Type created successfully.');
    }

    public function edit(VillaType $villaType)
    {
        return view('admin.villa_types.edit', compact('villaType'));
    }

    public function update(Request $request, VillaType $villaType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $villaType->update($request->all());
        return redirect()->route('admin.villa_types.index')->with('success', 'Villa Type updated successfully.');
    }

    public function destroy(VillaType $villaType)
    {
        $villaType->delete();
        return redirect()->route('admin.villa_types.index')->with('success', 'Villa Type deleted successfully.');
    }
}
