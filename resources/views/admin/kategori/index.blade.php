<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Kategori</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('sukses'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('sukses') }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('admin.kategori.store') }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="nama_kategori" placeholder="Nama kategori" class="border-gray-300 rounded flex-1" required>
                    <button class="px-4 py-2 bg-gray-800 text-white rounded">Tambah</button>
                </form>
                @error('nama_kategori') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b"><th class="py-2">No</th><th>Nama Kategori</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $k)
                            <tr class="border-b">
                                <td class="py-2">{{ $loop->iteration }}</td>
                                <td>{{ $k->nama_kategori }}</td>
                                <td class="flex gap-3 py-2">
                                    <a href="{{ route('admin.kategori.edit', $k) }}" class="text-blue-600">Edit</a>
                                    <form method="POST" action="{{ route('admin.kategori.destroy', $k) }}" onsubmit="return confirm('Hapus kategori ini?')">
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
    </div>
</x-app-layout>