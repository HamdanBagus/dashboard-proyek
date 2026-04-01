<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('projects.progress.index', $report->project_id) }}" class="text-[#F8931F] hover:underline transition">
                    Log Progress
                </a>
                <span class="text-gray-400 mx-2">/</span>
                Laporan Tim Ground 
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
                    Informasi Pelaksanaan & Statistik Titik
                </h3>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                
                <form action="{{ route('ground-reports.update', $report->id) }}" method="POST" class="bg-[#F4F7F6] p-6 rounded-xl border border-[#144C4D]/20 shadow-inner h-full flex flex-col justify-between">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 gap-5 mb-4">
                        <div>
                            <label class="block text-[10px] font-bold text-[#144C4D] uppercase tracking-widest mb-1.5">Koordinator Tim Ground</label>
                            <div class="block w-full border border-gray-300 bg-white rounded-lg shadow-sm sm:text-sm font-bold text-gray-700 px-4 py-2.5 cursor-not-allowed flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span>{{ $project->personnel->where('pivot.role', 'Koordinator Tim Ground')->first()->name ?? '-- Belum Diatur di Personil Proyek --' }}</span>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-1.5 italic">*Diatur melalui menu Manajemen Personil di Detail Proyek</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-[#144C4D] uppercase tracking-widest mb-1.5">Tgl Mulai</label>
                                <input type="date" name="start_date" value="{{ $report->start_date }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#144C4D] focus:border-[#144C4D] sm:text-sm font-medium">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-[#144C4D] uppercase tracking-widest mb-1.5">Tgl Selesai</label>
                                <input type="date" name="end_date" value="{{ $report->end_date }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#144C4D] focus:border-[#144C4D] sm:text-sm font-medium">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#144C4D] text-white px-4 py-3 rounded-lg hover:bg-[#0c2e2e] text-sm font-bold shadow-md transition mt-auto flex justify-center items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Informasi Pelaksanaan
                    </button>
                </form>

                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 h-full flex flex-col justify-center">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                        <div class="bg-white py-5 px-2 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">BM</span>
                            <span class="text-3xl font-black text-gray-800">{{ $report->count_bm }}</span>
                        </div>
                        <div class="bg-white py-5 px-2 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">ICP</span>
                            <span class="text-3xl font-black text-gray-800">{{ $report->count_icp }}</span>
                        </div>
                        <div class="bg-white py-5 px-2 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">GCP</span>
                            <span class="text-3xl font-black text-gray-800">{{ $report->count_gcp }}</span>
                        </div>
                        <div class="bg-[#F8931F] py-5 px-2 rounded-xl shadow-md border border-[#df8218] transform hover:-translate-y-1 transition">
                            <span class="block text-[10px] text-[#ffe0bc] font-black uppercase tracking-widest mb-1">Total Titik</span>
                            <span class="text-3xl font-black text-white">{{ $report->total_titik }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-black mb-6 border-b border-gray-100 pb-2 text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Persentase Progress Pekerjaan
            </h3>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-center">
                <div class="lg:col-span-1 bg-[#E8F1F1] p-6 rounded-xl border border-[#144C4D]/20 text-center flex flex-col justify-center h-full shadow-sm">
                    <span class="block text-xs font-black text-[#144C4D] uppercase tracking-widest mb-2">Overall Progress</span>
                    <span class="text-5xl font-black text-[#144C4D]">{{ number_format($report->overall_progress, 1) }}<span class="text-2xl">%</span></span>
                </div>

                <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between items-end mb-2.5">
                            <span class="text-sm font-black text-gray-700">Pemasangan</span>
                            <span class="text-lg font-black text-[#F8931F]">
                                {{ number_format($report->total_titik > 0 ? ($report->installed_count / $report->total_titik) * 100 : 0, 1) }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-[#F8931F] h-2 rounded-full transition-all duration-500" style="width: {{ min($report->total_titik > 0 ? ($report->installed_count / $report->total_titik) * 100 : 0, 100) }}%"></div>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-2.5 font-bold uppercase tracking-widest">{{ $report->installed_count }} dari {{ $report->total_titik }} Selesai</p>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between items-end mb-2.5">
                            <span class="text-sm font-black text-gray-700">Pengukuran</span>
                            <span class="text-lg font-black text-[#144C4D]">
                                {{ number_format($report->total_titik > 0 ? ($report->measured_count / $report->total_titik) * 100 : 0, 1) }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-[#144C4D] h-2 rounded-full transition-all duration-500" style="width: {{ min($report->total_titik > 0 ? ($report->measured_count / $report->total_titik) * 100 : 0, 100) }}%"></div>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-2.5 font-bold uppercase tracking-widest">{{ $report->measured_count }} dari {{ $report->total_titik }} Selesai</p>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between items-end mb-2.5">
                            <span class="text-sm font-black text-gray-700">Pengolahan</span>
                            <span class="text-lg font-black text-green-600">
                                {{ number_format($report->total_titik > 0 ? ($report->processed_count / $report->total_titik) * 100 : 0, 1) }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full transition-all duration-500" style="width: {{ min($report->total_titik > 0 ? ($report->processed_count / $report->total_titik) * 100 : 0, 100) }}%"></div>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-2.5 font-bold uppercase tracking-widest">{{ $report->processed_count }} dari {{ $report->total_titik }} Selesai</p>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="text-lg font-black text-gray-800 mb-4 mt-8 flex items-center gap-2">
            <svg class="w-5 h-5 text-[#F8931F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            Monitoring Titik & Performa Lapangan
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            <div class="bg-white border border-gray-200 p-5 rounded-xl flex items-center gap-4 shadow-sm hover:shadow-md transition">
                <div class="bg-[#E8F1F1] p-3.5 rounded-lg text-[#144C4D]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Jumlah Surveyor</p>
                    <p class="text-2xl font-black text-gray-800">{{ $performaData['jumlah_surveyor'] }} <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Orang</span></p>
                </div>
            </div>
            <div class="bg-white border border-gray-200 p-5 rounded-xl flex items-center gap-4 shadow-sm hover:shadow-md transition">
                <div class="bg-orange-50 p-3.5 rounded-lg text-[#F8931F]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Hari Kerja Eksekusi</p>
                    <p class="text-2xl font-black text-gray-800">{{ $performaData['jumlah_hari'] }} <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Hari</span></p>
                </div>
            </div>
            <div class="bg-green-50 border border-green-200 p-5 rounded-xl flex items-center gap-4 shadow-sm hover:shadow-md transition">
                <div class="bg-green-200 p-3.5 rounded-lg text-green-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-green-700 uppercase tracking-widest mb-0.5">Performa Rata-rata</p>
                    <p class="text-2xl font-black text-green-900">{{ number_format($performaData['performa_harian'], 1) }} <span class="text-[10px] font-bold text-green-700 uppercase tracking-widest">Titik / Org / Hari</span></p>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            
            <div class="bg-gray-50 p-5 border-b border-gray-200">
                <h3 class="font-black text-gray-800 text-sm mb-3">Tambah Titik Baru</h3>
                <form action="{{ route('ground-points.store', $report->id) }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-end">
                    @csrf
                    <div class="w-full sm:w-1/3">
                        <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Nama Titik</label>
                        <input type="text" name="name" placeholder="Contoh: BM-01" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                    </div>
                    <div class="w-full sm:w-1/3">
                        <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Jenis Titik</label>
                        <select name="point_type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                            <option value="BM">BM (Benchmark)</option>
                            <option value="ICP">ICP (Independent Check Point)</option>
                            <option value="GCP">GCP (Ground Control Point)</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-1/3">
                        <button type="submit" class="w-full bg-[#144C4D] text-white px-4 py-2.5 rounded-lg hover:bg-[#0c2e2e] text-sm font-bold shadow-sm transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Tambah Titik
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Detail Titik</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Pemasangan</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Pengukuran</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Pengolahan</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($report->points as $point)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-black text-gray-900 text-lg">{{ $point->name }}</div>
                                <div class="text-[10px] font-bold text-gray-600 bg-gray-100 uppercase tracking-widest inline-block px-2.5 py-1 rounded-md border border-gray-200 mt-1.5">{{ $point->point_type }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($point->install_status)
                                    <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase tracking-widest rounded-md bg-green-50 text-green-700 border border-green-200">Selesai</span>
                                    <div class="text-xs font-bold text-gray-500 mt-2">{{ \Carbon\Carbon::parse($point->install_date)->format('d/m/Y') }}</div>
                                    @if($point->install_surveyor)
                                        <div class="text-[10px] font-bold text-[#144C4D] mt-1 uppercase tracking-widest flex items-center justify-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> {{ $point->install_surveyor }}</div>
                                    @endif
                                @else
                                    <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase tracking-widest rounded-md bg-gray-100 text-gray-400 border border-gray-200">Belum</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($point->measure_status)
                                    <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase tracking-widest rounded-md bg-green-50 text-green-700 border border-green-200">Selesai</span>
                                    <div class="text-xs font-bold text-gray-500 mt-2">{{ \Carbon\Carbon::parse($point->measure_date)->format('d/m/Y') }}</div>
                                    @if($point->measure_surveyor)
                                        <div class="text-[10px] font-bold text-[#144C4D] mt-1 uppercase tracking-widest flex items-center justify-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> {{ $point->measure_surveyor }}</div>
                                    @endif
                                @else
                                    <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase tracking-widest rounded-md bg-gray-100 text-gray-400 border border-gray-200">Belum</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($point->process_status)
                                    <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase tracking-widest rounded-md bg-green-50 text-green-700 border border-green-200">Selesai</span>
                                    <div class="text-xs font-bold text-gray-500 mt-2">{{ \Carbon\Carbon::parse($point->process_date)->format('d/m/Y') }}</div>
                                    @if($point->process_surveyor)
                                        <div class="text-[10px] font-bold text-[#144C4D] mt-1 uppercase tracking-widest flex items-center justify-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> {{ $point->process_surveyor }}</div>
                                    @endif
                                @else
                                    <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase tracking-widest rounded-md bg-gray-100 text-gray-400 border border-gray-200">Belum</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('ground-points.edit', $point->id) }}" class="text-[#F8931F] hover:text-white hover:bg-[#F8931F] border border-[#F8931F] p-1.5 rounded-md transition" title="Update">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('ground-points.destroy', $point->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus titik ini? Jumlah pada statistik akan otomatis berkurang.');" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 border border-red-500 p-1.5 rounded-md transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Belum ada titik yang ditambahkan. Silakan tambah titik baru melalui form di atas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>