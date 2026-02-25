<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} 📊
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500 flex items-center p-6">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 text-3xl mr-4">📁</div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Proyek</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalProyek }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500 flex items-center p-6">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 text-3xl mr-4">⏳</div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Sedang Berjalan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $proyekBerjalan }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-gray-800 flex items-center p-6">
                    <div class="p-3 rounded-full bg-gray-200 text-gray-800 text-3xl mr-4">✅</div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Selesai</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $proyekSelesai }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">5 Proyek Terbaru</h3>
                    <a href="{{ route('projects.index') }}" class="text-sm text-blue-600 hover:underline font-semibold">Lihat Semua Proyek &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="p-4 font-semibold">Kode</th>
                                <th class="p-4 font-semibold">Nama Proyek</th>
                                <th class="p-4 font-semibold">Klien</th>
                                <th class="p-4 font-semibold">Tenggat Waktu</th>
                                <th class="p-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($proyekTerbaru as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-gray-900">{{ $p->code }}</td>
                                <td class="p-4 text-gray-700">{{ $p->name }}</td>
                                <td class="p-4 text-gray-700">{{ $p->client_name }}</td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-xs font-bold
                                        {{ \Carbon\Carbon::parse($p->end_date)->isPast() ? 'bg-gray-200 text-gray-800' : 'bg-green-100 text-green-800' }}">
                                        {{ \Carbon\Carbon::parse($p->end_date)->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <a href="{{ route('projects.show', $p->id) }}" class="text-blue-600 hover:underline font-bold text-xs">Buka Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-500 italic">Belum ada proyek yang ditambahkan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
