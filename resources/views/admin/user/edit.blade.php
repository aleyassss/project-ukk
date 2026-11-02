<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow sm:rounded-lg">
            @if ($errors->any())
                <div class="p-3 mb-3 bg-red-100 text-red-800 rounded">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('admin.user.update', $user) }}" class="space-y-3">
                @csrf
                @method('PUT')
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border-gray-300 rounded w-full" required>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="border-gray-300 rounded w-full" required>
                <input type="password" name="password" placeholder="Password baru (kosongkan jika tidak diganti)" class="border-gray-300 rounded w-full">
                <select name="role" class="border-gray-300 rounded w-full" required>
                    @foreach (['admin', 'petugas', 'peminjam'] as $r)
                        <option value="{{ $r }}" @selected(old('role', $user->role) == $r)>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-gray-800 text-white rounded">Simpan</button>
                    <a href="{{ route('admin.user.index') }}" class="px-4 py-2 border rounded">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>