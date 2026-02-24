<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.progress.index', $project->id) }}" class="text-blue-600 hover:underline">
                Log Progress
            </a>
            <span class="text-gray-400 mx-2">/</span>
            Laporan Tim UAV 🚁
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('uav-reports.update', $report->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <h3 class="text-lg font-bold mb-4">Waktu Pelaksanaan</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tgl Mulai</label>
                                    <input type="date" name="start_date" value="{{ $report->start_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tgl Selesai</label>
                                    <input type="date" name="end_date" value="{{ $report->end_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h3 class="text-lg font-bold mb-2 text-blue-800">Target & Realisasi</h3>
                            <div class="mb-3">
                                <label class="block text-xs font-bold text-gray-500 uppercase">Luas AOI (Ha)</label>
                                <div class="flex gap-2">
                                    <input type="number" step="0.01" name="aoi_size" value="{{ $report->aoi_size }}" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                    <button type="submit" class="bg-blue-600 text-white px-3 rounded text-xs">Simpan</button>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Progress Akuisisi</span>
                                    <span class="font-bold">{{ number_format($percentage, 2) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ min($percentage, 100)}}%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Terakuisisi: {{ $totalAcquired }} Ha dari {{ $report->aoi_size }} Ha
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-8 bg-gray-50 p-4 rounded border">
                    <h3 class="font-bold text-sm mb-4 border-b pb-2">Tambah Log Penerbangan</h3>
                    <form action="{{ route('uav-logs.store', $report->id) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Tanggal</label>
                                <input type="date" name="date" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Pilot</label>
                                <select name="pilot_id" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                    <option value="">Pilih Pilot...</option>
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Asisten</label>
                                <select name="assistant_id" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                    <option value="">(Opsional)</option>
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Unit UAV</label>
                                <select name="uav_id" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                    <option value="">Pilih Drone...</option>
                                    @foreach($uavs as $uav)
                                        <option value="{{ $uav->id }}">{{ $uav->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Jml Flight</label>
                                <input type="number" name="flight_count" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Luas Dapat (Ha)</label>
                                <input type="number" step="0.01" name="area_acquired" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Status</label>
                                <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                    <option value="Finished Flight">Finished Flight</option>
                                    <option value="Reflight">Reflight</option>
                                    <option value="RTH">RTH (Return To Home)</option>
                                    <option value="Hujan">Hujan / Cuaca</option>
                                    <option value="Maintenance UAV">Maintenance UAV</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Catatan</label>
                                <input type="text" name="notes" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Catatan singkat...">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm font-bold">
                                + Simpan Log
                            </button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pilot / Asisten</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">UAV / Unit</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Hasil (Ha)</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($report->logs as $log)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="font-bold text-gray-700">{{ $log->pilot->name ?? '-' }}</div>
                                    <div class="text-xs">Ast: {{ $log->assistant->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $log->uav->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="font-bold text-gray-900">{{ $log->area_acquired }} Ha</div>
                                    <div class="text-xs text-gray-500">{{ $log->flight_count }} Flight</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $log->status == 'Finished Flight' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $log->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('uav-logs.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Hapus log ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 italic">
                                    Belum ada log penerbangan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
