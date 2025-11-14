<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Division;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return view('admin.users.index', [
            'users' => User::with('division')->whereNull('deleted_at')->get()
        ]);
    }

    public function create() {
        return view('admin.users.create', [
            'divisions' => Division::all()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name'        => 'required',
            'email'       => 'required|email|unique:users',
            'role'        => 'required',
            'division_id' => 'nullable|exists:divisions,id'
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => bcrypt('password'),
            'role'        => $request->role,
            'division_id' => $request->division_id,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user) {
        return view('admin.users.edit', [
            'user'       => $user,
            'divisions'  => Division::all()
        ]);
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name'        => 'required',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'role'        => 'required',
            'division_id' => 'nullable|exists:divisions,id'
        ]);

        $user->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'role'        => $request->role,
            'division_id' => $request->division_id,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user) {

        // ❗ Cegah delete jika user punya relasi transaksi
        if ($user->requests()->exists()) {
            return back()->with('error', 'User tidak dapat dihapus karena memiliki data request.');
        }

        if ($user->purchaseOrders()->exists()) {
            return back()->with('error', 'User tidak dapat dihapus karena memiliki purchase order.');
        }

        if ($user->stockTransactions()->exists()) {
            return back()->with('error', 'User tidak dapat dihapus karena memiliki transaksi stok.');
        }

        // Soft delete (tidak hilang dari histori)
        $user->delete();

        return back()->with('success', 'User berhasil dinonaktifkan.');
    }
}
