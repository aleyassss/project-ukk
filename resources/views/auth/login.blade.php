<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | Peminjaman Alat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
<main class="min-h-screen grid lg:grid-cols-2">

    <section class="relative overflow-hidden bg-teal-800 text-white px-8 py-10 lg:px-16 lg:py-0 flex flex-col justify-center">
        <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-amber-400/20"></div>
        <div class="absolute -bottom-32 -left-20 h-80 w-80 rounded-full bg-teal-600/40"></div>

        <div class="relative max-w-md">
            <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-400 text-teal-900">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.8 2.8-2.4-.6-.6-2.4 2.8-2.8Z"/>
                </svg>
            </div>

            <h1 class="mt-6 text-4xl font-bold tracking-tight">Peminjaman Alat</h1>
            <p class="mt-3 text-teal-100 leading-relaxed">
                Ajukan peminjaman, pantau pengembalian, dan hitung denda keterlambatan dalam satu tempat.
            </p>

            <ul class="mt-8 space-y-3 text-sm">
                <li class="flex gap-3"><span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-amber-400"></span><span><b>Admin</b> mengelola data user, alat, dan kategori.</span></li>
                <li class="flex gap-3"><span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-amber-400"></span><span><b>Petugas</b> menyetujui peminjaman dan mencetak laporan.</span></li>
                <li class="flex gap-3"><span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-amber-400"></span><span><b>Peminjam</b> mengajukan dan mengembalikan alat.</span></li>
            </ul>
        </div>
    </section>

    <section class="flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-sm">
            <h2 class="text-2xl font-bold">Masuk ke akun</h2>
            <p class="mt-1 text-slate-500">Gunakan username dan password dari admin.</p>

            @if (session('status'))
                <div class="mt-4 rounded-lg bg-teal-50 p-3 text-sm text-teal-800">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-medium">Username</label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}"
                           required autofocus autocomplete="username"
                           class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-600 focus:ring-teal-600">
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input id="password" name="password" type="password"
                           required autocomplete="current-password"
                           class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-600 focus:ring-teal-600">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-teal-700 focus:ring-teal-600">
                    Ingat saya
                </label>

                <button type="submit"
                        class="w-full rounded-lg bg-teal-700 px-4 py-2.5 font-semibold text-white transition hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2">
                    Masuk
                </button>
            </form>
        </div>
    </section>

</main>
</body>
</html>