<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('projects.lidar.index', $project->id) }}" class="text-[#F8931F] hover:underline transition">
                    Laporan LiDAR
                </a>
                <span class="text-gray-400 mx-2">/</span>
                Detail Hamparan: {{ $hamparan->name }}
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

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-t-4 border-[#144C4D] flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex-1">
                <h3 class="text-2xl font-black text-gray-900 mb-2">{{ $hamparan->name }}</h3>
                
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 font-medium mb-4">
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg> Luas Area: <span class="text-[#144C4D] font-black">{{ $hamparan->size }} Ha</span></span>
                    <span class="text-gray-300 hidden md:inline">|</span>
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Waktu Pengolahan: <span class="text-white font-bold bg-[#144C4D] px-2 py-0.5 rounded shadow-sm">{{ $totalHariPengolahan }} Hari</span></span>
                </div>

                <div class="flex flex-wrap gap-2">
                    <span class="bg-[#E8F1F1] text-[#144C4D] text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg border border-[#144C4D]/20 shadow-sm flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Tahapan: {{ $tahapanSelesai }} / {{ $totalTahapan }} Selesai
                    </span>
                    <span class="bg-green-50 text-green-700 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg border border-green-200 shadow-sm flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        Output: {{ $outputSelesai }} / {{ $totalOutput }} Tersedia
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-6 bg-gray-50 p-5 rounded-2xl border border-gray-100 shadow-sm shrink-0">
                <div class="text-right">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Progress Gabungan</p>
                    <p class="text-sm font-black text-gray-800">Penyelesaian Area</p>
                </div>
                <div class="relative w-24 h-24">
                    <svg class="w-full h-full transform -rotate-90 drop-shadow-sm" viewBox="0 0 36 36">
                        <path class="text-gray-200" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="{{ $persentase == 100 ? 'text-green-500' : 'text-[#F8931F]' }}" stroke-width="3" stroke-dasharray="{{ $persentase }}, 100" stroke="currentColor" fill="none" stroke-linecap="round" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" style="transition: stroke-dasharray 1.5s ease-in-out;" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-xl font-black {{ $persentase == 100 ? 'text-green-600' : 'text-[#144C4D]' }}">{{ number_format($persentase, 0) }}<span class="text-sm">%</span></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-100 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
                <h3 class="text-base font-black text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Log Tahapan Pengolahan
                </h3>
            </div>

            <div class="p-6 border-b border-gray-100">
                <form action="{{ route('lidar-progress.store', $hamparan->id) }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end bg-[#F4F7F6] p-5 rounded-xl border border-[#144C4D]/10 shadow-sm">
                    @csrf
                    <div class="flex-1 w-full">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Target Tahapan Pengolahan</label>
                        <input type="text" name="stage_name" list="stages" placeholder="Ketik atau pilih tahapan..." class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                        <datalist id="stages">
                            <option value="Klasifikasi Ground">
                            <option value="Generate DTM">
                            <option value="Generate Kontur">
                            <option value="Checking Quality">
                        </datalist>
                        <input type="hidden" name="status" value="Proses">
                    </div>
                    <div class="w-full md:w-auto">
                        <button type="submit" class="w-full bg-[#144C4D] text-white px-6 py-2.5 rounded-lg hover:bg-[#0c2e2e] text-sm font-bold shadow-sm transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Daftarkan Tahapan
                        </button>
                    </div>
                </form>
            </div>

            <div x-data="{ openUpdateModal: false, selectedProgress: null }" class="overflow-x-auto relative">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0 shadow-sm">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Tahapan</th>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Waktu Pengerjaan</th>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Oleh / PC</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Status</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($hamparan->progresses as $prog)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-gray-900">{{ $prog->stage_name }}</div>
                                @if($prog->notes)
                                    <div class="text-xs font-medium text-gray-500 mt-1 italic">"{{ $prog->notes }}"</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600">
                                <div class="flex items-center gap-1.5 mb-1"><span class="font-bold text-gray-400 uppercase tracking-widest w-10 text-[10px]">Mulai</span> <span class="font-bold">{{ $prog->start_date ? \Carbon\Carbon::parse($prog->start_date)->format('d M Y') : '-' }}</span></div>
                                <div class="flex items-center gap-1.5"><span class="font-bold text-gray-400 uppercase tracking-widest w-10 text-[10px]">Selesai</span> <span class="font-bold">{{ $prog->end_date ? \Carbon\Carbon::parse($prog->end_date)->format('d M Y') : '-' }}</span></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600">
                                <div class="flex items-center gap-1.5 mb-1 font-bold text-[#144C4D]"><svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> {{ $prog->processor_name ?? '-' }}</div>
                                <div class="flex items-center gap-1.5 text-gray-500 font-medium"><svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> {{ $prog->pc_name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-[10px] uppercase tracking-widest font-black rounded-lg border
                                    {{ $prog->status == 'Selesai' ? 'bg-green-50 text-green-700 border-green-200' :
                                      ($prog->status == 'Gagal' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-orange-50 text-[#F8931F] border-[#F8931F]/30') }}">
                                    {{ $prog->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <button type="button" @click="selectedProgress = {{ json_encode($prog) }}; openUpdateModal = true" class="text-[#144C4D] hover:text-white hover:bg-[#144C4D] font-bold border border-[#144C4D] p-1.5 rounded-lg transition shadow-sm" title="Update">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <form action="{{ route('lidar-progress.destroy', $prog->id) }}" method="POST" onsubmit="return confirm('Hapus log tahapan ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 font-bold border border-red-500 p-1.5 rounded-lg transition shadow-sm" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400 italic"><svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Belum ada target tahapan yang didaftarkan.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div x-show="openUpdateModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="openUpdateModal" @click="openUpdateModal = false" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                        <div x-show="openUpdateModal" x-transition class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100">
                            <form :action="'/lidar-progress/' + selectedProgress?.id" method="POST">
                                @csrf @method('PUT')
                                <div class="bg-white px-6 pt-6 pb-4">
                                    <h3 class="text-lg font-black text-gray-900 mb-4 border-b border-gray-100 pb-2">Update Tahapan: <span class="text-[#144C4D]" x-text="selectedProgress?.stage_name"></span></h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Nama Tahapan</label>
                                            <input type="text" name="stage_name" :value="selectedProgress?.stage_name" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Tgl Mulai</label>
                                            <input type="date" name="start_date" :value="selectedProgress?.start_date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Tgl Selesai</label>
                                            <input type="date" name="end_date" :value="selectedProgress?.end_date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Nama Pengolah</label>
                                            <select name="processor_name" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" :value="selectedProgress?.processor_name">
                                                <option value="">-- Pilih Pengolah Data --</option>
                                                @foreach($pengolahData as $pengolah)
                                                    <option value="{{ $pengolah->name }}">{{ $pengolah->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">PC Pengolahan</label>
                                            <select name="pc_name" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" :value="selectedProgress?.pc_name">
                                                <option value="">-- Pilih PC --</option>
                                                @foreach($pcs as $pc)
                                                    <option value="{{ $pc->name }}">{{ $pc->name }} ({{ $pc->spec }})</option>
                                                @endforeach
                                                <option value="Laptop Pribadi">Laptop Pribadi</option>
                                            </select>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Catatan Tambahan</label>
                                            <input type="text" name="notes" :value="selectedProgress?.notes" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" placeholder="Ket. opsional...">
                                        </div>
                                        <div class="md:col-span-2 mt-2 p-4 bg-gray-50 border border-gray-200 rounded-xl flex justify-between items-center">
                                            <label class="block text-sm font-black text-gray-800">Status Pekerjaan</label>
                                            <select name="status" class="rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-black" :value="selectedProgress?.status">
                                                <option value="Proses">Sedang Proses ⏳</option>
                                                <option value="Selesai">Selesai ✅</option>
                                                <option value="Gagal">Gagal / Error ❌</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end border-t border-gray-100">
                                    <button type="button" @click="openUpdateModal = false" class="px-5 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm">Batal</button>
                                    <button type="submit" class="px-5 py-2 bg-[#144C4D] rounded-lg text-sm font-bold text-white hover:bg-[#0c2e2e] transition shadow-sm">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 mb-12">
            <div class="p-6 border-b border-gray-100 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
                <h3 class="text-base font-black text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#F8931F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    Output Produk (Deliverables) Area Ini
                </h3>
            </div>

            <div class="p-6 border-b border-gray-100">
                <form action="{{ route('lidar-outputs.store', $hamparan->id) }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end bg-[#F4F7F6] p-5 rounded-xl border border-[#144C4D]/10 shadow-sm">
                    @csrf
                    <div class="flex-1 w-full">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Target Jenis Output / Nama File</label>
                        <input type="text" name="filename" list="lidar_jenis_output" placeholder="Ketik atau pilih dari daftar..." class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F8931F] focus:ring-[#F8931F] sm:text-sm font-medium" required>
                        <datalist id="lidar_jenis_output">
                            <option value="DSM">
                            <option value="DTM">
                            <option value="Point Cloud">
                            <option value="Kontur">
                            <option value="Peta Kontur">
                            <option value="Laporan">
                            <option value="ECW">
                        </datalist>
                        <input type="hidden" name="format" value="-">
                        <input type="hidden" name="checklist" value="0">
                    </div>
                    <div class="w-full md:w-auto">
                        <button type="submit" class="w-full bg-[#F8931F] text-white px-6 py-2.5 rounded-lg hover:bg-[#e08219] text-sm font-bold shadow-sm transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Daftarkan Output
                        </button>
                    </div>
                </form>
            </div>

            <div x-data="{ openOutputModal: false, selectedOutput: null }" class="overflow-x-auto relative">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0 shadow-sm">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">File & Format</th>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Lokasi & Ukuran</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Ketersediaan</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($hamparan->outputs as $out)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-black text-gray-900 text-sm">{{ $out->filename }}</div>
                                <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1.5 flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> {{ $out->format }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-800 truncate max-w-[200px] md:max-w-xs" title="{{ $out->location }}">{{ $out->location ?? '-' }}</div>
                                <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1.5">{{ $out->size_gb ? $out->size_gb . ' GB' : '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($out->checklist)
                                    <span class="bg-green-50 text-green-700 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-green-200">✅ Tersedia</span>
                                @else
                                    <span class="bg-gray-100 text-gray-500 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-gray-200">❌ Belum</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <button type="button" @click="selectedOutput = {{ json_encode($out) }}; openOutputModal = true" class="text-[#F8931F] hover:text-white hover:bg-[#F8931F] font-bold border border-[#F8931F] p-1.5 rounded-lg transition shadow-sm" title="Update">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <form action="{{ route('lidar-outputs.destroy', $out->id) }}" method="POST" onsubmit="return confirm('Hapus target output ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 font-bold border border-red-500 p-1.5 rounded-lg transition shadow-sm" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400 italic"><svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>Belum ada target output yang didaftarkan.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div x-show="openOutputModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="openOutputModal" @click="openOutputModal = false" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                        <div x-show="openOutputModal" x-transition class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100">
                            <form :action="'/lidar-outputs/' + selectedOutput?.id" method="POST">
                                @csrf @method('PUT')
                                <div class="bg-white px-6 pt-6 pb-4">
                                    <h3 class="text-lg font-black text-gray-900 mb-4 border-b border-gray-100 pb-2">Update File: <span class="text-[#F8931F]" x-text="selectedOutput?.filename"></span></h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Nama Output</label>
                                            <input type="text" name="filename" :value="selectedOutput?.filename" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F8931F] focus:ring-[#F8931F] sm:text-sm font-medium" required>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Format File</label>
                                            <input type="text" name="format" list="lidar_format_file_modal" :value="selectedOutput?.format == '-' ? '' : selectedOutput?.format" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F8931F] focus:ring-[#F8931F] sm:text-sm font-medium" required>
                                            <datalist id="lidar_format_file_modal">
                                                <option value="LAS"><option value="LAZ"><option value="TIF"><option value="DWG"><option value="PDF"><option value="SHP">
                                            </datalist>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Ukuran File (GB)</label>
                                            <input type="number" step="0.01" name="size_gb" :value="selectedOutput?.size_gb" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F8931F] focus:ring-[#F8931F] sm:text-sm font-medium">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Lokasi Penyimpanan (Path / Tautan)</label>
                                            <input type="text" name="location" :value="selectedOutput?.location" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F8931F] focus:ring-[#F8931F] sm:text-sm font-medium">
                                        </div>
                                        <div class="md:col-span-2 mt-2 p-4 bg-gray-50 border border-gray-200 rounded-xl flex justify-between items-center">
                                            <label class="block text-sm font-black text-gray-800">Apakah file sudah final / tersedia?</label>
                                            <select name="checklist" class="rounded-lg border-gray-300 shadow-sm focus:border-[#F8931F] focus:ring-[#F8931F] sm:text-sm font-black" :value="selectedOutput?.checklist">
                                                <option value="0">❌ Belum Ada</option>
                                                <option value="1">✅ Sudah Tersedia</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end border-t border-gray-100">
                                    <button type="button" @click="openOutputModal = false" class="px-5 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm">Batal</button>
                                    <button type="submit" class="px-5 py-2 bg-[#F8931F] rounded-lg text-sm font-bold text-white hover:bg-[#e08219] transition shadow-sm">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>