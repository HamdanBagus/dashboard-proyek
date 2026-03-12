<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.progress.index', $report->project_id) }}" class="text-blue-600 hover:underline">
                Log Progress
            </a>
            <span class="text-gray-400 mx-2">/</span>
            Laporan Tim Ground 🌍
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-lg font-bold text-gray-800">Informasi Pelaksanaan & Statistik Titik</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                    
                    <form action="{{ route('ground-reports.update', $report->id) }}" method="POST" class="bg-indigo-50 p-5 rounded-xl border border-indigo-100 shadow-sm h-full flex flex-col justify-between">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-indigo-700 uppercase tracking-wider mb-1">Koordinator Tim Ground</label>
                                <select name="coordinator_name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-semibold text-gray-700">
                                    <option value="">-- Pilih Koordinator --</option>
                                    @foreach($project->personnel as $personil)
                                        <option value="{{ $personil->name }}" {{ $report->coordinator_name == $personil->name ? 'selected' : '' }}>
                                            {{ $personil->name }} ({{ $personil->pivot->role }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-indigo-700 uppercase tracking-wider mb-1">Tgl Mulai</label>
                                    <input type="date" name="start_date" value="{{ $report->start_date }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-indigo-700 uppercase tracking-wider mb-1">Tgl Selesai</label>
                                    <input type="date" name="end_date" value="{{ $report->end_date }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2.5 rounded-lg hover:bg-indigo-700 text-sm font-bold shadow transition mt-auto">
                            Simpan Informasi
                        </button>
                    </form>

                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 h-full flex flex-col justify-center">
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 text-center">
                            <div class="bg-white py-4 px-2 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                                <span class="block text-xs text-gray-500 font-extrabold mb-1">BM</span>
                                <span class="text-2xl font-black text-gray-800">{{ $report->count_bm }}</span>
                            </div>
                            <div class="bg-white py-4 px-2 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                                <span class="block text-xs text-gray-500 font-extrabold mb-1">ICP</span>
                                <span class="text-2xl font-black text-gray-800">{{ $report->count_icp }}</span>
                            </div>
                            <div class="bg-white py-4 px-2 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                                <span class="block text-xs text-gray-500 font-extrabold mb-1">GCP</span>
                                <span class="text-2xl font-black text-gray-800">{{ $report->count_gcp }}</span>
                            </div>
                            <div class="bg-indigo-600 py-4 px-2 rounded-lg shadow-md border border-indigo-700 transform hover:scale-105 transition">
                                <span class="block text-xs text-indigo-200 font-black uppercase tracking-wider mb-1">Total</span>
                                <span class="text-2xl font-black text-white">{{ $report->total_titik }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2 text-indigo-700">Persentase Progress Pekerjaan</h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                    <div class="md:col-span-1 bg-indigo-50 p-6 rounded-lg border border-indigo-200 text-center flex flex-col justify-center h-full shadow-sm">
                        <span class="block text-sm font-bold text-indigo-700 uppercase tracking-wider mb-2">Overall Progress</span>
                        <span class="text-5xl font-extrabold text-indigo-900">{{ number_format($report->overall_progress, 1) }}<span class="text-2xl">%</span></span>
                    </div>

                    <div class="md:col-span-3 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-bold text-gray-700">Pemasangan</span>
                                <span class="text-lg font-bold text-blue-600">
                                    {{ number_format($report->total_titik > 0 ? ($report->installed_count / $report->total_titik) * 100 : 0, 1) }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ min($report->total_titik > 0 ? ($report->installed_count / $report->total_titik) * 100 : 0, 100) }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 font-medium">{{ $report->installed_count }} dari {{ $report->total_titik }} Titik Selesai</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-bold text-gray-700">Pengukuran</span>
                                <span class="text-lg font-bold text-teal-600">
                                    {{ number_format($report->total_titik > 0 ? ($report->measured_count / $report->total_titik) * 100 : 0, 1) }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-teal-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ min($report->total_titik > 0 ? ($report->measured_count / $report->total_titik) * 100 : 0, 100) }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 font-medium">{{ $report->measured_count }} dari {{ $report->total_titik }} Titik Selesai</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-bold text-gray-700">Pengolahan</span>
                                <span class="text-lg font-bold text-purple-600">
                                    {{ number_format($report->total_titik > 0 ? ($report->processed_count / $report->total_titik) * 100 : 0, 1) }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-purple-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ min($report->total_titik > 0 ? ($report->processed_count / $report->total_titik) * 100 : 0, 100) }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 font-medium">{{ $report->processed_count }} dari {{ $report->total_titik }} Titik Selesai</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-indigo-700">Monitoring Titik & Performa Lapangan</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white border border-gray-200 p-4 rounded-xl flex items-center gap-4 shadow-sm hover:shadow transition">
                        <div class="bg-indigo-100 p-3 rounded-lg text-indigo-700 text-xl">👷‍♂️</div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah Surveyor</p>
                            <p class="text-2xl font-black text-indigo-900">{{ $performaData['jumlah_surveyor'] }} <span class="text-sm font-medium text-gray-500">Orang</span></p>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-200 p-4 rounded-xl flex items-center gap-4 shadow-sm hover:shadow transition">
                        <div class="bg-blue-100 p-3 rounded-lg text-blue-700 text-xl">⏱️</div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Hari Kerja Eksekusi</p>
                            <p class="text-2xl font-black text-blue-900">{{ $performaData['jumlah_hari'] }} <span class="text-sm font-medium text-gray-500">Hari</span></p>
                        </div>
                    </div>
                    <div class="bg-green-50 border border-green-200 p-4 rounded-xl flex items-center gap-4 shadow-sm hover:shadow transition">
                        <div class="bg-green-200 p-3 rounded-lg text-green-800 text-xl">📈</div>
                        <div>
                            <p class="text-xs font-bold text-green-700 uppercase tracking-wider">Performa Rata-rata</p>
                            <p class="text-2xl font-black text-green-900">{{ number_format($performaData['performa_harian'], 1) }} <span class="text-xs font-bold text-green-700">Titik / Org / Hari</span></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-0">
                    <div class="mb-6 bg-gray-50 p-4 rounded border">
                        <h3 class="font-bold text-sm mb-2">Tambah Titik Baru</h3>
                        <form action="{{ route('ground-points.store', $report->id) }}" method="POST" class="flex gap-4 items-end">
                            @csrf
                            <div class="w-1/3">
                                <label class="block text-xs text-gray-500 font-bold mb-1">Nama Titik</label>
                                <input type="text" name="name" placeholder="Contoh: BM-01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                            <div class="w-1/3">
                                <label class="block text-xs text-gray-500 font-bold mb-1">Jenis Titik</label>
                                <select name="point_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="BM">BM (Benchmark)</option>
                                    <option value="ICP">ICP (Independent Check Point)</option>
                                    <option value="GCP">GCP (Ground Control Point)</option>
                                </select>
                            </div>
                            <div class="w-1/3">
                                <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm font-bold shadow transition">
                                    + Tambah Titik
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Detail Titik</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Pemasangan</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Pengukuran</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Pengolahan</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($report->points as $point)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-gray-900 text-lg">{{ $point->name }}</div>
                                        <div class="text-xs font-semibold text-indigo-600 bg-indigo-50 inline-block px-2 py-1 rounded border border-indigo-200 mt-1">Jenis: {{ $point->point_type }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($point->install_status)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                            <div class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($point->install_date)->format('d/m/Y') }}</div>
                                            @if($point->install_surveyor)
                                                <div class="text-xs font-semibold text-indigo-600 mt-1">👤 {{ $point->install_surveyor }}</div>
                                            @endif
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Belum</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($point->measure_status)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                            <div class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($point->measure_date)->format('d/m/Y') }}</div>
                                            @if($point->measure_surveyor)
                                                <div class="text-xs font-semibold text-blue-600 mt-1">👤 {{ $point->measure_surveyor }}</div>
                                            @endif
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Belum</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($point->process_status)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                            <div class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($point->process_date)->format('d/m/Y') }}</div>
                                            @if($point->process_surveyor)
                                                <div class="text-xs font-semibold text-green-600 mt-1">👤 {{ $point->process_surveyor }}</div>
                                            @endif
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Belum</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('ground-points.edit', $point->id) }}" class="text-indigo-600 hover:text-white hover:bg-indigo-600 font-bold border border-indigo-600 px-3 py-1 rounded transition">
                                                Update
                                            </a>

                                            <form action="{{ route('ground-points.destroy', $point->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus titik ini? Jumlah pada statistik akan otomatis berkurang.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 font-bold border border-red-500 px-3 py-1 rounded transition ml-1">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">
                                        Belum ada titik yang ditambahkan. Silakan tambah titik melalui form di atas.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>