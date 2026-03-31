<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.qc.index', $project->id) }}" class="text-[#F8931F] hover:underline">Formulir & QC</a>
            <span class="text-gray-400 mx-2">/</span> QC Akuisisi Foto Udara 
        </h2>
    </x-slot>

    <div class="py-12  mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success')) <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm font-medium">{{ session('success') }}</div> @endif

        <form action="{{ route('projects.qc.uav_photo.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Informasi Proyek & Alat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm mb-2">
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <span class="text-xs uppercase tracking-wider font-bold text-gray-500 w-32 shrink-0">Nama Project</span>
                            <span class="font-bold text-gray-900 text-base">{{ $project->name }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-xs uppercase tracking-wider font-bold text-gray-500 w-32 shrink-0">Kode Project</span>
                            <span class="font-bold text-gray-900 text-base">{{ $project->code }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-xs uppercase tracking-wider font-bold text-gray-500 w-32 shrink-0">Total Flight</span>
                            <span class="font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded text-xs">{{ $totalFlights }} Flight</span>
                        </div>
                        <div class="flex items-start pt-1 border-t border-gray-100">
                            <span class="text-xs uppercase tracking-wider font-bold text-gray-500 w-32 shrink-0 mt-1">Personil UAV</span>
                            <span class="font-semibold text-gray-800 mt-1">
                                @forelse($project->personnel->whereIn('pivot.role', ['Pilot', 'Asisten Pilot']) as $p) 
                                    {{ $p->name }}@if(!$loop->last), @endif
                                @empty
                                    <span class="text-gray-400 italic">Belum ada Pilot/Asisten di proyek ini</span>
                                @endforelse
                            </span>
                        </div>
                    </div>
                    
                    <div class="space-y-4 bg-gray-50 p-5 rounded-lg border border-gray-200">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">UAV Yang Digunakan</label>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    // Parse JSON dari kolom planned_uavs
                                    $rawUavs = is_string($project->planned_uavs) ? json_decode($project->planned_uavs, true) : $project->planned_uavs;
                                    $plannedUavs = is_array($rawUavs) ? $rawUavs : [];
                                @endphp
                                
                                @forelse($plannedUavs as $uav)
                                    @if(isset($uav['id']))
                                        <span class="bg-[#F4F7F6] text-[#144C4D] border border-[#144C4D]/30 px-3 py-1 rounded text-xs font-bold shadow-sm">
                                            {{ $uav['id'] }} ({{ $uav['qty'] ?? 1 }} Unit)
                                        </span>
                                    @endif
                                @empty
                                    <span class="text-gray-400 italic text-xs">Belum diatur di menu Rencana Proyek</span>
                                @endforelse
                            </div>
                        </div>
                        
                        <div class="pt-3 border-t border-gray-200">
                            <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Kamera Yang Digunakan</label>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    // Parse JSON dari kolom planned_cameras
                                    $rawCameras = is_string($project->planned_cameras) ? json_decode($project->planned_cameras, true) : $project->planned_cameras;
                                    $plannedCameras = is_array($rawCameras) ? $rawCameras : [];
                                @endphp

                                @forelse($plannedCameras as $cam)
                                    @if(isset($cam['id']))
                                        <span class="bg-orange-50 text-[#F8931F] border border-[#F8931F]/30 px-3 py-1 rounded text-xs font-bold shadow-sm">
                                            {{ $cam['id'] }} ({{ $cam['qty'] ?? 1 }} Unit)
                                        </span>
                                    @endif
                                @empty
                                    <span class="text-gray-400 italic text-xs">Belum diatur di menu Rencana Proyek</span>
                                @endforelse
                            </div>
                        </div>
                        
                        <p class="text-[10px] text-gray-400 italic mt-2 leading-tight">*Data alat ini ditarik otomatis dari Database Rencana Proyek dan tidak perlu diinput manual saat QC.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-[#F8931F]">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">A. Checklist Kelengkapan Dokumen & Folder</h3>
                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
                            <tr>
                                <th class="p-3 font-bold uppercase tracking-wider text-xs">Kategori Kelengkapan</th>
                                <th class="p-3 text-center w-32 font-bold uppercase tracking-wider text-xs">Lengkap?</th>
                                <th class="p-3 font-bold uppercase tracking-wider text-xs">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php
                                $checklists = [
                                    ['id' => 'raw_photo', 'label' => 'Raw data foto'],
                                    ['id' => 'raw_uav', 'label' => 'Raw data UAV'],
                                    ['id' => 'base_gps', 'label' => 'Data Base GPS'],
                                    ['id' => 'geotag', 'label' => 'Geotagg foto']
                                ];
                            @endphp
                            @foreach($checklists as $chk)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 font-medium text-gray-800">{{ $chk['label'] }}</td>
                                <td class="p-3 text-center bg-orange-50/30">
                                    <input type="checkbox" name="chk_{{ $chk['id'] }}" value="1" {{ $qc->{'chk_'.$chk['id']} ? 'checked' : '' }} class="rounded border-gray-300 text-[#F8931F] focus:ring-[#F8931F] h-5 w-5 cursor-pointer shadow-sm">
                                </td>
                                <td class="p-3">
                                    <input type="text" name="note_{{ $chk['id'] }}" value="{{ $qc->{'note_'.$chk['id']} }}" class="w-full border-gray-300 rounded-md text-sm shadow-sm focus:border-[#F8931F] focus:ring-[#F8931F]" placeholder="Ketik keterangan (opsional)...">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">B. Poin Pengecekan Kualitas Data (Maks. 2MB/file)</h3>
                <div class="space-y-4 mb-2">
                    @php
                        $uploads = [
                            ['id' => 'file_quality', 'desc' => '1. Kualitas cahaya, warna, dan ketajaman sudah seragam. (Screenshot sampel orthofoto)'],
                            ['id' => 'file_geotag', 'desc' => '2. Hasil geotagg sesuai dan akurat. (Screenshot titik kontrol dengan premark pada orthofoto)'],
                            ['id' => 'file_blur', 'desc' => '3. Tidak ada foto berawan, blur, sunspot berlebih.'],
                            ['id' => 'file_overlap', 'desc' => '4. Jalur terbang sesuai, overlap & sidelap mencukupi. (Screenshot seluruh jalur terbang)'],
                            ['id' => 'file_gsd', 'desc' => '5. GSD yang dihasilkan kurang dari 10 cm.']
                        ];
                    @endphp
                    
                    @foreach($uploads as $up)
                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200" x-data="{ removed: false, hasFile: {{ $qc->{$up['id']} ? 'true' : 'false' }}, fileError: false }">
                        <p class="font-bold text-sm mb-3 text-gray-800">{{ $up['desc'] }}</p>
                        
                        <div x-show="hasFile && !removed" class="flex items-center gap-3 bg-white p-3 rounded border border-gray-200 inline-flex shadow-sm">
                            <span class="text-sm font-bold text-green-600 flex items-center gap-1">✅ File Terupload</span>
                            <span class="text-gray-300">|</span>
                            <a href="{{ asset('storage/' . $qc->{$up['id']}) }}" target="_blank" class="text-indigo-600 text-sm font-bold hover:underline">Lihat Bukti</a>
                            <span class="text-gray-300">|</span>
                            <button type="button" @click="removed = true" class="text-red-500 hover:text-red-700 text-sm font-bold flex items-center gap-1">❌ Hapus / Ganti</button>
                        </div>

                        <div x-show="!hasFile || removed">
                            <input type="file" name="{{ $up['id'] }}" class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition cursor-pointer"
                                @change="fileError = $event.target.files[0].size > 2097152; if(fileError) $event.target.value = ''">
                            <p x-show="fileError" class="text-xs text-red-600 font-bold mt-2" style="display:none;">⚠️ File ditolak! Ukuran file melebihi batas 2MB.</p>
                        </div>

                        <input type="hidden" name="remove_{{ $up['id'] }}" x-bind:value="removed ? '1' : '0'">
                        <p x-show="removed && hasFile" class="text-xs text-red-500 italic mt-3 font-medium" style="display: none;">⚠️ File lama akan dihapus. Silakan unggah file baru atau biarkan kosong.</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-[#F4F7F6] p-6 rounded-xl shadow-sm border border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Tanggal QC</label>
                    <input type="date" name="qc_date" value="{{ $qc->qc_date }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F8931F] focus:ring-[#F8931F] sm:text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Nama Petugas QC</label>
                    <input type="text" name="qc_officer_name" value="{{ $qc->qc_officer_name }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#F8931F] focus:ring-[#F8931F] sm:text-sm" placeholder="Ketik nama pemeriksa...">
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#144C4D] text-white px-8 py-3 rounded-lg font-bold hover:bg-[#0e3536] transition text-base shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    <span>Simpan Laporan QC UAV</span>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>