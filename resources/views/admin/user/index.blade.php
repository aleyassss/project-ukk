<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data User</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('sukses'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('sukses') }}</div>
            @endif
            @if ($errors->any())
                <div class="p-3 bg-red-100 text-red-800 rounded">{{ $errors->first() }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('admin.user.store') }}" class="grid grid-cols-1 md:grid-cols-5 gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Nama" class="border-gray-300 rounded" required>
                    <input type="text" name="username" placeholder="Username" class="border-gray-300 rounded" required>
                    <input type="password" name="password" placeholder="Password" class="border-gray-300 rounded" required>
                    <select name="role" class="border-gray-300 rounded" required>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="peminjam" selected>Peminjam</option>
                    </select>
                    <button class="px-4 py-2 bg-gray-800 text-white rounded">Tambah</button>
                </form>
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b"><th class="py-2">No</th><th>Nama</th><th>Username</th><th>Peran</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            <tr class="border-b">
                                <td class="py-2">{{ $loop->iteration }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->username }}</td>
                                <td>{{ ucfirst($u->role) }}</td>
                                <td class="flex gap-3 py-2">
                                    <a href="{{ route('admin.user.edit', $u) }}" class="text-blue-600">Edit</a>
                                    <form method="POST" action="{{ route('admin.user.destroy', $u) }}" onsubmit="return confirm('Hapus user ini?')">
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