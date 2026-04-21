<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('projects.show', $project->id) }}" class="text-[#144C4D] hover:underline">Detail Proyek</a>
                <span class="text-gray-400 mx-2">/</span> Log Maintenance UAV
            </h2>
        </div>
    </x-slot>

    <div class="py-12 mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        @if(session('success')) 
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div> 
        @endif

        <form action="{{ route('projects.uav-log.update', ['project' => $project->id, 'uav_id' => $uav->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-[#144C4D]">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-4 mb-6">
                    <svg class="w-6 h-6 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    <h3 class="font-black text-xl text-gray-800">Informasi Asset & Rekam Jejak UAV</h3>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 space-y-4">
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-bold mb-1">Nama UAV</span>
                            <span class="font-black text-gray-900 text-lg">{{ $uav->name }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-bold mb-1">Serial Number (SN)</span>
                            <span class="font-bold text-gray-700 bg-white px-2 py-1 border border-gray-200 rounded">{{ $uav->serial_number ?? 'Belum terdaftar' }}</span>
                        </div>
                        <div class="pt-3 border-t border-gray-200">
                            <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-bold mb-1">Penanggung Jawab (PIC)</span>
                            <span class="font-bold text-[#F8931F]">{{ $uav->pic ? $uav->pic->name : 'Belum diatur' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-bold mb-1">Pilot On Duty (Proyek Ini)</span>
                            <span class="font-bold text-[#144C4D]">{{ $log->pilot_name ?? 'Tidak ada pilot bertugas' }}</span>
                        </div>
                    </div>

                    <div class="bg-blue-50/50 p-5 rounded-lg border border-blue-100 space-y-4">
                        <h4 class="font-bold text-blue-800 text-sm border-b border-blue-200 pb-2 mb-4">METERAN SEBELUM PROYEK</h4>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">KM UAV (Jarak Tempuh)</label>
                            <div class="flex"><input type="number" name="km_before" value="{{ $log->km_before }}" class="w-full rounded-l-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"><span class="bg-gray-100 border border-l-0 border-gray-300 px-3 py-2 rounded-r-lg text-sm font-bold text-gray-500">KM</span></div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Total Waktu Terbang (Flight Hours)</label>
                            <div class="flex"><input type="number" name="flight_hours_before" value="{{ $log->flight_hours_before }}" class="w-full rounded-l-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"><span class="bg-gray-100 border border-l-0 border-gray-300 px-3 py-2 rounded-r-lg text-sm font-bold text-gray-500">Jam</span></div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Total Jumlah Terbang (Flight Count)</label>
                            <div class="flex"><input type="number" name="flight_count_before" value="{{ $log->flight_count_before }}" class="w-full rounded-l-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"><span class="bg-gray-100 border border-l-0 border-gray-300 px-3 py-2 rounded-r-lg text-sm font-bold text-gray-500">Kali</span></div>
                        </div>
                    </div>

                    <div class="bg-green-50/50 p-5 rounded-lg border border-green-100 space-y-4">
                        <h4 class="font-bold text-green-800 text-sm border-b border-green-200 pb-2 mb-4">METERAN SESUDAH PROYEK</h4>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">KM UAV (Jarak Tempuh)</label>
                            <div class="flex"><input type="number" name="km_after" value="{{ $log->km_after }}" class="w-full rounded-l-lg border-gray-300 focus:border-green-500 focus:ring-green-500 sm:text-sm"><span class="bg-gray-100 border border-l-0 border-gray-300 px-3 py-2 rounded-r-lg text-sm font-bold text-gray-500">KM</span></div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Total Waktu Terbang (Flight Hours)</label>
                            <div class="flex"><input type="number" name="flight_hours_after" value="{{ $log->flight_hours_after }}" class="w-full rounded-l-lg border-gray-300 focus:border-green-500 focus:ring-green-500 sm:text-sm"><span class="bg-gray-100 border border-l-0 border-gray-300 px-3 py-2 rounded-r-lg text-sm font-bold text-gray-500">Jam</span></div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Total Jumlah Terbang (Flight Count)</label>
                            <div class="flex"><input type="number" name="flight_count_after" value="{{ $log->flight_count_after }}" class="w-full rounded-l-lg border-gray-300 focus:border-green-500 focus:ring-green-500 sm:text-sm"><span class="bg-gray-100 border border-l-0 border-gray-300 px-3 py-2 rounded-r-lg text-sm font-bold text-gray-500">Kali</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" x-data="{ activeTab: '{{ session('active_tab', 'sebelum') }}' }">
    
            <input type="hidden" name="active_tab" :value="activeTab">
                
                <div class="flex border-b border-gray-200 bg-gray-50">
                    <button type="button" @click="activeTab = 'sebelum'" :class="{'border-b-4 border-[#144C4D] text-[#144C4D] bg-white': activeTab === 'sebelum', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'sebelum'}" class="flex-1 py-4 px-6 text-center font-black text-sm uppercase tracking-widest transition">
                        Tahap 1: Pengecekan Sebelum Proyek
                    </button>
                    <button type="button" @click="activeTab = 'sesudah'" :class="{'border-b-4 border-[#F8931F] text-[#F8931F] bg-white': activeTab === 'sesudah', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'sesudah'}" class="flex-1 py-4 px-6 text-center font-black text-sm uppercase tracking-widest transition">
                        Tahap 2: Pengecekan Sesudah Proyek
                    </button>
                </div>

                @php
                    // Helper function to safely format component name to input key
                    function getSafeKey($name) {
                        return str_replace([' ', '&', '(', ')'], '_', $name);
                    }
                @endphp

                <div x-show="activeTab === 'sebelum'" class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-[#144C4D]/5 text-[#144C4D] border-b border-gray-200">
                                <tr>
                                    <th class="p-4 font-bold uppercase tracking-wider text-xs w-48">Nama Komponen</th>
                                    <th class="p-4 font-bold uppercase tracking-wider text-xs">Kelengkapan</th>
                                    <th class="p-4 font-bold uppercase tracking-wider text-xs w-40">Kondisi</th>
                                    <th class="p-4 font-bold uppercase tracking-wider text-xs w-64">Dokumentasi (Max 2MB)</th>
                                    <th class="p-4 font-bold uppercase tracking-wider text-xs">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($components as $comp)
                                    @php 
                                        $safeKey = getSafeKey($comp); 
                                        $record = $checksBefore->get($comp);
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-4 font-bold text-gray-800">{{ $comp }}</td>
                                        <td class="p-4">
                                            @if($comp === 'Laptop GCS' || $comp === 'Laptop Processing')
                                                <select name="complete_sebelum_{{ $safeKey }}" class="w-full rounded-md border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                                                    <option value="">-- Pilih Laptop/PC --</option>
                                                    <option value="Milik Pribadi" {{ ($record->completeness ?? '') == 'Milik Pribadi' ? 'selected' : '' }}>Milik Pribadi</option>
                                                    @foreach($pcs as $pc)
                                                        <option value="{{ $pc->name }}" {{ ($record->completeness ?? '') == $pc->name ? 'selected' : '' }}>
                                                            {{ $pc->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" name="complete_sebelum_{{ $safeKey }}" value="{{ $record->completeness ?? '' }}" class="w-full rounded-md border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm" placeholder="Isian kelengkapan...">
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            <select name="condition_sebelum_{{ $safeKey }}" class="w-full rounded-md border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-bold"
                                                :class="{'text-green-600': $el.value == 'baik', 'text-red-600': $el.value == 'rusak', 'text-gray-500': $el.value == 'tidak_ada'}">
                                                <option value="baik" class="text-green-600" {{ ($record->condition ?? 'baik') == 'baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="rusak" class="text-red-600" {{ ($record->condition ?? '') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                                <option value="tidak_ada" class="text-gray-500" {{ ($record->condition ?? '') == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada</option>
                                            </select>
                                        </td>
                                        <td class="p-4" x-data="{ removed: false, hasFile: {{ ($record && $record->photo_path) ? 'true' : 'false' }} }">
    
                                            <div x-show="hasFile && !removed" class="mb-2 flex items-center gap-2">
                                                <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded font-bold uppercase">Ada File</span>
                                                <a href="{{ asset('storage/' . ($record->photo_path ?? '')) }}" target="_blank" class="text-[10px] text-blue-600 hover:underline font-bold">Lihat Foto</a>
                                                <span class="text-gray-300">|</span>
                                                <button type="button" @click="removed = true" class="text-[10px] text-red-500 hover:text-red-700 font-bold">Hapus</button>
                                            </div>

                                            <div x-show="!hasFile || removed">
                                                <input type="file" name="photo_sebelum_{{ $safeKey }}" class="w-full text-[11px] text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[11px] file:font-semibold file:bg-[#144C4D]/10 file:text-[#144C4D] hover:file:bg-[#144C4D]/20 transition cursor-pointer" accept="image/*">
                                                <p x-show="removed && hasFile" class="text-[10px] text-red-500 italic mt-1" style="display:none;">⚠️ File lama akan dihapus saat form disimpan.</p>
                                            </div>

                                            <input type="hidden" name="remove_photo_sebelum_{{ $safeKey }}" :value="removed ? '1' : '0'">
                                        </td>
                                        <td class="p-4">
                                            <input type="text" name="note_sebelum_{{ $safeKey }}" value="{{ $record->notes ?? '' }}" class="w-full rounded-md border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm" placeholder="Ket...">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="activeTab === 'sesudah'" style="display: none;" class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-[#F8931F]/10 text-[#F8931F] border-b border-gray-200">
                                <tr>
                                    <th class="p-4 font-bold uppercase tracking-wider text-xs w-48">Nama Komponen</th>
                                    <th class="p-4 font-bold uppercase tracking-wider text-xs">Kelengkapan</th>
                                    <th class="p-4 font-bold uppercase tracking-wider text-xs w-40">Kondisi Akhir</th>
                                    <th class="p-4 font-bold uppercase tracking-wider text-xs w-64">Dokumentasi (Max 2MB)</th>
                                    <th class="p-4 font-bold uppercase tracking-wider text-xs">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($components as $comp)
                                    @php 
                                        $safeKey = getSafeKey($comp); 
                                        $record = $checksAfter->get($comp);
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-4 font-bold text-gray-800">{{ $comp }}</td>
                                        <td class="p-4">
                                            @if($comp === 'Laptop GCS' || $comp === 'Laptop Processing')
                                                <select name="complete_sesudah_{{ $safeKey }}" class="w-full rounded-md border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] sm:text-sm font-medium">
                                                    <option value="">-- Pilih Laptop/PC --</option>
                                                    <option value="Milik Pribadi" {{ ($record->completeness ?? '') == 'Milik Pribadi' ? 'selected' : '' }}>Milik Pribadi</option>
                                                    @foreach($pcs as $pc)
                                                        <option value="{{ $pc->name }}" {{ ($record->completeness ?? '') == $pc->name ? 'selected' : '' }}>
                                                            {{ $pc->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" name="complete_sesudah_{{ $safeKey }}" value="{{ $record->completeness ?? '' }}" class="w-full rounded-md border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] sm:text-sm" placeholder="Isian kelengkapan...">
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            <select name="condition_sesudah_{{ $safeKey }}" class="w-full rounded-md border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] sm:text-sm font-bold"
                                                :class="{'text-green-600': $el.value == 'baik', 'text-red-600': $el.value == 'rusak', 'text-gray-500': $el.value == 'tidak_ada'}">
                                                <option value="baik" class="text-green-600" {{ ($record->condition ?? 'baik') == 'baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="rusak" class="text-red-600" {{ ($record->condition ?? '') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                                <option value="tidak_ada" class="text-gray-500" {{ ($record->condition ?? '') == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada</option>
                                            </select>
                                        </td>
                                        <td class="p-4" x-data="{ removed: false, hasFile: {{ ($record && $record->photo_path) ? 'true' : 'false' }} }">
                                            <div x-show="hasFile && !removed" class="mb-2 flex items-center gap-2">
                                                <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded font-bold uppercase">Ada File</span>
                                                <a href="{{ asset('storage/' . ($record->photo_path ?? '')) }}" target="_blank" class="text-[10px] text-blue-600 hover:underline font-bold">Lihat Foto</a>
                                                <span class="text-gray-300">|</span>
                                                <button type="button" @click="removed = true" class="text-[10px] text-red-500 hover:text-red-700 font-bold">Hapus</button>
                                            </div>
                                            <div x-show="!hasFile || removed">
                                                <input type="file" name="photo_sesudah_{{ $safeKey }}" class="w-full text-[11px] text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[11px] file:font-semibold file:bg-[#F8931F]/10 file:text-[#F8931F] hover:file:bg-[#F8931F]/20 transition cursor-pointer" accept="image/*">
                                                <p x-show="removed && hasFile" class="text-[10px] text-red-500 italic mt-1" style="display:none;">⚠️ File lama akan dihapus saat form disimpan.</p>
                                            </div>
                                            <input type="hidden" name="remove_photo_sesudah_{{ $safeKey }}" :value="removed ? '1' : '0'">
                                        </td>
                                        <td class="p-4">
                                            <input type="text" name="note_sesudah_{{ $safeKey }}" value="{{ $record->notes ?? '' }}" class="w-full rounded-md border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] sm:text-sm" placeholder="Ket...">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500 font-medium">Pastikan seluruh inputan komponen <strong class="text-gray-800">Sebelum</strong> dan <strong class="text-gray-800">Sesudah</strong> telah dicek sebelum menyimpan.</p>
                <button type="submit" class="w-full sm:w-auto bg-[#144C4D] text-white px-8 py-3 rounded-lg font-bold hover:bg-[#0e3536] transition shadow-md flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Seluruh Log UAV
                </button>
            </div>
        </form>
    </div>

    
</x-app-layout>