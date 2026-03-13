<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.qc.index', $project->id) }}" class="text-red-600 hover:underline">Formulir & QC</a>
            <span class="text-gray-400 mx-2">/</span> QC Tim Ground 🌍
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success')) <div class="bg-green-100 text-green-700 p-4 rounded shadow-sm">{{ session('success') }}</div> @endif

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h3 class="font-bold text-lg mb-4 text-gray-800">Informasi Proyek</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div><span class="block text-gray-500">Nama Project</span><span class="font-bold">{{ $project->name }}</span></div>
                <div><span class="block text-gray-500">Kode Project</span><span class="font-bold">{{ $project->code }}</span></div>
                <div>
                    <span class="block text-gray-500">Jumlah Titik Kontrol</span>
                    <span class="font-bold">BM: {{ $project->groundReport->bm_count ?? 0 }}, GCP: {{ $project->groundReport->gcp_count ?? 0 }}, ICP: {{ $project->groundReport->icp_count ?? 0 }}</span>
                </div>
                <div>
                    <span class="block text-gray-500">Personil Tim Ground</span>
                    <span class="font-bold">@foreach($project->personnel->where('pivot.role', 'Surveyor') as $p) {{ $p->name }}, @endforeach</span>
                </div>
            </div>
        </div>

        @php
            $checklists = [
                ['id' => 'form_log', 'label' => 'Form dan log'],
                ['id' => 'raw_gps', 'label' => 'Raw data GPS'],
                ['id' => 'report_gps', 'label' => 'Report pengolahan GPS'],
                ['id' => 'coordinate', 'label' => 'Daftar koordinat'],
                ['id' => 'photo_utsb', 'label' => 'Foto UTSB']
            ];
        @endphp

        <form action="{{ route('projects.qc.ground.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ hasRevision: '{{ $qc->has_major_revision ?? 0 }}' }">
            @csrf

            <div class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-indigo-600">
                <h2 class="text-2xl font-black mb-6 text-indigo-800">QC TAHAP PERTAMA (UTAMA)</h2>
                
                <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">A. Checklist Kelengkapan & Folderisasi</h3>
                <div class="overflow-x-auto mb-8">
                    <table class="w-full text-sm text-left border">
                        <thead class="bg-indigo-50 text-indigo-800">
                            <tr>
                                <th class="p-3 border">Kategori Dokumen</th>
                                <th class="p-3 border text-center w-32">Kelengkapan</th>
                                <th class="p-3 border text-center w-32">Kesesuaian Folder</th>
                                <th class="p-3 border">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checklists as $chk)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 border font-medium">{{ $chk['label'] }}</td>
                                <td class="p-3 border text-center bg-blue-50">
                                    <input type="checkbox" name="chk_complete_{{ $chk['id'] }}" value="1" {{ $qc->{'chk_complete_'.$chk['id']} ? 'checked' : '' }} class="rounded border-gray-400 text-blue-600 focus:ring-blue-500 h-5 w-5 cursor-pointer">
                                </td>
                                <td class="p-3 border text-center bg-green-50">
                                    <input type="checkbox" name="chk_folder_{{ $chk['id'] }}" value="1" {{ $qc->{'chk_folder_'.$chk['id']} ? 'checked' : '' }} class="rounded border-gray-400 text-green-600 focus:ring-green-500 h-5 w-5 cursor-pointer">
                                </td>
                                <td class="p-3 border">
                                    <input type="text" name="note_{{ $chk['id'] }}" value="{{ $qc->{'note_'.$chk['id']} }}" class="w-full border-gray-300 rounded-md text-sm" placeholder="Isi keterangan...">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">B. Pengecekan Kualitas Data</h3>
                <div class="space-y-4 mb-8">
                    
                    <div class="bg-gray-50 p-4 rounded border" x-data="{ removed: false }">
                        <p class="font-bold text-sm mb-2 text-gray-800">1. Ketelitian report masuk toleransi (BM Hz <3cm, V <5cm. GCP/ICP Hz <5cm, V <5cm).</p>
                        <input type="file" name="file_tolerance" class="text-sm">
                        @if($qc->file_tolerance) 
                            <div x-show="!removed" class="inline-flex items-center ml-4 gap-3 bg-white px-3 py-1 rounded border shadow-sm">
                                <a href="{{ asset('storage/' . $qc->file_tolerance) }}" target="_blank" class="text-blue-600 text-xs font-bold hover:underline">Lihat Bukti Saat Ini</a>
                                <span class="text-gray-300">|</span>
                                <button type="button" @click="removed = true" class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1">❌ Hapus File</button>
                            </div>
                            <input type="hidden" name="remove_file_tolerance" x-bind:value="removed ? '1' : '0'">
                            <span x-show="removed" class="text-xs text-red-500 italic ml-4 font-medium" style="display: none;">⚠️ File lama akan dihapus permanen saat tombol Simpan ditekan.</span>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-4 rounded border" x-data="{ removed: false }">
                        <p class="font-bold text-sm mb-2 text-gray-800">2. Selisih hasil koordinat dibandingkan Inacors Spiderweb < 10cm.</p>
                        <input type="file" name="file_inacors" class="text-sm">
                        @if($qc->file_inacors) 
                            <div x-show="!removed" class="inline-flex items-center ml-4 gap-3 bg-white px-3 py-1 rounded border shadow-sm">
                                <a href="{{ asset('storage/' . $qc->file_inacors) }}" target="_blank" class="text-blue-600 text-xs font-bold hover:underline">Lihat Bukti Saat Ini</a>
                                <span class="text-gray-300">|</span>
                                <button type="button" @click="removed = true" class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1">❌ Hapus File</button>
                            </div>
                            <input type="hidden" name="remove_file_inacors" x-bind:value="removed ? '1' : '0'">
                            <span x-show="removed" class="text-xs text-red-500 italic ml-4 font-medium" style="display: none;">⚠️ File lama akan dihapus permanen saat tombol Simpan ditekan.</span>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-4 rounded border" x-data="{ removed: false }">
                        <p class="font-bold text-sm mb-2 text-gray-800">3. Plotting lokasi pada Google Earth sesuai.</p>
                        <input type="file" name="file_google_earth" class="text-sm">
                        @if($qc->file_google_earth) 
                            <div x-show="!removed" class="inline-flex items-center ml-4 gap-3 bg-white px-3 py-1 rounded border shadow-sm">
                                <a href="{{ asset('storage/' . $qc->file_google_earth) }}" target="_blank" class="text-blue-600 text-xs font-bold hover:underline">Lihat Bukti Saat Ini</a>
                                <span class="text-gray-300">|</span>
                                <button type="button" @click="removed = true" class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1">❌ Hapus File</button>
                            </div>
                            <input type="hidden" name="remove_file_google_earth" x-bind:value="removed ? '1' : '0'">
                            <span x-show="removed" class="text-xs text-red-500 italic ml-4 font-medium" style="display: none;">⚠️ File lama akan dihapus permanen saat tombol Simpan ditekan.</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-indigo-50 p-4 rounded-lg border border-indigo-200">
                    <div>
                        <label class="block text-sm font-bold text-indigo-800">Tanggal QC Utama</label>
                        <input type="date" name="qc_date" value="{{ $qc->qc_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-indigo-800">Nama Petugas QC</label>
                        <input type="text" name="qc_officer_name" value="{{ $qc->qc_officer_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Nama pemeriksa...">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-red-600">Apakah Ada Revisi Mayor?</label>
                        <select name="has_major_revision" x-model="hasRevision" class="mt-1 block w-full rounded-md border-red-300 text-red-700 shadow-sm bg-red-50 focus:ring-red-500 focus:border-red-500 font-bold cursor-pointer">
                            <option value="0" class="text-green-600 font-bold bg-green-50">TIDAK ADA (Selesai)</option>
                            <option value="1" class="text-red-600 font-bold bg-red-50">YA, ADA REVISI</option>
                        </select>
                    </div>
                </div>
            </div>

            <div x-show="hasRevision == '1'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;" class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-red-500 mt-8">
                <h2 class="text-2xl font-black mb-6 text-red-700 flex items-center gap-2">
                    <span>⚠️</span> QC TAHAP KEDUA (REVISI)
                </h2>
                
                <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">A. Checklist Hasil Revisi</h3>
                <div class="overflow-x-auto mb-8">
                    <table class="w-full text-sm text-left border">
                        <thead class="bg-red-50 text-red-800">
                            <tr>
                                <th class="p-3 border">Kategori Dokumen</th>
                                <th class="p-3 border text-center w-32">Kelengkapan</th>
                                <th class="p-3 border text-center w-32">Kesesuaian Folder</th>
                                <th class="p-3 border">Keterangan Revisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checklists as $chk)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 border font-medium">{{ $chk['label'] }}</td>
                                <td class="p-3 border text-center bg-blue-50">
                                    <input type="checkbox" name="rev_chk_complete_{{ $chk['id'] }}" value="1" {{ $qc->{'rev_chk_complete_'.$chk['id']} ? 'checked' : '' }} class="rounded border-gray-400 text-blue-600 focus:ring-blue-500 h-5 w-5 cursor-pointer">
                                </td>
                                <td class="p-3 border text-center bg-green-50">
                                    <input type="checkbox" name="rev_chk_folder_{{ $chk['id'] }}" value="1" {{ $qc->{'rev_chk_folder_'.$chk['id']} ? 'checked' : '' }} class="rounded border-gray-400 text-green-600 focus:ring-green-500 h-5 w-5 cursor-pointer">
                                </td>
                                <td class="p-3 border">
                                    <input type="text" name="rev_note_{{ $chk['id'] }}" value="{{ $qc->{'rev_note_'.$chk['id']} }}" class="w-full border-gray-300 rounded-md text-sm" placeholder="Isi catatan revisi...">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">B. Bukti Kualitas Data Revisi</h3>
                <div class="space-y-4 mb-8">
                    
                    <div class="bg-gray-50 p-4 rounded border" x-data="{ removed: false }">
                        <p class="font-bold text-sm mb-2 text-gray-800">1. Bukti Ketelitian Terbaru</p>
                        <input type="file" name="rev_file_tolerance" class="text-sm">
                        @if($qc->rev_file_tolerance) 
                            <div x-show="!removed" class="inline-flex items-center ml-4 gap-3 bg-white px-3 py-1 rounded border shadow-sm">
                                <a href="{{ asset('storage/' . $qc->rev_file_tolerance) }}" target="_blank" class="text-blue-600 text-xs font-bold hover:underline">Lihat Bukti Revisi</a>
                                <span class="text-gray-300">|</span>
                                <button type="button" @click="removed = true" class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1">❌ Hapus File</button>
                            </div>
                            <input type="hidden" name="remove_rev_file_tolerance" x-bind:value="removed ? '1' : '0'">
                            <span x-show="removed" class="text-xs text-red-500 italic ml-4 font-medium" style="display: none;">⚠️ File lama akan dihapus permanen saat tombol Simpan ditekan.</span>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-4 rounded border" x-data="{ removed: false }">
                        <p class="font-bold text-sm mb-2 text-gray-800">2. Bukti Inacors Terbaru</p>
                        <input type="file" name="rev_file_inacors" class="text-sm">
                        @if($qc->rev_file_inacors) 
                            <div x-show="!removed" class="inline-flex items-center ml-4 gap-3 bg-white px-3 py-1 rounded border shadow-sm">
                                <a href="{{ asset('storage/' . $qc->rev_file_inacors) }}" target="_blank" class="text-blue-600 text-xs font-bold hover:underline">Lihat Bukti Revisi</a>
                                <span class="text-gray-300">|</span>
                                <button type="button" @click="removed = true" class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1">❌ Hapus File</button>
                            </div>
                            <input type="hidden" name="remove_rev_file_inacors" x-bind:value="removed ? '1' : '0'">
                            <span x-show="removed" class="text-xs text-red-500 italic ml-4 font-medium" style="display: none;">⚠️ File lama akan dihapus permanen saat tombol Simpan ditekan.</span>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-4 rounded border" x-data="{ removed: false }">
                        <p class="font-bold text-sm mb-2 text-gray-800">3. Bukti Google Earth Terbaru</p>
                        <input type="file" name="rev_file_google_earth" class="text-sm">
                        @if($qc->rev_file_google_earth) 
                            <div x-show="!removed" class="inline-flex items-center ml-4 gap-3 bg-white px-3 py-1 rounded border shadow-sm">
                                <a href="{{ asset('storage/' . $qc->rev_file_google_earth) }}" target="_blank" class="text-blue-600 text-xs font-bold hover:underline">Lihat Bukti Revisi</a>
                                <span class="text-gray-300">|</span>
                                <button type="button" @click="removed = true" class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1">❌ Hapus File</button>
                            </div>
                            <input type="hidden" name="remove_rev_file_google_earth" x-bind:value="removed ? '1' : '0'">
                            <span x-show="removed" class="text-xs text-red-500 italic ml-4 font-medium" style="display: none;">⚠️ File lama akan dihapus permanen saat tombol Simpan ditekan.</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-red-50 p-4 rounded-lg border border-red-200">
                    <div>
                        <label class="block text-sm font-bold text-red-800">Tanggal QC Revisi</label>
                        <input type="date" name="rev_qc_date" value="{{ $qc->rev_qc_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-red-800">Nama Petugas QC Revisi</label>
                        <input type="text" name="rev_qc_officer_name" value="{{ $qc->rev_qc_officer_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Nama pemeriksa revisi...">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-gray-900 text-white px-8 py-3 rounded-lg font-bold hover:bg-black text-lg shadow-lg flex items-center gap-2">
                    <span>💾 Simpan Keseluruhan Laporan QC</span>
                </button>
            </div>
        </form>

    </div>
</x-app-layout>