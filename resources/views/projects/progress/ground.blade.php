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

            @php
                // Menghitung jumlah masing-masing titik secara real-time
                $countBM = $report->points->where('point_type', 'BM')->count();
                $countICP = $report->points->where('point_type', 'ICP')->count();
                $countGCP = $report->points->where('point_type', 'GCP')->count();
                $totalTitik = $report->points->count();
            @endphp

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-lg font-bold text-gray-800">Informasi Pelaksanaan & Statistik Titik</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <form action="{{ route('ground-reports.update', $report->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tgl Mulai Ground</label>
                                <input type="date" name="start_date" value="{{ $report->start_date }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tgl Selesai Ground</label>
                                <input type="date" name="end_date" value="{{ $report->end_date }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm font-bold">
                            Simpan Tanggal
                        </button>
                    </form>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="grid grid-cols-4 gap-2 text-center">
                            <div class="bg-white p-2 rounded shadow-sm border border-gray-200">
                                <span class="block text-xs text-gray-500 font-bold">BM</span>
                                <span class="text-xl font-bold text-gray-800">{{ $countBM }}</span>
                            </div>
                            <div class="bg-white p-2 rounded shadow-sm border border-gray-200">
                                <span class="block text-xs text-gray-500 font-bold">ICP</span>
                                <span class="text-xl font-bold text-gray-800">{{ $countICP }}</span>
                            </div>
                            <div class="bg-white p-2 rounded shadow-sm border border-gray-200">
                                <span class="block text-xs text-gray-500 font-bold">GCP</span>
                                <span class="text-xl font-bold text-gray-800">{{ $countGCP }}</span>
                            </div>
                            <div class="bg-indigo-50 p-2 rounded shadow-sm border border-indigo-200">
                                <span class="block text-xs text-indigo-600 font-bold uppercase tracking-wider">Total</span>
                                <span class="text-xl font-bold text-indigo-900">{{ $totalTitik }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Tabel Monitoring Titik</h3>
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
                                <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm font-bold">
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
                                            <div class="text-xs text-gray-500 mt-1">{{ $point->install_date }}</div>
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
                                            <div class="text-xs text-gray-500 mt-1">{{ $point->measure_date }}</div>
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
                                            <div class="text-xs text-gray-500 mt-1">{{ $point->process_date }}</div>
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
