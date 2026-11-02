<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Peminjaman</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            @if (session('error')) <div class="bg-red-100 text-red-800 p-3 rounded mb-3">{{ session('error') }}</div> @endif
            <p class="mb-3 text-sm text-gray-600">
                {{ $peminjaman->user->name ?? '-' }} meminjam {{ $peminjaman->alat->nama_alat ?? '-' }}
                (status: {{ $peminjaman->status }})
            </p>
            <form method="POST" action="{{ route('admin.peminjaman.update', $peminjaman) }}" class="space-y-3">
                @csrf @method('PUT')
                @if ($peminjaman->status === 'menunggu')
                    <label class="block text-sm">Jumlah</label>
                    <input type="number" name="jumlah" min="1" value="{{ old('jumlah', $peminjaman->jumlah) }}" class="border-gray-300 rounded-md w-full">
                @endif
                <label class="block text-sm">Tanggal rencana kembali</label>
                <input type="date" name="tgl_kembali_rencana" value="{{ old('tgl_kembali_rencana', $peminjaman->tgl_kembali_rencana) }}" class="border-gray-300 rounded-md w-full">
                @foreach ($errors->all() as $e) <p class="text-red-600 text-sm">{{ $e }}</p> @endforeach
                <div class="flex gap-3">
                    <button class="bg-gray-800 text-white rounded-md px-4 py-2">Simpan</button>
                    <a href="{{ route('admin.peminjaman.index') }}" class="px-4 py-2 text-gray-600">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>