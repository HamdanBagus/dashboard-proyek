<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.progress.index', $project->id) }}" class="text-blue-600 hover:underline">
                Log Progress
            </a>
            <span class="text-gray-400 mx-2">/</span>
            Laporan LiDAR 📡
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2 text-indigo-700">Persentase Progress Keseluruhan</h3>

                <div class="flex flex-col md:flex-row items-center justify-between bg-indigo-50 p-6 sm:p-8 rounded-2xl border border-indigo-100 shadow-inner">
                    <div class="flex-1 mb-6 md:mb-0 md:pr-8 text-center md:text-left">
                        <h4 class="text-2xl font-extrabold text-indigo-900 mb-2">Total Laporan LiDAR</h4>
                        <p class="text-sm text-indigo-600 font-medium leading-relaxed mb-5">
                            Kalkulasi otomatis dari rata-rata progres tahapan pengolahan dan ketersediaan file output (deliverables) di seluruh area.
                        </p>
                        <div class="inline-flex items-center">
                            <span class="bg-white text-indigo-700 px-4 py-2 rounded-lg text-sm font-bold border border-indigo-200 shadow-sm flex items-center gap-2 transition hover:bg-indigo-50">
                                🗺️ Terdaftar: {{ $hamparanCount }} Hamparan
                            </span>
                        </div>
                    </div>

                    <div class="relative w-36 h-36 shrink-0 mx-auto md:mx-0">
                        <svg class="w-full h-full transform -rotate-90 drop-shadow-md" viewBox="0 0 36 36">
                            <path class="text-indigo-200" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="{{ $pctOverall == 100 ? 'text-green-500' : 'text-indigo-600' }}" 
                                  stroke-width="3" 
                                  stroke-dasharray="{{ $pctOverall }}, 100" 
                                  stroke="currentColor" 
                                  fill="none" 
                                  stroke-linecap="round" 
                                  style="transition: stroke-dasharray 1.5s ease-in-out;" 
                                  d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center flex-col">
                            <span class="text-2xl font-extrabold {{ $pctOverall == 100 ? 'text-green-600' : 'text-indigo-900' }}">
                                {{ number_format($pctOverall, 1) }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('lidar-reports.update', $report->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Informasi Tim Pengolah Data</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ $report->start_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <div class="flex gap-2 mt-1">
                                <input type="date" name="end_date" value="{{ $report->end_date }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded text-sm font-bold hover:bg-blue-700 shadow-sm transition">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-indigo-700">Daftar Hamparan (Area)</h3>

                <div class="mb-6 bg-indigo-50 p-4 rounded border border-indigo-100">
                    <form action="{{ route('lidar-hamparans.store', $report->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Nama Area / Hamparan</label>
                            <input type="text" name="name" placeholder="Contoh: Area A (Utara)" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Luas (Ha)</label>
                            <input type="number" step="0.01" name="size" placeholder="0.00" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2.5 rounded hover:bg-indigo-700 text-sm font-bold shadow-sm transition">
                            + Tambah Hamparan
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full table-auto divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Hamparan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Luas</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Progress Gabungan</th>
                                <th class="px-6 py-3 w-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($hamparans as $hamparan)
                                <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $hamparan->name }}</td>
                                <td class="px-6 py-4 text-center text-gray-600 font-medium">{{ $hamparan->size }} Ha</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2.5">
                                            <div class="{{ $hamparan->persentase_gabungan == 100 ? 'bg-green-500' : 'bg-indigo-600' }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $hamparan->persentase_gabungan }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold {{ $hamparan->persentase_gabungan == 100 ? 'text-green-600' : 'text-gray-700' }}">{{ number_format($hamparan->persentase_gabungan, 0) }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('lidar-hamparans.show', $hamparan->id) }}" class="bg-indigo-100 text-indigo-800 px-3 py-1.5 rounded text-xs font-bold hover:bg-indigo-200 border border-indigo-200 transition">
                                            Buka Detail
                                        </a>
                                        <form action="{{ route('lidar-hamparans.destroy', $hamparan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus hamparan ini beserta seluruh log di dalamnya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 font-bold border border-red-500 px-3 py-1 rounded transition">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">Belum ada hamparan yang didaftarkan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>