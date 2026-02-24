<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.qc.index', $project->id) }}" class="text-red-600 hover:underline">Formulir & QC</a>
            <span class="text-gray-400 mx-2">/</span> QC Tim Ground 🌍
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success')) <div class="bg-green-100 text-green-700 p-4 rounded">{{ session('success') }}</div> @endif

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

        <form action="{{ route('projects.qc.ground.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-red-700 border-b pb-2">A. Checklist Kelengkapan Dokumen & Folder</h3>
                <table class="w-full text-sm text-left border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 border">Kategori Kelengkapan</th>
                            <th class="p-3 border text-center w-32">Sesuai & Lengkap?</th>
                            <th class="p-3 border">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $checklists = [
                                ['id' => 'form_log', 'label' => 'Form dan log'],
                                ['id' => 'raw_gps', 'label' => 'Raw data GPS'],
                                ['id' => 'report_gps', 'label' => 'Report pengolahan GPS'],
                                ['id' => 'coordinate', 'label' => 'Daftar koordinat'],
                                ['id' => 'photo_utsb', 'label' => 'Foto UTSB']
                            ];
                        @endphp
                        @foreach($checklists as $chk)
                        <tr>
                            <td class="p-3 border font-medium">{{ $chk['label'] }}</td>
                            <td class="p-3 border text-center">
                                <input type="checkbox" name="chk_{{ $chk['id'] }}" value="1" {{ $qc->{'chk_'.$chk['id']} ? 'checked' : '' }} class="rounded border-gray-300 text-red-600 focus:ring-red-500 h-5 w-5">
                            </td>
                            <td class="p-3 border">
                                <input type="text" name="note_{{ $chk['id'] }}" value="{{ $qc->{'note_'.$chk['id']} }}" class="w-full border-gray-300 rounded-md text-sm" placeholder="Isi keterangan bila perlu...">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-red-700 border-b pb-2">B. Poin Pengecekan Kualitas Data (Max 2MB/file)</h3>
                <div class="space-y-6">

                    <div class="bg-gray-50 p-4 rounded border">
                        <p class="font-bold text-sm mb-2 text-gray-800">1. Ketelitian pada report pengolahan masuk toleransi (BM Hz <3cm, V <5cm. GCP/ICP Hz <5cm, V <5cm).</p>
                        <input type="file" name="file_tolerance" class="text-sm">
                        @if($qc->file_tolerance)
                            <a href="{{ asset('storage/' . $qc->file_tolerance) }}" target="_blank" class="text-blue-600 text-xs ml-4 underline">Lihat File Bukti Saat Ini</a>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-4 rounded border">
                        <p class="font-bold text-sm mb-2 text-gray-800">2. Selisih hasil koordinat dibandingkan pengolahan Inacors Spiderweb kurang dari 10cm.</p>
                        <input type="file" name="file_inacors" class="text-sm">
                        @if($qc->file_inacors)
                            <a href="{{ asset('storage/' . $qc->file_inacors) }}" target="_blank" class="text-blue-600 text-xs ml-4 underline">Lihat File Bukti Saat Ini</a>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-4 rounded border">
                        <p class="font-bold text-sm mb-2 text-gray-800">3. Lokasi titik koordinat sudah sesuai ketika di plot pada Google Earth.</p>
                        <input type="file" name="file_google_earth" class="text-sm">
                        @if($qc->file_google_earth)
                            <a href="{{ asset('storage/' . $qc->file_google_earth) }}" target="_blank" class="text-blue-600 text-xs ml-4 underline">Lihat File Bukti Saat Ini</a>
                        @endif
                    </div>

                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal QC</label>
                        <input type="date" name="qc_date" value="{{ $qc->qc_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Petugas QC</label>
                        <input type="text" name="qc_officer_name" value="{{ $qc->qc_officer_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Ketik nama pemeriksa...">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-md font-bold hover:bg-red-700 text-lg shadow-lg">Simpan Laporan QC Ground</button>
            </div>
        </form>

    </div>
</x-app-layout>
