<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pemantauan Pengembalian</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('sukses'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('sukses') }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Peminjam</th><th>Alat</th><th>Jumlah</th><th>Rencana Kembali</th><th>Keterangan</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $p)
                            <tr class="border-b">
                                <td class="py-2">{{ $p->user->name ?? '-' }}</td>
                                <td>{{ $p->alat->nama_alat ?? '-' }}</td>
                                <td>{{ $p->jumlah }}</td>
                                <td>{{ $p->tgl_kembali_rencana }}</td>
                                <td>
                                    @if ($p->tgl_kembali_rencana < now()->toDateString())
                                        <span class="text-red-600">Terlambat</span>
                                    @else
                                        Dipinjam
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('petugas.kembalikan', $p) }}" onsubmit="return confirm('Proses pengembalian alat ini?')">
                                        @csrf
                                        <button class="text-blue-600">Proses Kembali</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-4 text-gray-500">Tidak ada alat yang sedang dipinjam.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>