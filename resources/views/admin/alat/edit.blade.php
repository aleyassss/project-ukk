<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Alat</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <form method="POST" action="{{ route('admin.alat.update', $alat) }}" class="space-y-3">
                @csrf
                @method('PUT')
                <input type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}" class="border-gray-300 rounded-md w-full">
                <select name="kategori_id" class="border-gray-300 rounded-md w-full">
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" @selected(old('kategori_id', $alat->kategori_id) == $k->id)>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
                <input type="number" min="0" name="stok" value="{{ old('stok', $alat->stok) }}" class="border-gray-300 rounded-md w-full">
                @foreach ($errors->all() as $e)
                    <p class="text-red-600 text-sm">{{ $e }}</p>
                @endforeach
                <div class="flex gap-3">
                    <button class="bg-gray-800 text-white rounded-md px-4 py-2">Simpan</button>
                    <a href="{{ route('admin.alat.index') }}" class="px-4 py-2 text-gray-600">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>