<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.uav.index', $project->id) }}" class="text-blue-600 hover:underline">
                Laporan Tim UAV
            </a>
            <span class="text-gray-400 mx-2">/</span>
            Rekap Performa Pilot 🧑‍✈️
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-indigo-500">
                <h3 class="text-xl font-extrabold text-gray-900">Statistik Performa Pilot UAV</h3>
                <p class="text-sm text-gray-500 mt-1">Data berikut menampilkan rekapitulasi <strong>seluruh log penerbangan</strong> (semua status) yang dikerjakan oleh masing-masing pilot pada proyek <span class="font-bold text-indigo-600">{{ $project->name }}</span>.</p>
            </div>

            <<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                @forelse($pilotStats as $index => $stat)
                    <div x-data="{ open: false }" class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 hover:shadow-md transition flex flex-col min-w-0">
                        
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <h4 class="font-bold text-lg text-gray-800">{{ $stat['name'] }}</h4>
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-indigo-50 p-3 rounded-lg border border-indigo-100 text-center">
                                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Total Akuisisi</p>
                                    <p class="text-2xl font-extrabold text-indigo-900">{{ number_format($stat['total_area'], 1) }} <span class="text-sm font-normal">Ha</span></p>
                                </div>
                                <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 text-center">
                                    <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Total Flight</p>
                                    <p class="text-2xl font-extrabold text-blue-900">{{ $stat['flight_count'] }} <span class="text-sm font-bold">Flight</span></p>
                                </div>
                            </div>

                            <div class="space-y-3 border-t border-gray-100 pt-4 mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-500">Jumlah Hari Kerja (Terbang):</span>
                                    <span class="text-sm font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $stat['days_flown'] }} Hari</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-500">Rata-rata Kemampuan / Hari:</span>
                                    <span class="text-sm font-bold text-green-700 bg-green-50 border border-green-200 px-2 py-1 rounded">{{ number_format($stat['average_per_day'], 2) }} Ha/Hari</span>
                                </div>
                            </div>

                            <div class="mt-auto border-t border-gray-100 pt-4">
                                <button type="button" @click="open = !open" class="flex items-center justify-center w-full text-sm font-bold text-indigo-600 hover:text-indigo-800 transition bg-indigo-50 hover:bg-indigo-100 py-2 rounded-lg border border-indigo-100">
                                    <span x-show="!open">Tampilkan Detail Log Penerbangan</span>
                                    <span x-show="open" style="display: none;">Sembunyikan Detail Log</span>
                                </button>

                                <div x-show="open" style="display: none;" x-transition class="mt-4 overflow-x-auto border border-gray-200 rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pilot / Asisten</th>
                                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">UAV / Unit</th>
                                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Hasil (Ha)</th>
                                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status & Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($stat['logs'] as $log)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="font-bold text-gray-700">{{ $log->pilot->name ?? '-' }}</div>
                                                    <div class="text-xs mt-0.5">Ast: {{ $log->assistant->name ?? '-' }}</div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $log->uav->name ?? '-' }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm">
                                                    <div class="font-bold text-gray-900">{{ $log->area_acquired }} Ha</div>
                                                    <div class="text-xs text-gray-500 mt-0.5">{{ $log->flight_count }} Flight</div>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        {{ $log->status == 'Finished Flight' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $log->status }}
                                                    </span>
                                                    @if($log->notes)
                                                        <div class="text-xs text-gray-500 mt-1 italic">"{{ $log->notes }}"</div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-8 rounded-xl shadow-sm text-center border border-gray-200">
                        <p class="text-gray-500 italic">Belum ada data log penerbangan yang tercatat di proyek ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="flex justify-start">
                <a href="{{ route('projects.uav.index', $project->id) }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition shadow-sm">
                    &larr; Kembali ke Laporan UAV
                </a>
            </div>

        </div>
    </div>
</x-app-layout>