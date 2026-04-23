<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.qc.index', $project->id) }}" class="text-[#144C4D] hover:underline">Formulir & QC</a>
            <span class="text-gray-400 mx-2">/</span> QC Project Manager
        </h2>
    </x-slot>

    <div class="pt-6 pb-12 mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success')) <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm font-medium">{{ session('success') }}</div> @endif

        <form action="{{ route('projects.qc.manager.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ hasRevision: '{{ $qc->has_major_revision ?? 0 }}' }">
            @csrf

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col xl:flex-row xl:items-center justify-between gap-6">
                
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="font-bold text-lg text-gray-800">Informasi Proyek (Tahap Akhir)</h3>
                    </div>
                    <p class="text-sm text-gray-500 xl:ml-7">Pastikan seluruh tim sudah menyelesaikan QC di tahap sebelumnya sebelum pengesahan.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 bg-gray-50 rounded-lg border border-gray-200 divide-y sm:divide-y-0 sm:divide-x divide-gray-200 shrink-0">
                    <div class="px-6 py-4 text-left">
                        <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-bold mb-1">Nama Project</span>
                        <span class="font-black text-gray-800 text-base leading-tight block">{{ $project->name }}</span>
                    </div>
                    <div class="px-6 py-4 text-left">
                        <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-bold mb-1">Kode Project</span>
                        <span class="font-black text-[#F8931F] text-base leading-tight block">{{ $project->code }}</span>
                    </div>
                    <div class="px-6 py-4 text-left">
                        <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-bold mb-1">Luas Area</span>
                        <span class="font-black text-[#144C4D] text-base leading-tight block">{{ $project->area_size }} Ha</span>
                    </div>
                </div>
                
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-[#144C4D]">
                <h2 class="text-xl font-black mb-6 text-gray-900 flex items-center gap-2">
                    <svg class="w-6 h-6 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    PENGECEKAN DOKUMEN FINAL
                </h2>
                
                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">A. Checklist Kelengkapan Laporan & Folder</h3>
                <div class="overflow-x-auto border border-gray-200 rounded-lg mb-8">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
                            <tr>
                                <th class="p-3 font-bold uppercase tracking-wider text-xs">Dokumen Final</th>
                                <th class="p-3 text-center w-32 font-bold uppercase tracking-wider text-xs">Kelengkapan</th>
                                <th class="p-3 text-center w-32 font-bold uppercase tracking-wider text-xs">Sesuai Folder</th>
                                <th class="p-3 font-bold uppercase tracking-wider text-xs">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 font-medium text-gray-800">Laporan Pekerjaan</td>
                                <td class="p-3 text-center bg-teal-50/30">
                                    <input type="checkbox" name="chk_report" value="1" {{ $qc->chk_report ? 'checked' : '' }} class="rounded border-gray-300 text-[#144C4D] focus:ring-[#144C4D] h-5 w-5 cursor-pointer shadow-sm">
                                </td>
                                <td class="p-3 text-center bg-green-50/30">
                                    <input type="checkbox" name="chk_folder_report" value="1" {{ $qc->chk_folder_report ? 'checked' : '' }} class="rounded border-gray-300 text-green-600 focus:ring-green-500 h-5 w-5 cursor-pointer shadow-sm">
                                </td>
                                <td class="p-3">
                                    <input type="text" name="note_report" value="{{ $qc->note_report }}" class="w-full border-gray-300 rounded-md text-sm shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D]" placeholder="Ketik catatan (opsional)...">
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 font-medium text-gray-800">Dokumen Lain (SLA, Peta, dll)</td>
                                <td class="p-3 text-center bg-teal-50/30">
                                    <input type="checkbox" name="chk_other_docs" value="1" {{ $qc->chk_other_docs ? 'checked' : '' }} class="rounded border-gray-300 text-[#144C4D] focus:ring-[#144C4D] h-5 w-5 cursor-pointer shadow-sm">
                                </td>
                                <td class="p-3 text-center bg-green-50/30">
                                    <input type="checkbox" name="chk_folder_other_docs" value="1" {{ $qc->chk_folder_other_docs ? 'checked' : '' }} class="rounded border-gray-300 text-green-600 focus:ring-green-500 h-5 w-5 cursor-pointer shadow-sm">
                                </td>
                                <td class="p-3">
                                    <input type="text" name="note_other_docs" value="{{ $qc->note_other_docs }}" class="w-full border-gray-300 rounded-md text-sm shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D]" placeholder="Ketik catatan (opsional)...">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">B. Validasi Isi Dokumen (Maks. 2MB/file)</h3>
                <div class="space-y-4 mb-8">
                    @php
                        $uploads = [
                            ['id' => 'report', 'db' => 'file_report', 'desc' => '1. Laporan sudah sesuai pada penulisan dan nomenklatur-nya. (Screenshot cover & kata pengantar)'],
                            ['id' => 'other', 'db' => 'file_other', 'desc' => '2. Dokumen lain (SLA, peta) sudah sesuai penulisan dan nomenklatur-nya. (Screenshot dokumen)']
                        ];
                    @endphp
                    
                    @foreach($uploads as $up)
                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200" x-data="{ removed: false, hasFile: {{ $qc->{$up['db']} ? 'true' : 'false' }}, fileError: false }">
                        <p class="font-bold text-sm mb-3 text-gray-800">{{ $up['desc'] }}</p>
                        
                        <div x-show="hasFile && !removed" class="flex items-center gap-3 bg-white p-3 rounded border border-gray-200 inline-flex shadow-sm">
                            <span class="text-sm font-bold text-green-600 flex items-center gap-1">✅ Terupload</span>
                            <span class="text-gray-300">|</span>
                            <a href="{{ asset('storage/' . $qc->{$up['db']}) }}" target="_blank" class="text-indigo-600 text-sm font-bold hover:underline">Lihat Bukti</a>
                            <span class="text-gray-300">|</span>
                            <button type="button" @click="removed = true" class="text-red-500 hover:text-red-700 text-sm font-bold flex items-center gap-1">❌ Hapus / Ganti</button>
                        </div>

                        <div x-show="!hasFile || removed">
                            <input type="file" name="{{ $up['db'] }}" class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-[#144C4D] hover:file:bg-teal-100 transition cursor-pointer"
                                @change="fileError = $event.target.files[0].size > 2097152; if(fileError) $event.target.value = ''">
                            <p x-show="fileError" class="text-xs text-red-600 font-bold mt-2" style="display:none;">⚠️ File ditolak! Ukuran file melebihi batas 2MB.</p>
                        </div>

                        <input type="hidden" name="remove_{{ $up['db'] }}" x-bind:value="removed ? '1' : '0'">
                        <p x-show="removed && hasFile" class="text-xs text-red-500 italic mt-3 font-medium" style="display: none;">⚠️ File lama akan dihapus saat form disimpan.</p>
                        <input type="text" name="note_{{ $up['db'] }}" value="{{ $qc->{'note_'.$up['db']} }}" class="w-full mt-2 border-gray-300 rounded-md text-sm shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D]" placeholder="Catatan untuk file ini (opsional)...">
                    </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-[#F4F7F6] p-5 rounded-lg border border-gray-200">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Tanggal Pengesahan</label>
                        <input type="date" name="qc_date" value="{{ $qc->qc_date }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Nama Project Manager</label>
                        <input type="text" name="qc_name" value="{{ $qc->qc_name }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm" placeholder="Nama PM...">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-red-600 uppercase tracking-wider mb-2">Apakah Ada Revisi Laporan?</label>
                        <select name="has_major_revision" x-model="hasRevision" class="block w-full rounded-md border-red-300 text-red-700 shadow-sm bg-white focus:ring-red-500 focus:border-red-500 font-bold cursor-pointer sm:text-sm">
                            <option value="0">TIDAK ADA </option>
                            <option value="1">YA, ADA REVISI</option>
                        </select>
                    </div>
                </div>
            </div>

            <div x-show="hasRevision == '1'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;" class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-red-500 mt-8">
                <h2 class="text-xl font-black mb-6 text-red-700 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    PENGECEKAN DOKUMEN (HASIL REVISI)
                </h2>
                
                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">A. Checklist Hasil Revisi Dokumen</h3>
                <div class="overflow-x-auto mb-8 border border-gray-200 rounded-lg">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-red-50 text-red-800 border-b border-red-100">
                            <tr>
                                <th class="p-3 font-bold uppercase tracking-wider text-xs">Kategori Dokumen</th>
                                <th class="p-3 text-center w-32 font-bold uppercase tracking-wider text-xs">Telah Direvisi?</th>
                                <th class="p-3 text-center w-32 font-bold uppercase tracking-wider text-xs">Sesuai Folder</th>
                                <th class="p-3 font-bold uppercase tracking-wider text-xs">Keterangan Revisi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 font-medium text-gray-800">Laporan Pekerjaan</td>
                                <td class="p-3 text-center bg-teal-50/30">
                                    <input type="checkbox" name="rev_chk_report" value="1" {{ $qc->rev_chk_report ? 'checked' : '' }} class="rounded border-gray-400 text-orange-600 focus:ring-orange-500 h-5 w-5 cursor-pointer">
                                </td>
                                <td class="p-3 text-center bg-green-50/30">
                                    <input type="checkbox" name="rev_chk_folder_report" value="1" {{ $qc->rev_chk_folder_report ? 'checked' : '' }} class="rounded border-gray-400 text-green-600 focus:ring-green-500 h-5 w-5 cursor-pointer">
                                </td>
                                <td class="p-3">
                                    <input type="text" name="rev_note_report" value="{{ $qc->rev_note_report }}" class="w-full border-gray-300 rounded-md text-sm shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Ketik catatan revisi...">
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 font-medium text-gray-800">Dokumen Lain (SLA, Peta, dll)</td>
                                <td class="p-3 text-center bg-teal-50/30">
                                    <input type="checkbox" name="rev_chk_other_docs" value="1" {{ $qc->rev_chk_other_docs ? 'checked' : '' }} class="rounded border-gray-400 text-orange-600 focus:ring-orange-500 h-5 w-5 cursor-pointer">
                                </td>
                                <td class="p-3 text-center bg-green-50/30">
                                    <input type="checkbox" name="rev_chk_folder_other_docs" value="1" {{ $qc->rev_chk_folder_other_docs ? 'checked' : '' }} class="rounded border-gray-400 text-green-600 focus:ring-green-500 h-5 w-5 cursor-pointer">
                                </td>
                                <td class="p-3">
                                    <input type="text" name="rev_note_other_docs" value="{{ $qc->rev_note_other_docs }}" class="w-full border-gray-300 rounded-md text-sm shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Ketik catatan revisi...">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">B. Bukti Validasi Dokumen Revisi (Maks. 2MB)</h3>
                <div class="space-y-4 mb-8">
                    @foreach($uploads as $up)
                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200" x-data="{ removed: false, hasFile: {{ $qc->{'rev_'.$up['db']} ? 'true' : 'false' }}, fileError: false }">
                        <p class="font-bold text-sm mb-3 text-gray-800">{{ str_replace(['1.', '2.'], '', $up['desc']) }} (Bukti Revisi)</p>
                        
                        <div x-show="hasFile && !removed" class="flex items-center gap-3 bg-white p-3 rounded border border-gray-200 inline-flex shadow-sm">
                            <span class="text-sm font-bold text-green-600 flex items-center gap-1">✅ File Terupload</span>
                            <span class="text-gray-300">|</span>
                            <a href="{{ asset('storage/' . $qc->{'rev_'.$up['db']}) }}" target="_blank" class="text-indigo-600 text-sm font-bold hover:underline">Lihat Bukti Revisi</a>
                            <span class="text-gray-300">|</span>
                            <button type="button" @click="removed = true" class="text-red-500 hover:text-red-700 text-sm font-bold flex items-center gap-1">❌ Hapus / Ganti</button>
                        </div>

                        <div x-show="!hasFile || removed">
                            <input type="file" name="rev_{{ $up['db'] }}" class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition cursor-pointer"
                                @change="fileError = $event.target.files[0].size > 2097152; if(fileError) $event.target.value = ''">
                            <p x-show="fileError" class="text-xs text-red-600 font-bold mt-2" style="display:none;">⚠️ File ditolak! Ukuran file melebihi batas 2MB.</p>
                        </div>

                        <input type="hidden" name="remove_rev_{{ $up['db'] }}" x-bind:value="removed ? '1' : '0'">
                        <p x-show="removed && hasFile" class="text-xs text-red-500 italic mt-3 font-medium" style="display: none;">⚠️ File lama akan dihapus.</p>
                        <input type="text" name="rev_note_{{ $up['db'] }}" value="{{ $qc->{'rev_note_'.$up['db']} }}" class="w-full mt-2 border-gray-300 rounded-md text-sm shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Catatan revisi untuk file ini (opsional)...">
                    </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-red-50 p-5 rounded-lg border border-red-200">
                    <div>
                        <label class="block text-xs font-bold text-red-800 uppercase tracking-wider mb-2">Tanggal Pengesahan Revisi</label>
                        <input type="date" name="rev_qc_date" value="{{ $qc->rev_qc_date }}" class="block w-full rounded-md border-red-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-red-800 uppercase tracking-wider mb-2">Nama Project Manager</label>
                        <input type="text" name="rev_qc_name" value="{{ $qc->rev_qc_name }}" class="block w-full rounded-md border-red-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" placeholder="Nama PM...">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#144C4D] text-white px-8 py-3 rounded-lg font-bold hover:bg-[#0e3536] transition text-base shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>Simpan Laporan</span>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>