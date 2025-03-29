<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\Villa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $villas = Villa::all();
        $petugas_villas = Petugas::with('user')->get();
        return view('admin.petugas.index', compact('petugas_villas', 'villas'));
    }   

    public function checkVillaPetugas($villa)
    {
        $hasPetugas = Petugas::where('villa', $villa)->exists();
        return response()->json(['hasPetugas' => $hasPetugas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
