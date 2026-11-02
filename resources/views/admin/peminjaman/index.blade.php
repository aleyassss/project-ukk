<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Peminjaman & Pengembalian</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('success')) <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div> @endif
        @if (session('error')) <div class="bg-red-100 text-red-800 p-3 rounded">{{ session('error') }}</div> @endif
        @foreach ($errors->all() as $e) <p class="text-red-600 text-sm">{{ $e }}</p> @endforeach

        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h3 class="font-semibold mb-3">Tambah Peminjaman</h3>
            <form method="POST" action="{{ route('admin.peminjaman.store') }}" class="grid grid-cols-1 sm:grid-cols-5 gap-3">
                @csrf
                <select name="user_id" class="border-gray-300 rounded-md">
                    <option value="">Peminjam</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}" @selected(old('user_id') == $u->id)>{{ $u->name }}</option>
                    @endforeach
                </select>
                <select name="alat_id" class="border-gray-300 rounded-md">
                    <option value="">Alat</option>
                    @foreach ($alat as $a)
                        <option value="{{ $a->id }}" @selected(old('alat_id') == $a->id)>{{ $a->nama_alat }} (stok {{ $a->stok }})</option>
                    @endforeach
                </select>
                <input type="number" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" class="border-gray-300 rounded-md">
                <input type="date" name="tgl_kembali" min="{{ date('Y-m-d') }}" value="{{ old('tgl_kembali') }}" class="border-gray-300 rounded-md">
                <button class="bg-gray-800 text-white rounded-md px-4 py-2">Tambah</button>
            </form>
        </div>

        <div class="bg-white p-6 shadow sm:rounded-lg overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Peminjam</th><th>Alat</th><th>Jml</th><th>Pinjam</th>
                        <th>Rencana</th><th>Kembali</th><th>Status</th><th>Denda</th><th>Petugas</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $p)
                        <tr class="border-b">
                            <td class="py-2">{{ $p->user->name ?? '-' }}</td>
                            <td>{{ $p->alat->nama_alat ?? '-' }}</td>
                            <td>{{ $p->jumlah }}</td>
                            <td>{{ $p->tgl_pinjam }}</td>
                            <td>{{ $p->tgl_kembali_rencana }}</td>
                            <td>{{ $p->tgl_kembali_real ?? '-' }}</td>
                            <td>{{ $p->status }}</td>
                            <td>Rp {{ number_format($p->denda, 0, ',', '.') }}</td>
                            <td>{{ $p->petugas->name ?? '-' }}</td>
                            <td class="flex flex-wrap gap-2 py-2">
                                @if ($p->status === 'menunggu')
                                    <form method="POST" action="{{ route('admin.peminjaman.setujui', $p) }}">
                                        @csrf <button class="text-green-700">Setujui</button>
                                    </form>
                                @elseif ($p->status === 'disetujui')
                                    <form method="POST" action="{{ route('admin.peminjaman.kembalikan', $p) }}" onsubmit="return confirm('Terima pengembalian?')">
                                        @csrf <button class="text-green-700">Kembalikan</button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.peminjaman.edit', $p) }}" class="text-blue-600">Edit</a>
                                <form method="POST" action="{{ route('admin.peminjaman.destroy', $p) }}" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="py-4 text-gray-500">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>