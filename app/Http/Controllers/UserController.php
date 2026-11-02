<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index', ['users' => User::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|alpha_dash|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'role'     => ['required', Rule::in(['admin', 'petugas', 'peminjam'])],
        ]);

        User::create([
            'name'     => $data['name'],
            'username' => $data['username'],
            'email'    => $data['username'] . '@mail.test',
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);
        LogAktivitas::catat('Menambah user: ' . $data['username']);

        return back()->with('sukses', 'User berhasil ditambah.');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'username' => ['required', 'alpha_dash', 'max:50', Rule::unique('users', 'username')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role'     => ['required', Rule::in(['admin', 'petugas', 'peminjam'])],
        ]);

        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->role = $data['role'];
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();
        LogAktivitas::catat('Mengubah user: ' . $user->username);

        return redirect()->route('admin.user.index')->with('sukses', 'User berhasil diubah.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['hapus' => 'Akun yang sedang dipakai tidak bisa dihapus.']);
        }

        try {
            $user->delete();
        } catch (QueryException $e) {
            return back()->withErrors(['hapus' => 'User tidak bisa dihapus karena sudah punya riwayat data.']);
        }

        LogAktivitas::catat('Menghapus user: ' . $user->username);

        return back()->with('sukses', 'User berhasil dihapus.');
    }
}