<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.progress.index', $project->id) }}" class="text-blue-600 hover:underline">
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
                <form action="{{ route('ground-reports.update', $report->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <h3 class="text-lg font-bold mb-4">Waktu Pelaksanaan</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tgl Mulai</label>
                                    <input type="date" name="start_date" value="{{ $report->start_date }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tgl Selesai</label>
                                    <input type="date" name="end_date" value="{{ $report->end_date }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-4">Target Jumlah Titik</h3>
                            <div class="grid grid-cols-4 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">BM</label>
                                    <input type="number" name="bm_count" value="{{ $report->bm_count }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">ICP</label>
                                    <input type="number" name="icp_count" value="{{ $report->icp_count }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">GCP</label>
                                    <input type="number" name="gcp_count" value="{{ $report->gcp_count }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Lainnya</label>
                                    <input type="number" name="other_count" value="{{ $report->other_count }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">
                            Simpan Perubahan Header
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-6 bg-gray-50 p-4 rounded border">
                    <h3 class="font-bold text-sm mb-2">Tambah Titik Baru</h3>
                    <form action="{{ route('ground-points.store', $report->id) }}" method="POST" class="flex gap-4">
                        @csrf
                        <input type="text" name="name" placeholder="Nama Titik (Contoh: BM-01)" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">
                            + Tambah
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Titik</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Pemasangan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Pengukuran</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Pengolahan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($report->points as $point)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    {{ $point->name }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($point->install_status)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                        <div class="text-xs text-gray-500 mt-1">{{ $point->install_date }}</div>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Belum</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($point->measure_status)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                        <div class="text-xs text-gray-500 mt-1">{{ $point->measure_date }}</div>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Belum</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($point->process_status)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                        <div class="text-xs text-gray-500 mt-1">{{ $point->process_date }}</div>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Belum</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('ground-points.edit', $point->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold border border-indigo-600 px-2 py-1 rounded">
                                            Update Progress
                                        </a>

                                        <form action="{{ route('ground-points.destroy', $point->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus titik ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">
                                    Belum ada titik yang ditambahkan. Silakan tambah titik di atas.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
