<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('projects.progress.index', $project->id) }}" class="text-[#F8931F] hover:underline transition">
                    Log Progress
                </a>
                <span class="text-gray-400 mx-2">/</span>
                Laporan Tim UAV 
            </h2>
        </div>
    </x-slot>

    <div class="pt-6 pb-12 max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-200">
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-2">
                <h3 class="text-lg font-black text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Informasi Pelaksanaan & Progress Akuisisi
                </h3>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                
                <div class="flex flex-col h-full space-y-4">
                    <form action="{{ route('uav-reports.update', $report->id) }}" method="POST" class="bg-[#F4F7F6] p-6 rounded-xl border border-[#144C4D]/20 shadow-inner flex-1 flex flex-col">
                        @csrf @method('PUT')
                        <h4 class="text-xs font-bold text-[#144C4D] uppercase tracking-widest mb-4 border-b border-[#144C4D]/20 pb-2">Waktu Pelaksanaan</h4>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Tgl Mulai</label>
                                <input type="date" name="start_date" value="{{ $report->start_date }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#144C4D] focus:border-[#144C4D] sm:text-sm font-medium">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Tgl Selesai</label>
                                <input type="date" name="end_date" value="{{ $report->end_date }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#144C4D] focus:border-[#144C4D] sm:text-sm font-medium">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-[#144C4D] text-white px-4 py-2.5 rounded-lg hover:bg-[#0c2e2e] text-sm font-bold shadow-md transition mt-auto flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Tanggal
                        </button>
                    </form>

                    <a href="{{ route('projects.uav.pilots', $project->id) }}" class="bg-[#E8F1F1] hover:bg-[#144C4D] text-[#144C4D] hover:text-white font-bold py-3 px-6 rounded-xl transition border border-[#144C4D]/30 shadow-sm flex items-center justify-center gap-2 group">
                        <span>Lihat Detail Performa Pilot</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 h-full flex flex-col justify-center items-center shadow-sm">
                    <h3 class="w-full text-center text-sm font-black text-gray-800 mb-6 uppercase tracking-widest border-b border-gray-200 pb-2">Target & Realisasi Area</h3>
                    
                    <div class="flex items-center gap-8 w-full justify-center">
                        <div class="space-y-4 text-right">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Target Area Proyek</p>
                                <p class="text-2xl font-black text-gray-800">{{ number_format($project->area_size, 0) }} <span class="text-sm font-bold text-gray-500">Ha</span></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Telah Diakuisisi</p>
                                <p class="text-2xl font-black {{ $persentase >= 100 ? 'text-green-600' : 'text-[#F8931F]' }}">{{ number_format($luasTercapai, 1) }} <span class="text-sm font-bold {{ $persentase >= 100 ? 'text-green-600' : 'text-[#F8931F]' }}">Ha</span></p>
                            </div>
                        </div>

                        <div class="relative w-32 h-32 shrink-0">
                            <svg class="w-full h-full transform -rotate-90 drop-shadow-sm" viewBox="0 0 36 36">
                                <path class="text-gray-200" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="{{ $persentase >= 100 ? 'text-green-500' : 'text-[#144C4D]' }}" stroke-width="3.5" stroke-dasharray="{{ min($persentase, 100) }}, 100" stroke="currentColor" fill="none" stroke-linecap="round" style="transition: stroke-dasharray 1s ease-in-out;" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center flex-col">
                                <span class="text-2xl font-black {{ $persentase >= 100 ? 'text-green-600' : 'text-[#144C4D]' }}">
                                    {{ number_format($persentase, 1) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            
            <div class="bg-gray-50 p-5 border-b border-gray-200">
                <h3 class="font-black text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#F8931F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Log Penerbangan Baru
                </h3>
                <form action="{{ route('uav-logs.store', $report->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Tanggal</label>
                            <input type="date" name="date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                        </div>
                        <div>
                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Pilot Utama</label>
                            <select name="pilot_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                                <option value="">Pilih Pilot...</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Asisten Pilot</label>
                            <select name="assistant_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                                <option value="">(Opsional)</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Unit UAV / Drone</label>
                            <select name="uav_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                                <option value="">Pilih Drone...</option>
                                @foreach($uavs as $uav)
                                    <option value="{{ $uav->id }}">{{ $uav->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Jml Flight</label>
                            <input type="number" name="flight_count" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" placeholder="0" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Luas Dapat (Ha)</label>
                            <input type="number" step="any" name="area_acquired" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" placeholder="0.0" required>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Status Flight</label>
                            <select name="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                                <option value="Finished Flight">Finished Flight</option>
                                <option value="Reflight">Reflight</option>
                                <option value="RTH">RTH (Return To Home)</option>
                                <option value="Hujan">Hujan / Cuaca Buruk</option>
                                <option value="Maintenance UAV">Maintenance UAV</option>
                            </select>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Catatan</label>
                            <input type="text" name="notes" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" placeholder="Ket. opsional...">
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2.5 rounded-lg hover:bg-gray-900 text-sm font-bold shadow-sm transition flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Simpan Log
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Tanggal</th>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Personil & Unit</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Hasil Akuisisi</th>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Status & Catatan</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($report->logs as $log)
                        <tr x-data="{ openEditModal: false }" class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-black text-[#144C4D] text-sm">{{ $log->pilot->name ?? '-' }} <span class="text-[10px] font-bold text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded ml-1">(Pilot)</span></div>
                                <div class="text-xs text-gray-500 font-medium mt-1">{{ $log->assistant->name ?? '-' }} <span class="text-[10px] text-gray-400">(Asisten)</span></div>
                                <div class="mt-2 inline-flex items-center gap-1.5 px-2 py-1 rounded bg-[#E8F1F1] text-[#144C4D] text-[10px] font-bold uppercase tracking-widest">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg> {{ $log->uav->name ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="font-black text-gray-800 text-lg">{{ number_format($log->area_acquired, 1) }} <span class="text-xs font-bold text-gray-500">Ha</span></div>
                                <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1">{{ $log->flight_count }} Flight</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase tracking-widest rounded-md border
                                    {{ $log->status == 'Finished Flight' ? 'bg-green-50 text-green-700 border-green-200' : 
                                      ($log->status == 'Reflight' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : 
                                      'bg-red-50 text-red-700 border-red-200') }}">
                                    {{ $log->status }}
                                </span>
                                @if($log->notes)
                                    <div class="text-xs text-gray-500 mt-2 italic flex items-start gap-1">
                                        <svg class="w-3 h-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                        {{ $log->notes }}
                                    </div>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center items-center space-x-2">
                                    <button @click="openEditModal = true" class="text-[#F8931F] hover:text-white hover:bg-[#F8931F] border border-[#F8931F] p-1.5 rounded-md transition" title="Edit Log">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    
                                    <form action="{{ route('uav-logs.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Hapus log penerbangan ini? Progress area akan otomatis berkurang.');" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 border border-red-500 p-1.5 rounded-md transition" title="Hapus Log">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>

                                <div x-show="openEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto text-left" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div x-show="openEditModal" @click="openEditModal = false" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div x-show="openEditModal" class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100">
                                            
                                            <form action="{{ route('uav-logs.update', $log->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="bg-white px-6 pt-6 pb-4">
                                                    <h3 class="text-lg font-black text-gray-900 mb-4 border-b border-gray-100 pb-2">Edit Log Penerbangan</h3>
                                                    
                                                    <div class="grid grid-cols-2 gap-4 mb-4 text-left">
                                                        <div>
                                                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Tanggal</label>
                                                            <input type="date" name="date" value="{{ $log->date }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                                                        </div>
                                                        <div>
                                                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Unit UAV</label>
                                                            <select name="uav_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                                                                @foreach($uavs as $uav)
                                                                    <option value="{{ $uav->id }}" {{ $log->uav_id == $uav->id ? 'selected' : '' }}>{{ $uav->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Pilot Utama</label>
                                                            <select name="pilot_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                                                                @foreach($employees as $emp)
                                                                    <option value="{{ $emp->id }}" {{ $log->pilot_id == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Asisten Pilot</label>
                                                            <select name="assistant_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                                                                <option value="">(Opsional)</option>
                                                                @foreach($employees as $emp)
                                                                    <option value="{{ $emp->id }}" {{ $log->assistant_id == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Jml Flight</label>
                                                            <input type="number" name="flight_count" value="{{ $log->flight_count }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                                                        </div>
                                                        <div>
                                                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Luas Dapat (Ha)</label>
                                                            <input type="number" step="any" name="area_acquired" value="{{ $log->area_acquired }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                                                        </div>
                                                        <div>
                                                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Status Flight</label>
                                                            <select name="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                                                                <option value="Finished Flight" {{ $log->status == 'Finished Flight' ? 'selected' : '' }}>Finished Flight</option>
                                                                <option value="Reflight" {{ $log->status == 'Reflight' ? 'selected' : '' }}>Reflight</option>
                                                                <option value="RTH" {{ $log->status == 'RTH' ? 'selected' : '' }}>RTH</option>
                                                                <option value="Hujan" {{ $log->status == 'Hujan' ? 'selected' : '' }}>Hujan / Cuaca Buruk</option>
                                                                <option value="Maintenance UAV" {{ $log->status == 'Maintenance UAV' ? 'selected' : '' }}>Maintenance UAV</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-span-2">
                                                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Catatan</label>
                                                            <input type="text" name="notes" value="{{ $log->notes }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end border-t border-gray-100">
                                                    <button type="button" @click="openEditModal = false" class="px-5 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="px-5 py-2 bg-[#144C4D] rounded-lg text-sm font-bold text-white hover:bg-[#0c2e2e] transition shadow-sm">
                                                        Simpan Perubahan
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
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Belum ada log penerbangan. Silakan tambah log baru melalui form di atas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>