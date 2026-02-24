<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.progress.index', $project->id) }}" class="text-blue-600 hover:underline">
                Log Progress
            </a>
            <span class="text-gray-400 mx-2">/</span>
            Laporan Foto Udara 📸
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
                <form action="{{ route('photo-reports.update', $report->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Tim Pengolah Data</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ $report->start_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <div class="flex gap-2">
                                <input type="date" name="end_date" value="{{ $report->end_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-indigo-700">Daftar Hamparan (Area)</h3>

                <div class="mb-6 bg-indigo-50 p-4 rounded border border-indigo-100">
                    <form action="{{ route('photo-hamparans.store', $report->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Nama Area / Hamparan</label>
                            <input type="text" name="name" placeholder="Contoh: Area A (Utara)" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Luas (Ha)</label>
                            <input type="number" step="0.01" name="size" placeholder="0.00" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm font-bold">
                            + Tambah Hamparan
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Hamparan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Luas</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($hamparans as $hamparan)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $hamparan->name }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $hamparan->size }} Ha</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('photo-hamparans.show', $hamparan->id) }}" class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold hover:bg-green-200">
                                            Buka Detail Progress
                                        </a>

                                        <form action="{{ route('photo-hamparans.destroy', $hamparan->id) }}" method="POST" onsubmit="return confirm('Hapus hamparan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-xs">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500 italic">Belum ada hamparan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-green-700">Output Produk (Deliverables)</h3>

                <div class="mb-6 bg-green-50 p-4 rounded border border-green-100">
                    <form action="{{ route('photo-outputs.store', $report->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        @csrf
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-500">Jenis Output</label>
                            <select name="filename" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                <option value="Orthophoto">Orthophoto</option>
                                <option value="DSM">DSM</option>
                                <option value="DTM">DTM</option>
                                <option value="Point Cloud">Point Cloud</option>
                                <option value="Tiling">Tiling</option>
                                <option value="Laporan">Laporan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Format</label>
                            <select name="format" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                <option value="TIF">TIF</option>
                                <option value="ECW">ECW</option>
                                <option value="LAS">LAS</option>
                                <option value="PDF">PDF</option>
                                <option value="SHP">SHP</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Checklist</label>
                            <select name="checklist" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                <option value="0">Belum Ada</option>
                                <option value="1">Sudah Ada</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm font-bold">
                            + Tambah
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis / Nama File</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Format</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Ketersediaan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($outputs as $out)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $out->filename }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $out->format }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($out->checklist)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-bold">✅ Tersedia</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded-full text-xs">❌ Belum</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('photo-outputs.destroy', $out->id) }}" method="POST" onsubmit="return confirm('Hapus output ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500 italic">Belum ada output yang didaftarkan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
