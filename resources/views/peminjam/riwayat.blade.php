<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Peminjaman</h2>
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
                            <th class="py-2">Alat</th><th>Jumlah</th><th>Tgl Pinjam</th><th>Rencana Kembali</th>
                            <th>Kembali</th><th>Status</th><th>Denda</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $p)
                            <tr class="border-b">
                                <td class="py-2">{{ $p->alat->nama_alat ?? '-' }}</td>
                                <td>{{ $p->jumlah }}</td>
                                <td>{{ $p->tgl_pinjam }}</td>
                                <td>{{ $p->tgl_kembali_rencana }}</td>
                                <td>{{ $p->tgl_kembali_real ?? '-' }}</td>
                                <td>{{ ucfirst($p->status) }}</td>
                                <td>Rp {{ number_format($p->denda, 0, ',', '.') }}</td>
                                <td>
                                    @if ($p->status === 'disetujui')
                                        <form method="POST" action="{{ route('peminjam.kembali', $p) }}" onsubmit="return confirm('Kembalikan alat ini?')">
                                            @csrf
                                            <button class="text-blue-600">Kembalikan</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="py-4 text-gray-500">Belum ada peminjaman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>