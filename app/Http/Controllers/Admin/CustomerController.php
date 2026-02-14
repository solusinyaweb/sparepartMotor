<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // =========================
    // TAMPILKAN SEMUA DATA
    // =========================
    public function index()
    {
        $customers = User::where('role', 'user')->latest()->get();

        return view('admin.account.account', compact('customers'));
    }

    // =========================
    // FORM TAMBAH DATA
    // =========================
    public function create()
    {
        return view('admin.account.add-account');
    }

    // =========================
    // SIMPAN DATA BARU
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'required|string'
        ]);

        User::create($request->all());

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil ditambahkan');
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit(User $customer)
    {
        return view('admin.account.edit-account', compact('customer'));
    }

    // =========================
    // UPDATE DATA
    // =========================
    public function update(Request $request, User $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $customer->id,
            'password' => 'nullable|string|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'required|string'
        ]);

        if ($request->password) {
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address
            ]);
        } else {
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
        }

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil diupdate');
    }

    // =========================
    // HAPUS DATA
    // =========================
    public function destroy(User $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil dihapus');
    }
}
