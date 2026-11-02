<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Peminjaman</h2>
    </x-slot>

    <style>
        @media print {
            nav, header, .no-print { display: none !important; }
            body { background: #fff; }
        }
    </style>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow sm:rounded-lg overflow-x-auto">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-lg font-semibold">Rekap Peminjaman Alat dan Denda</h3>
                    <p class="text-sm text-gray-500">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
                </div>
                <button onclick="window.print()" class="no-print px-4 py-2 bg-gray-800 text-white rounded">Cetak</button>
            </div>

            <table class="w-full text-left text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">No</th>
                        <th class="border p-2">Peminjam</th>
                        <th class="border p-2">Alat</th>
                        <th class="border p-2">Jumlah</th>
                        <th class="border p-2">Tgl Pinjam</th>
                        <th class="border p-2">Rencana Kembali</th>
                        <th class="border p-2">Kembali</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $p)
                        <tr>
                            <td class="border p-2">{{ $loop->iteration }}</td>
                            <td class="border p-2">{{ $p->user->name ?? '-' }}</td>
                            <td class="border p-2">{{ $p->alat->nama_alat ?? '-' }}</td>
                            <td class="border p-2">{{ $p->jumlah }}</td>
                            <td class="border p-2">{{ $p->tgl_pinjam }}</td>
                            <td class="border p-2">{{ $p->tgl_kembali_rencana }}</td>
                            <td class="border p-2">{{ $p->tgl_kembali_real ?? '-' }}</td>
                            <td class="border p-2">{{ ucfirst($p->status) }}</td>
                            <td class="border p-2">Rp {{ number_format($p->denda, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="border p-3 text-gray-500">Belum ada data peminjaman.</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="font-semibold">
                        <td colspan="8" class="border p-2 text-right">Total Denda</td>
                        <td class="border p-2">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>