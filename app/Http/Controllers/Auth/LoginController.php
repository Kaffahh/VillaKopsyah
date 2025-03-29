<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo()
    {
        $role = auth()->user()->role;
        return $this->getDashboardRoute($role);
    }
    //     protected function redirectTo()
    // {
    //     $role = auth()->user()->role;

    //     return match ($role) {
    //         'admin' => route('admin.dashboard'),
    //         'pemilik_villa' => route('pemilik_villa.dashboard'),
    //         'petugas' => route('petugas.dashboard'),
    //         'customers' => route('customers.dashboard'),
    //         default => route('login')
    //     };
    // }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $valid_data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(['email' => $valid_data['email'], 'password' => $valid_data['password']])) {
            $role = auth()->user()->role;
            return redirect()->route($this->getDashboardRoute($role));
        } else {
            return redirect()->route('login')->with('error', 'Email atau Password salah.');
        }
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();
        return redirect()->route('login')->with('success', 'Logout successfully');
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

    public function register(Request $request): RedirectResponse
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
}
