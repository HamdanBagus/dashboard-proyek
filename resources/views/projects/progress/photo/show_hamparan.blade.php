<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.photo.index', $project->id) }}" class="text-blue-600 hover:underline">
                Laporan Foto
            </a>
            <span class="text-gray-400 mx-2">/</span>
            Detail Hamparan: {{ $hamparan->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $hamparan->name }}</h3>
                    <p class="text-sm text-gray-500">Luas Area: {{ $hamparan->size }} Ha</p>
                </div>
                <div class="text-right">
                    <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                        Total Tahapan: {{ $hamparan->progresses->count() }}
                    </span>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-indigo-700">Log Tahapan Pengolahan</h3>

                <div class="mb-6 bg-gray-50 p-4 rounded border">
                    <form action="{{ route('photo-progress.store', $hamparan->id) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Nama Tahapan</label>
                                <input type="text" name="stage_name" list="stages" placeholder="Ketik/Pilih Tahapan..." class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                <datalist id="stages">
                                    <option value="Aerotriangulasi">
                                    <option value="Generate Dense Cloud">
                                    <option value="Build DEM/DSM">
                                    <option value="Build Orthomosaic">
                                    <option value="Export Data">
                                </datalist>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Tgl Mulai</label>
                                <input type="date" name="start_date" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Tgl Selesai</label>
                                <input type="date" name="end_date" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Status</label>
                                <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                    <option value="Proses">Sedang Proses ⏳</option>
                                    <option value="Selesai">Selesai ✅</option>
                                    <option value="Gagal">Gagal / Error ❌</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Nama Pengolah</label>
                                <select name="processor_name" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                    <option value="">-- Pilih Pengolah Data --</option>
                                    @foreach($pengolahData as $pengolah)
                                        <option value="{{ $pengolah->name }}">{{ $pengolah->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500">PC Pengolahan</label>
                                <select name="pc_name" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                    <option value="">-- Pilih PC --</option>
                                    @foreach($pcs as $pc)
                                        <option value="{{ $pc->name }}">{{ $pc->name }} ({{ $pc->spec }})</option>
                                    @endforeach
                                    <option value="Laptop Pribadi">Laptop Pribadi</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500">Catatan</label>
                                <input type="text" name="notes" placeholder="Catatan tambahan..." class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm font-bold">
                                + Tambah Log Tahapan
                            </button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahapan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Oleh / PC</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($hamparan->progresses as $prog)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ $prog->stage_name }}
                                    <div class="text-xs font-normal text-gray-500">{{ $prog->notes }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Start: {{ $prog->start_date ?? '-' }}<br>
                                    End: {{ $prog->end_date ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    👤 {{ $prog->processor_name ?? '-' }}<br>
                                    🖥️ {{ $prog->pc_name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $prog->status == 'Selesai' ? 'bg-green-100 text-green-800' :
                                          ($prog->status == 'Gagal' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $prog->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('photo-progress.destroy', $prog->id) }}" method="POST" onsubmit="return confirm('Hapus log tahapan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-bold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">Belum ada tahapan yang dicatat.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
