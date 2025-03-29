<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with('user')->get();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = Customer::with('user')->findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::with('user')->findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->user->id,
            'fullname' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'address' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {
            // Update user
            $customer = Customer::findOrFail($id);
            $user = $customer->user;
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update customer
            $customer->update([
                'fullname' => $request->fullname,
                'gender' => $request->gender,
                'address' => $request->address,
                'job' => $request->job,
                'birthdate' => $request->birthdate,
            ]);

            DB::commit();
            return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating customer: ' . $e->getMessage());
        }
        
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->user()->delete(); // Hapus user juga
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully.');
    }
}
