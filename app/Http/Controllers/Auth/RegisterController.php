<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $provinces = Province::all();
        return view('auth.register', compact('provinces'));
    }

    public function registerCustomer(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'fullname' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'address' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'province_code' => 'required',
            'city_code' => 'required',
            'district_code' => 'required',
            'village_code' => 'required',
            'rtrw' => 'required',
            'kode_pos' => 'required',
            'nomor_rumah' => 'required',
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain.',
        ]);

        // Gunakan transaksi database
        DB::beginTransaction();

        try {
            // Buat user baru dengan role "customers"
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customers',
            ]);

            // Simpan data tambahan di tabel customers
            Customer::create([
                'user_id' => $user->id,
                'fullname' => $request->fullname,
                'gender' => $request->gender,
                'address' => $request->address,
                'job' => $request->job,
                'birthdate' => $request->birthdate,
                'province_code' => $request->province_code,
                'city_code' => $request->city_code,
                'district_code' => $request->district_code,
                'village_code' => $request->village_code,
                'rtrw' => $request->rtrw,
                'kode_pos' => $request->kode_pos,
                'nomor_rumah' => $request->nomor_rumah,
            ]);

            // Commit transaksi jika tidak ada error
            DB::commit();

            // Login otomatis setelah register
            Auth::login($user);

            // Redirect ke dashboard berdasarkan role
            return redirect($this->redirectTo())->with('success', 'Registrasi berhasil. Selamat datang!');
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            return back()->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }

    public function register(Request $request)
    {
        return $this->registerCustomer($request);
    }

    protected function redirectTo()
    {
        return match (auth()->user()->role) {
            'admin' => route('admin.dashboard'),
            'pemilik_villa' => route('pemilik_villa.dashboard'),
            'petugas' => route('petugas.dashboard'),
            'customers' => route('customers.dashboard'),
            default => route('login')
        };
    }
}
