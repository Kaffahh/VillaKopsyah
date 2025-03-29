<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan Anda mengimpor model User

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    public function register(Request $request)
    {
        $valid_data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,pemilik_villa,petugas,customers',
        ]);

        $user = User::create([
            'name' => $valid_data['name'],
            'email' => $valid_data['email'],
            'password' => bcrypt($valid_data['password']),
            'role' => $valid_data['role'],
        ]);

        auth()->login($user); // Otomatis login setelah registrasi

        return redirect()->route($this->getDashboardRoute($user->role));
    }

    protected function getDashboardRoute($role)
    {
        switch ($role) {
            case 'admin':
                return 'admin.dashboard';
            case 'pemilik_villa':
                return 'pemilik_villa.dashboard';
            case 'petugas':
                return 'petugas.dashboard';
            case 'customers':
                return 'customers.dashboard';
            default:
                return 'login';
        }
    }
}