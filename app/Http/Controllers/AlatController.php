<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $alat = Alat::with('kategori')->orderBy('nama_alat')->get();
        $kategori = Kategori::orderBy('nama_kategori')->get();
        return view('admin.alat.index', compact('alat', 'kategori'));
    }

    public function store(Request $request)
    {
        Alat::create($this->validasi($request));
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit(Alat $alat)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        return view('admin.alat.edit', compact('alat', 'kategori'));
    }

    public function update(Request $request, Alat $alat)
    {
        $alat->update($this->validasi($request));
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Alat $alat)
    {
        try {
            $alat->delete();
        } catch (QueryException $e) {
            return redirect()->route('admin.alat.index')->with('error', 'Alat tidak bisa dihapus karena sudah punya data peminjaman.');
        }
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dihapus.');
    }

    private function validasi(Request $request)
    {
        return $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'stok'        => 'required|integer|min:0',
        ]);
    }
}