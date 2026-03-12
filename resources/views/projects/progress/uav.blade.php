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
                            <div class="mt-4">
                                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-bold shadow-sm transition">
                                    Simpan Tanggal
                                </button>
                            </div>
                        </div>

                        <div class="bg-blue-50 p-5 rounded-lg border border-blue-200 flex items-center justify-between h-full shadow-sm">
                            <div class="flex-1 pr-4">
                                <h3 class="text-lg font-bold mb-3 text-blue-800 border-b border-blue-200 pb-2">Target & Realisasi</h3>
                                <div class="mb-2">
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Luas AOI Proyek</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $project->area_size }} <span class="text-sm text-gray-600 font-normal">Hektar</span></p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Telah Diakuisisi</p>
                                    <p class="text-lg font-bold {{ $persentase >= 100 ? 'text-green-600' : 'text-blue-700' }}">{{ $luasTercapai }} <span class="text-sm font-normal">Hektar</span></p>
                                </div>
                            </div>

                            <div class="relative w-28 h-28 shrink-0">
                                <svg class="w-full h-full transform -rotate-90 drop-shadow-sm" viewBox="0 0 36 36">
                                    <path class="text-blue-200" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <path class="{{ $persentase >= 100 ? 'text-green-500' : 'text-blue-600' }}" stroke-width="3.5" stroke-dasharray="{{ min($persentase, 100) }}, 100" stroke="currentColor" fill="none" stroke-linecap="round" style="transition: stroke-dasharray 1s ease-in-out;" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-xl font-extrabold {{ $persentase >= 100 ? 'text-green-600' : 'text-blue-900' }}">
                                        {{ number_format($persentase, 1) }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 border-t border-gray-200 pt-4 flex justify-end">
                        <a href="{{ route('projects.uav.pilots', $project->id) }}" class="bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-bold py-2 px-6 rounded-lg transition border border-indigo-300 shadow-sm flex items-center gap-2">
                            <span> Detail Performa Pilot</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
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
                                <input type="number" step="any" name="area_acquired" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
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
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status & Catatan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($report->logs as $log)
                            <tr x-data="{ openEditModal: false }">
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
                                
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $log->status == 'Finished Flight' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $log->status }}
                                    </span>
                                    @if($log->notes)
                                        <div class="text-xs text-gray-500 mt-1 italic">"{{ $log->notes }}"</div>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <button @click="openEditModal = true" class="text-indigo-600 hover:text-white hover:bg-indigo-600 font-bold border border-indigo-600 px-3 py-1 rounded transition">Edit</button>
                                        
                                        <form action="{{ route('uav-logs.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Hapus log ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 font-bold border border-red-500 px-3 py-1 rounded transition ml-1">Hapus</button>
                                        </form>
                                    </div>

                                    <div x-show="openEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div x-show="openEditModal" @click="openEditModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                            <div x-show="openEditModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                                
                                                <form action="{{ route('uav-logs.update', $log->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4 border-b pb-2">Edit Log Penerbangan</h3>
                                                        
                                                        <div class="grid grid-cols-2 gap-4 mb-4 text-left">
                                                            <div>
                                                                <label class="block text-xs font-medium text-gray-500">Tanggal</label>
                                                                <input type="date" name="date" value="{{ $log->date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs font-medium text-gray-500">Unit UAV</label>
                                                                <select name="uav_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                                                    @foreach($uavs as $uav)
                                                                        <option value="{{ $uav->id }}" {{ $log->uav_id == $uav->id ? 'selected' : '' }}>{{ $uav->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs font-medium text-gray-500">Pilot</label>
                                                                <select name="pilot_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                                                    @foreach($employees as $emp)
                                                                        <option value="{{ $emp->id }}" {{ $log->pilot_id == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs font-medium text-gray-500">Asisten</label>
                                                                <select name="assistant_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                                                    <option value="">(Opsional)</option>
                                                                    @foreach($employees as $emp)
                                                                        <option value="{{ $emp->id }}" {{ $log->assistant_id == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs font-medium text-gray-500">Jml Flight</label>
                                                                <input type="number" name="flight_count" value="{{ $log->flight_count }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs font-medium text-gray-500">Luas Dapat (Ha)</label>
                                                                <input type="number" step="any" name="area_acquired" value="{{ $log->area_acquired }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs font-medium text-gray-500">Status</label>
                                                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                                                    <option value="Finished Flight" {{ $log->status == 'Finished Flight' ? 'selected' : '' }}>Finished Flight</option>
                                                                    <option value="Reflight" {{ $log->status == 'Reflight' ? 'selected' : '' }}>Reflight</option>
                                                                    <option value="RTH" {{ $log->status == 'RTH' ? 'selected' : '' }}>RTH</option>
                                                                    <option value="Hujan" {{ $log->status == 'Hujan' ? 'selected' : '' }}>Hujan / Cuaca</option>
                                                                    <option value="Maintenance UAV" {{ $log->status == 'Maintenance UAV' ? 'selected' : '' }}>Maintenance UAV</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-span-2">
                                                                <label class="block text-xs font-medium text-gray-500">Catatan</label>
                                                                <input type="text" name="notes" value="{{ $log->notes }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200">
                                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-bold text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">
                                                            Simpan Perubahan
                                                        </button>
                                                        <button type="button" @click="openEditModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-gray-700 hover:bg-gray-100 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                                                            Batal
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
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