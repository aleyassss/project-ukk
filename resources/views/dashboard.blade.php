<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard {{ ucfirst(auth()->user()->role) }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <p class="text-gray-700">Selamat datang, {{ auth()->user()->name }}!</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <div class="text-sm text-gray-500">Menunggu Persetujuan</div>
                    <div class="text-3xl font-bold text-blue-700">{{ $menunggu }}</div>
                </div>
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <div class="text-sm text-gray-500">Sedang Dipinjam</div>
                    <div class="text-3xl font-bold text-blue-700">{{ $dipinjam }}</div>
                </div>
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <div class="text-sm text-gray-500">Peminjaman Selesai</div>
                    <div class="text-3xl font-bold text-blue-700">{{ $selesai }}</div>
                </div>
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="font-semibold mb-2">Tugas Anda</h3>
                <ol class="list-decimal ml-5 text-gray-700 space-y-1">
                    @if (auth()->user()->role === 'admin')
                        <li>Mengelola data user, alat, dan kategori</li>
                        <li>Mengelola data peminjaman dan pengembalian</li>
                        <li>Melihat log aktivitas</li>
                    @elseif (auth()->user()->role === 'petugas')
                        <li>Menyetujui pengajuan peminjaman alat</li>
                        <li>Memantau proses pengembalian alat</li>
                        <li>Melihat dan mencetak laporan peminjaman</li>
                    @else
                        <li>Melihat daftar alat yang tersedia</li>
                        <li>Mengajukan peminjaman alat</li>
                        <li>Mengembalikan alat yang dipinjam</li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</x-app-layout>