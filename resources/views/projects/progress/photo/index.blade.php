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
                                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded text-sm font-bold hover:bg-blue-700 transition">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-bold mb-4 text-indigo-700">Daftar Hamparan (Area)</h3>
            <div class="mb-6 bg-indigo-50 p-4 rounded border border-indigo-100">
                <form action="{{ route('photo-hamparans.store', $report->id) }}"
                    method="POST"
                    class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">
                            Nama Area / Hamparan
                        </label>
                        <input type="text"
                            name="name"
                            placeholder="Contoh: Area A (Utara)"
                            class="block w-full rounded-md border-gray-300 shadow-sm
                                    focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">
                            Luas (Ha)
                        </label>
                        <input type="number"
                            step="0.01"
                            name="size"
                            placeholder="0.00"
                            class="block w-full rounded-md border-gray-300 shadow-sm
                                    focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                    </div>
                    <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2.5 rounded
                                hover:bg-indigo-700 text-sm font-bold shadow-sm transition">
                        + Tambah Hamparan
                    </button>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full table-auto divide-y divide-gray-200 border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium
                                    text-gray-500 uppercase tracking-wider">
                                Nama Hamparan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium
                                    text-gray-500 uppercase tracking-wider">
                                Luas
                            </th>
                            <th class="px-6 py-3 w-1 text-center text-xs font-medium
                                    text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($hamparans as $hamparan)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ $hamparan->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 font-medium">
                                {{ $hamparan->size }} Ha
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('photo-hamparans.show', $hamparan->id) }}"
                                    class="bg-indigo-100 text-indigo-800 px-3 py-1.5
                                            rounded text-xs font-bold
                                            hover:bg-indigo-200 border border-indigo-200 transition">
                                        Buka Detail Progress
                                    </a>
                                    <form action="{{ route('photo-hamparans.destroy', $hamparan->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus hamparan ini beserta seluruh log progress di dalamnya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-white
                                                hover:bg-red-500 font-bold
                                                border border-red-500
                                                px-3 py-1 rounded transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3"
                                class="px-6 py-8 text-center text-gray-500 italic">
                                Belum ada hamparan yang didaftarkan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-green-700">Output Produk (Deliverables)</h3>

                <div class="mb-6 bg-green-50 p-4 rounded border border-green-200">
                    <form action="{{ route('photo-outputs.store', $report->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        @csrf
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-600 mb-1">Jenis Output / Nama File</label>
                            <input type="text" name="filename" list="jenis_output" placeholder="Pilih atau ketik baru..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm" required>
                            <datalist id="jenis_output">
                                <option value="Orthophoto">
                                <option value="DSM">
                                <option value="DTM">
                                <option value="Point Cloud">
                                <option value="Tiling">
                                <option value="Laporan">
                            </datalist>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Format File</label>
                            <input type="text" name="format" list="format_file" placeholder="Pilih/Ketik..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm" required>
                            <datalist id="format_file">
                                <option value="TIF">
                                <option value="ECW">
                                <option value="LAS">
                                <option value="LAZ">
                                <option value="PDF">
                                <option value="SHP">
                            </datalist>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Ketersediaan</label>
                            <select name="checklist" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                <option value="0">❌ Belum Ada</option>
                                <option value="1">✅ Sudah Ada</option>
                            </select>
                        </div>

                        <button type="submit" class="bg-green-600 text-white px-4 py-2.5 rounded hover:bg-green-700 text-sm font-bold shadow-sm transition">
                            + Tambah Output
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis / Nama File</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Format</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ketersediaan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($outputs as $out)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $out->filename }}</td>
                                <td class="px-6 py-4 text-gray-600 font-medium">{{ $out->format }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($out->checklist)
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold border border-green-200">✅ Tersedia</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold border border-gray-200">❌ Belum</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('photo-outputs.destroy', $out->id) }}" method="POST" onsubmit="return confirm('Hapus output ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 font-bold border border-red-500 px-3 py-1 rounded transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">Belum ada output yang didaftarkan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
