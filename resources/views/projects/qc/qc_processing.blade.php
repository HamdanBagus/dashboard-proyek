<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.qc.index', $project->id) }}" class="text-teal-600 hover:underline">Formulir & QC</a>
            <span class="text-gray-400 mx-2">/</span> QC Pengolah Data 🖥️
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success')) <div class="bg-green-100 text-green-700 p-4 rounded">{{ session('success') }}</div> @endif

        <form action="{{ route('projects.qc.processing.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Informasi Proyek</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div><span class="block text-gray-500">Nama Project</span><span class="font-bold">{{ $project->name }}</span></div>
                    <div><span class="block text-gray-500">Kode Project</span><span class="font-bold">{{ $project->code }}</span></div>
                    <div><span class="block text-gray-500">Luas Project</span><span class="font-bold">{{ $project->area_size }} Ha</span></div>
                    <div><span class="block text-gray-500">Total Hamparan (LiDAR)</span><span class="font-bold">{{ $totalHamparan }} Hamparan</span></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-teal-700 border-b pb-2">A. Checklist Kelengkapan Dokumen & Output</h3>
                <table class="w-full text-sm text-left border">
                    <thead class="bg-gray-100">
                        <tr><th class="p-3 border">Output / Dokumen</th><th class="p-3 border text-center w-32">Ada?</th><th class="p-3 border">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        @php
                            $checklists = [
                                ['id' => 'project_file', 'label' => 'Project file'], ['id' => 'ortho', 'label' => 'Orthofoto'],
                                ['id' => 'dsm', 'label' => 'DSM'], ['id' => 'dtm', 'label' => 'DTM'],
                                ['id' => 'accuracy', 'label' => 'Tabel uji akurasi'], ['id' => 'report', 'label' => 'Laporan'],
                                ['id' => 'other', 'label' => 'Output Lainnya (MBTiles, Kontur, Digitasi)']
                            ];
                        @endphp
                        @foreach($checklists as $chk)
                        <tr>
                            <td class="p-3 border font-medium">{{ $chk['label'] }}</td>
                            <td class="p-3 border text-center"><input type="checkbox" name="chk_{{ $chk['id'] }}" value="1" {{ $qc->{'chk_'.$chk['id']} ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 h-5 w-5"></td>
                            <td class="p-3 border"><input type="text" name="note_{{ $chk['id'] }}" value="{{ $qc->{'note_'.$chk['id']} }}" class="w-full border-gray-300 rounded-md text-sm" placeholder="Catatan..."></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-teal-700 border-b pb-2">B. Poin Pengecekan Kualitas Data (DICEK OLEH 2 ORANG)</h3>

                @php
                    $poinQc = [
                        ['id' => 'accuracy', 'desc' => '1. Ketelitian CE90 & LE90 sesuai standar. (Screenshot tabel uji akurasi)'],
                        ['id' => 'ortho', 'desc' => '2. Hasil orthofoto seamless antar hamparan. (Screenshot perpotongan orthofoto)'],
                        ['id' => 'cloud', 'desc' => '3. Klasifikasi point cloud bersih dari noise & spike. (Screenshot hasil klasifikasi)'],
                        ['id' => 'folder', 'desc' => '4. Penamaan file dan folder sudah sesuai. (Screenshot file & folder)'],
                        ['id' => 'hdd', 'desc' => '5. Folderisasi lengkap & Harddisk diberi label. (Foto harddisk & screenshot)']
                    ];
                @endphp

                <div class="space-y-6">
                    @foreach($poinQc as $poin)
                    <div class="border rounded-md">
                        <div class="bg-gray-100 p-3 border-b font-bold text-sm text-gray-800">{{ $poin['desc'] }}</div>
                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="p-4 border-r bg-blue-50">
                                <span class="block text-xs font-bold text-blue-800 mb-2">Upload File Pengecek 1</span>
                                <input type="file" name="c1_file_{{ $poin['id'] }}" class="text-sm w-full">
                                @if($qc->{'c1_file_'.$poin['id']}) <a href="{{ asset('storage/' . $qc->{'c1_file_'.$poin['id']}) }}" target="_blank" class="text-blue-600 text-xs mt-2 block underline">Lihat File C1</a> @endif
                            </div>
                            <div class="p-4 bg-green-50">
                                <span class="block text-xs font-bold text-green-800 mb-2">Upload File Pengecek 2</span>
                                <input type="file" name="c2_file_{{ $poin['id'] }}" class="text-sm w-full">
                                @if($qc->{'c2_file_'.$poin['id']}) <a href="{{ asset('storage/' . $qc->{'c2_file_'.$poin['id']}) }}" target="_blank" class="text-green-600 text-xs mt-2 block underline">Lihat File C2</a> @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="border p-4 rounded-lg bg-blue-50">
                    <h4 class="font-bold text-blue-800 mb-4 border-b pb-2">Tanda Tangan Pengecek 1</h4>
                    <div class="space-y-4">
                        <div><label class="block text-sm">Tanggal QC</label><input type="date" name="c1_date" value="{{ $qc->c1_date }}" class="w-full rounded border-gray-300"></div>
                        <div><label class="block text-sm">Nama Pengecek</label><input type="text" name="c1_name" value="{{ $qc->c1_name }}" class="w-full rounded border-gray-300"></div>
                        <div>
                            <label class="block text-sm">Ada Revisi Mayor?</label>
                            <select name="c1_revision" class="w-full rounded border-gray-300">
                                <option value="">- Pilih -</option>
                                <option value="Y" {{ $qc->c1_revision == 'Y' ? 'selected' : '' }}>Ya (Y)</option>
                                <option value="N" {{ $qc->c1_revision == 'N' ? 'selected' : '' }}>Tidak (N)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border p-4 rounded-lg bg-green-50">
                    <h4 class="font-bold text-green-800 mb-4 border-b pb-2">Tanda Tangan Pengecek 2</h4>
                    <div class="space-y-4">
                        <div><label class="block text-sm">Tanggal QC</label><input type="date" name="c2_date" value="{{ $qc->c2_date }}" class="w-full rounded border-gray-300"></div>
                        <div><label class="block text-sm">Nama Pengecek</label><input type="text" name="c2_name" value="{{ $qc->c2_name }}" class="w-full rounded border-gray-300"></div>
                        <div>
                            <label class="block text-sm">Ada Revisi Mayor?</label>
                            <select name="c2_revision" class="w-full rounded border-gray-300">
                                <option value="">- Pilih -</option>
                                <option value="Y" {{ $qc->c2_revision == 'Y' ? 'selected' : '' }}>Ya (Y)</option>
                                <option value="N" {{ $qc->c2_revision == 'N' ? 'selected' : '' }}>Tidak (N)</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-teal-600 text-white px-6 py-3 rounded-md font-bold hover:bg-teal-700 text-lg shadow-lg">Simpan Laporan QC Pengolahan</button>
            </div>
        </form>
    </div>
</x-app-layout>
