<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Alat</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if ($errors->any())
                <div class="p-3 bg-red-100 text-red-800 rounded">{{ $errors->first() }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b"><th class="py-2">Alat</th><th>Kategori</th><th>Stok</th><th>Ajukan Pinjam</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($alat as $a)
                            <tr class="border-b">
                                <td class="py-2">{{ $a->nama_alat }}</td>
                                <td>{{ $a->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ $a->stok }}</td>
                                <td class="py-2">
                                    <form method="POST" action="{{ route('peminjam.ajukan') }}" class="flex gap-2 items-center">
                                        @csrf
                                        <input type="hidden" name="alat_id" value="{{ $a->id }}">
                                        <input type="number" name="jumlah" min="1" value="1" class="border-gray-300 rounded w-20" required>
                                        <input type="date" name="tgl_kembali" min="{{ now()->toDateString() }}" class="border-gray-300 rounded" required>
                                        <button class="px-3 py-2 bg-gray-800 text-white rounded">Pinjam</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>