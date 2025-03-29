<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Request as ModelsRequest;
use App\Models\Villa;
use App\Models\VillaType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('customers.dashboard');
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->route('customers.dashboard');
    }

    public function adminDashboard()
    {
        $pendingRequests = ModelsRequest::where('status', 'pending')->get();

        return view('admin.dashboard.index', compact('pendingRequests'));
    }

    public function pemilikDashboard()
    {
        
        // $villas = Villa::where('created_by', Auth::id())->with(['type', 'facilities'])->get();
        $villas = Villa::where('user_id', auth()->id())->get();
        $types = VillaType::all();
        $facilities = Facility::all();

        return view('pemilik_villa.dashboard', compact('villas', 'types', 'facilities'));
    }

    public function petugasDashboard()
    {
        return view('petugas.dashboard');
    }
}
