<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kategori</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow sm:rounded-lg">
            <form method="POST" action="{{ route('admin.kategori.update', $kategori) }}" class="flex gap-2">
                @csrf
                @method('PUT')
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="border-gray-300 rounded flex-1" required>
                <button class="px-4 py-2 bg-gray-800 text-white rounded">Simpan</button>
                <a href="{{ route('admin.kategori.index') }}" class="px-4 py-2 border rounded">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>