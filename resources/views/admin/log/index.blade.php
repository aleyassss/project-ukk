<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Log Aktivitas</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow sm:rounded-lg">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b"><th class="py-2">Waktu</th><th>User</th><th>Aktivitas</th></tr>
                </thead>
                <tbody>
                    @foreach ($logs as $l)
                        <tr class="border-b">
                            <td class="py-2">{{ $l->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $l->user->username ?? '-' }}</td>
                            <td>{{ $l->aktivitas }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $logs->links() }}</div>
        </div>
    </div>
</x-app-layout>