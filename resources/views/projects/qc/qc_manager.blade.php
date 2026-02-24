<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.qc.index', $project->id) }}" class="text-gray-600 hover:underline">Formulir & QC</a>
            <span class="text-gray-400 mx-2">/</span> QC Project Manager 👔
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success')) <div class="bg-green-100 text-green-700 p-4 rounded">{{ session('success') }}</div> @endif

        <form action="{{ route('projects.qc.manager.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Informasi Proyek Final</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div><span class="block text-gray-500">Nama Project</span><span class="font-bold text-lg">{{ $project->name }}</span></div>
                    <div><span class="block text-gray-500">Kode Project</span><span class="font-bold text-lg">{{ $project->code }}</span></div>
                    <div><span class="block text-gray-500">Luas Project</span><span class="font-bold text-lg">{{ $project->area_size }} Ha</span></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">A. Checklist Kelengkapan Laporan</h3>
                <table class="w-full text-sm text-left border">
                    <thead class="bg-gray-100">
                        <tr><th class="p-3 border">Dokumen Final</th><th class="p-3 border text-center w-32">Lengkap?</th><th class="p-3 border">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-3 border font-medium">Laporan Pekerjaan</td>
                            <td class="p-3 border text-center"><input type="checkbox" name="chk_report" value="1" {{ $qc->chk_report ? 'checked' : '' }} class="rounded border-gray-300 text-gray-800 h-5 w-5"></td>
                            <td class="p-3 border"><input type="text" name="note_report" value="{{ $qc->note_report }}" class="w-full border-gray-300 rounded-md text-sm" placeholder="Catatan..."></td>
                        </tr>
                        <tr>
                            <td class="p-3 border font-medium">Dokumen lain (SLA, Peta, dll)</td>
                            <td class="p-3 border text-center"><input type="checkbox" name="chk_other_docs" value="1" {{ $qc->chk_other_docs ? 'checked' : '' }} class="rounded border-gray-300 text-gray-800 h-5 w-5"></td>
                            <td class="p-3 border"><input type="text" name="note_other_docs" value="{{ $qc->note_other_docs }}" class="w-full border-gray-300 rounded-md text-sm" placeholder="Catatan..."></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">B. Validasi Dokumen</h3>
                @php
                    $poinQc = [
                        ['id' => 'report', 'desc' => '1. Laporan sudah sesuai pada penulisan dan nomenklatur-nya. (Screenshot cover dan kata pengantar)'],
                        ['id' => 'other', 'desc' => '2. Dokumen lain (SLA, peta) sudah sesuai penulisan dan nomenklatur-nya. (Screenshot dokumen)']
                    ];
                @endphp
                <div class="space-y-4">
                    @foreach($poinQc as $poin)
                    <div class="bg-gray-50 p-4 rounded border border-gray-300">
                        <p class="font-bold text-sm mb-2 text-gray-800">{{ $poin['desc'] }}</p>
                        <input type="file" name="file_{{ $poin['id'] }}" class="text-sm">
                        @if($qc->{'file_'.$poin['id']})
                            <a href="{{ asset('storage/' . $qc->{'file_'.$poin['id']}) }}" target="_blank" class="text-blue-600 text-xs ml-4 underline">Lihat Bukti Terupload</a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h4 class="font-bold text-gray-800 mb-4 border-b border-gray-300 pb-2">Tanda Tangan Project Manager</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm">Tanggal QC</label>
                        <input type="date" name="qc_date" value="{{ $qc->qc_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm">Nama Manager</label>
                        <input type="text" name="qc_name" value="{{ $qc->qc_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Nama PM">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-red-600">Ada Revisi Mayor?</label>
                        <select name="revision" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm font-bold">
                            <option value="">- Pilih -</option>
                            <option value="Y" {{ $qc->revision == 'Y' ? 'selected' : '' }}>Ya, Ada Revisi (Y)</option>
                            <option value="N" {{ $qc->revision == 'N' ? 'selected' : '' }}>Tidak, Aman (N)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-gray-800 text-white px-8 py-4 rounded-md font-bold hover:bg-black text-xl shadow-2xl tracking-wider">🚀 SIMPAN FINAL (QC MANAGER)</button>
            </div>
        </form>
    </div>
</x-app-layout>
