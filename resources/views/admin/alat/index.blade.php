<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Alat</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded">{{ session('error') }}</div>
        @endif

        <div class="bg-white p-6 shadow sm:rounded-lg">
            <form method="POST" action="{{ route('admin.alat.store') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                @csrf
                <input type="text" name="nama_alat" value="{{ old('nama_alat') }}" placeholder="Nama alat" class="border-gray-300 rounded-md sm:col-span-2">
                <select name="kategori_id" class="border-gray-300 rounded-md">
                    <option value="">Pilih kategori</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" @selected(old('kategori_id') == $k->id)>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
                <input type="number" min="0" name="stok" value="{{ old('stok', 0) }}" class="border-gray-300 rounded-md">
                <button class="bg-gray-800 text-white rounded-md px-4 py-2 sm:col-span-4">Tambah</button>
            </form>
            @foreach ($errors->all() as $e)
                <p class="text-red-600 text-sm mt-2">{{ $e }}</p>
            @endforeach
        </div>

        <div class="bg-white p-6 shadow sm:rounded-lg">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">No</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alat as $a)
                        <tr class="border-b">
                            <td class="py-2">{{ $loop->iteration }}</td>
                            <td>{{ $a->nama_alat }}</td>
                            <td>{{ $a->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $a->stok }}</td>
                            <td class="flex gap-3 py-2">
                                <a href="{{ route('admin.alat.edit', $a) }}" class="text-blue-600">Edit</a>
                                <form method="POST" action="{{ route('admin.alat.destroy', $a) }}" onsubmit="return confirm('Hapus alat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>