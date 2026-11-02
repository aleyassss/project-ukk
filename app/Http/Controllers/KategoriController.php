<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('admin.kategori.index', [
            'kategori' => Kategori::orderBy('nama_kategori')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['nama_kategori' => 'required|string|max:100']);
        Kategori::create($data);
        LogAktivitas::catat('Menambah kategori: ' . $data['nama_kategori']);

        return back()->with('sukses', 'Kategori berhasil ditambah.');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate(['nama_kategori' => 'required|string|max:100']);
        $kategori->update($data);
        LogAktivitas::catat('Mengubah kategori: ' . $data['nama_kategori']);

        return redirect()->route('admin.kategori.index')->with('sukses', 'Kategori berhasil diubah.');
    }

    public function destroy(Kategori $kategori)
    {
        $nama = $kategori->nama_kategori;
        $kategori->delete();
        LogAktivitas::catat('Menghapus kategori: ' . $nama);

        return back()->with('sukses', 'Kategori berhasil dihapus.');
    }
}