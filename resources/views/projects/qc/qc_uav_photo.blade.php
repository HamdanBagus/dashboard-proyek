<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.qc.index', $project->id) }}" class="text-orange-600 hover:underline">Formulir & QC</a>
            <span class="text-gray-400 mx-2">/</span> QC Akuisisi Foto Udara 📸
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success')) <div class="bg-green-100 text-green-700 p-4 rounded">{{ session('success') }}</div> @endif

        <form action="{{ route('projects.qc.uav_photo.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Informasi Proyek & Alat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm mb-4">
                    <ul class="space-y-2">
                        <li><span class="text-gray-500 w-32 inline-block">Nama Project</span>: <strong>{{ $project->name }}</strong></li>
                        <li><span class="text-gray-500 w-32 inline-block">Kode Project</span>: <strong>{{ $project->code }}</strong></li>
                        <li><span class="text-gray-500 w-32 inline-block">Total Flight</span>: <strong>{{ $totalFlights }} Flight</strong></li>
                        <li><span class="text-gray-500 w-32 inline-block flex items-start">Personil UAV</span>:
                            <span class="font-bold ml-1">@foreach($project->personnel->whereIn('pivot.role', ['Pilot', 'Asisten Pilot']) as $p) {{ $p->name }}, @endforeach</span>
                        </li>
                    </ul>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">UAV Yang Digunakan (Bisa pilih lebih dari 1)</label>
                            <select name="uav_used[]" multiple class="block w-full rounded-md border-gray-300 shadow-sm text-sm" style="height: 80px;">
                                @foreach($uavs as $u)
                                    <option value="{{ $u->name }}" {{ in_array($u->name, $qc->uav_used ?? []) ? 'selected' : '' }}>{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Kamera Yang Digunakan (Bisa pilih lebih dari 1)</label>
                            <select name="camera_used[]" multiple class="block w-full rounded-md border-gray-300 shadow-sm text-sm" style="height: 80px;">
                                @foreach($cameras as $c)
                                    <option value="{{ $c->name }}" {{ in_array($c->name, $qc->camera_used ?? []) ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-orange-700 border-b pb-2">A. Checklist Kelengkapan Dokumen & Folder</h3>
                <table class="w-full text-sm text-left border">
                    <thead class="bg-gray-100">
                        <tr><th class="p-3 border">Kategori Kelengkapan</th><th class="p-3 border text-center w-32">Lengkap?</th><th class="p-3 border">Keterangan</th></tr>
                    </thead>
                    <tbody>
                        @php
                            $checklists = [
                                ['id' => 'raw_photo', 'label' => 'Raw data foto'],
                                ['id' => 'raw_uav', 'label' => 'Raw data UAV'],
                                ['id' => 'base_gps', 'label' => 'Data Base GPS'],
                                ['id' => 'geotag', 'label' => 'Geotagg foto']
                            ];
                        @endphp
                        @foreach($checklists as $chk)
                        <tr>
                            <td class="p-3 border font-medium">{{ $chk['label'] }}</td>
                            <td class="p-3 border text-center"><input type="checkbox" name="chk_{{ $chk['id'] }}" value="1" {{ $qc->{'chk_'.$chk['id']} ? 'checked' : '' }} class="rounded border-gray-300 text-orange-600 h-5 w-5"></td>
                            <td class="p-3 border"><input type="text" name="note_{{ $chk['id'] }}" value="{{ $qc->{'note_'.$chk['id']} }}" class="w-full border-gray-300 rounded-md text-sm" placeholder="Keterangan..."></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-lg mb-4 text-orange-700 border-b pb-2">B. Poin Pengecekan Kualitas Data (Max 2MB/file)</h3>
                <div class="space-y-4">
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
                    <div class="bg-gray-50 p-4 rounded border">
                        <p class="font-bold text-sm mb-2 text-gray-800">{{ $up['desc'] }}</p>
                        <input type="file" name="{{ $up['id'] }}" class="text-sm">
                        @if($qc->{$up['id']}) <a href="{{ asset('storage/' . $qc->{$up['id']}) }}" target="_blank" class="text-blue-600 text-xs ml-4 underline">Lihat Bukti</a> @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal QC</label>
                    <input type="date" name="qc_date" value="{{ $qc->qc_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Petugas QC</label>
                    <input type="text" name="qc_officer_name" value="{{ $qc->qc_officer_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-orange-600 text-white px-6 py-3 rounded-md font-bold hover:bg-orange-700 text-lg shadow-lg">Simpan Laporan QC UAV</button>
            </div>
        </form>
    </div>
</x-app-layout>
