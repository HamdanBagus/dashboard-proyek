<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.lidar.index', $project->id) }}" class="text-blue-600 hover:underline">
                Laporan Lidar
            </a>
            <span class="text-gray-400 mx-2">/</span>
            Detail Hamparan: {{ $hamparan->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $totalTahapan = $hamparan->progresses->count();
                $tahapanSelesai = $hamparan->progresses->where('status', 'Selesai')->count();
                $persentase = $totalTahapan > 0 ? ($tahapanSelesai / $totalTahapan) * 100 : 0;
            @endphp

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-1">{{ $hamparan->name }}</h3>
                    <p class="text-sm text-gray-500 font-medium mb-4">Luas Area: <span class="text-gray-800 font-bold">{{ $hamparan->size }} Ha</span></p>

                    <div class="flex gap-2">
                        <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-3 py-1 rounded border border-indigo-200">
                            Total: {{ $totalTahapan }} Tahapan
                        </span>
                        <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded border border-green-200">
                            Selesai: {{ $tahapanSelesai }} Tahapan
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Progress</p>
                        <p class="text-sm font-medium text-gray-800">Penyelesaian Area</p>
                    </div>

                    <div class="relative w-20 h-20">
                        <svg class="w-full h-full transform -rotate-90 drop-shadow-sm" viewBox="0 0 36 36">
                            <path class="text-gray-200" stroke-width="3.5" stroke="currentColor" fill="none"
                                  d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="{{ $persentase == 100 ? 'text-green-500' : 'text-indigo-600' }}"
                                  stroke-width="3.5"
                                  stroke-dasharray="{{ $persentase }}, 100"
                                  stroke="currentColor"
                                  fill="none"
                                  stroke-linecap="round"
                                  style="transition: stroke-dasharray 1s ease-in-out;"
                                  d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-sm font-extrabold {{ $persentase == 100 ? 'text-green-600' : 'text-gray-800' }}">
                                {{ number_format($persentase, 0) }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-indigo-700">Log Tahapan Pengolahan</h3>

                <div class="mb-6 bg-gray-50 p-4 rounded border border-gray-200">
                    <form action="{{ route('lidar-progress.store', $hamparan->id) }}" method="POST" class="flex gap-4 items-end">
                        @csrf
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-600 mb-1">Target Tahapan Pengolahan</label>
                            <input type="text" name="stage_name" list="stages" placeholder="Ketik atau pilih tahapan..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            <datalist id="stages">
                                <option value="Klasifikasi Ground">
                                <option value="Generate DTM">
                                <option value="Generate Kontur">
                                <option value="Checking Quality">
                            </datalist>

                            <input type="hidden" name="status" value="Proses">
                        </div>
                        <div>
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 text-sm font-bold shadow-sm transition">
                                + Daftarkan Tahapan
                            </button>
                        </div>
                    </form>
                </div>

                <div x-data="{ openUpdateModal: false, selectedProgress: null }" class="overflow-x-auto relative">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahapan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Oleh / PC</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($hamparan->progresses as $prog)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ $prog->stage_name }}
                                    <div class="text-xs font-normal text-gray-500 mt-1">{{ $prog->notes }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="font-semibold text-gray-700">Mulai:</span> {{ $prog->start_date ?? '-' }}<br>
                                    <span class="font-semibold text-gray-700">Selesai:</span> {{ $prog->end_date ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    👤 <span class="font-bold text-gray-700">{{ $prog->processor_name ?? '-' }}</span><br>
                                    🖥️ {{ $prog->pc_name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border
                                        {{ $prog->status == 'Selesai' ? 'bg-green-100 text-green-800 border-green-200' :
                                          ($prog->status == 'Gagal' ? 'bg-red-100 text-red-800 border-red-200' : 'bg-yellow-100 text-yellow-800 border-yellow-200') }}">
                                        {{ $prog->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <button type="button"
                                                @click="selectedProgress = {{ json_encode($prog) }}; openUpdateModal = true"
                                                class="text-indigo-600 hover:text-white hover:bg-indigo-600 font-bold border border-indigo-600 px-3 py-1 rounded transition text-xs">
                                            Update
                                        </button>

                                        <form action="{{ route('lidar-progress.destroy', $prog->id) }}" method="POST" onsubmit="return confirm('Hapus log tahapan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 font-bold border border-red-500 px-3 py-1 rounded transition text-xs">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">Belum ada target tahapan yang didaftarkan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div x-show="openUpdateModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                            <div x-show="openUpdateModal" @click="openUpdateModal = false" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="openUpdateModal" x-transition class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">

                                <form :action="'/lidar-progress/' + selectedProgress?.id" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-xl leading-6 font-bold text-gray-900 mb-4 border-b pb-2">
                                            Update Tahapan: <span class="text-indigo-600" x-text="selectedProgress?.stage_name"></span>
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div class="md:col-span-2">
                                                <label class="block text-xs font-bold text-gray-600 mb-1">Nama Tahapan</label>
                                                <input type="text" name="stage_name" :value="selectedProgress?.stage_name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" required>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-bold text-gray-600 mb-1">Tgl Mulai</label>
                                                <input type="date" name="start_date" :value="selectedProgress?.start_date" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm">
                                            </div>

                                            <div>
                                                <label class="block text-xs font-bold text-gray-600 mb-1">Tgl Selesai</label>
                                                <input type="date" name="end_date" :value="selectedProgress?.end_date" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm">
                                            </div>

                                            <div>
                                                <label class="block text-xs font-bold text-gray-600 mb-1">Nama Pengolah</label>
                                                <select name="processor_name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" :value="selectedProgress?.processor_name">
                                                    <option value="">-- Pilih Pengolah Data --</option>
                                                    @foreach($pengolahData as $pengolah)
                                                        <option value="{{ $pengolah->name }}">{{ $pengolah->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-bold text-gray-600 mb-1">PC Pengolahan</label>
                                                <select name="pc_name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" :value="selectedProgress?.pc_name">
                                                    <option value="">-- Pilih PC --</option>
                                                    @foreach($pcs as $pc)
                                                        <option value="{{ $pc->name }}">{{ $pc->name }} ({{ $pc->spec }})</option>
                                                    @endforeach
                                                    <option value="Laptop Pribadi">Laptop Pribadi</option>
                                                </select>
                                            </div>

                                            <div class="md:col-span-2">
                                                <label class="block text-xs font-bold text-gray-600 mb-1">Catatan Tambahan</label>
                                                <input type="text" name="notes" :value="selectedProgress?.notes" placeholder="Catatan singkat..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm">
                                            </div>

                                            <div class="md:col-span-2 mt-2 p-3 bg-gray-50 border rounded flex justify-between items-center">
                                                <label class="block text-sm font-bold text-gray-700">Status Pekerjaan</label>
                                                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm font-bold" :value="selectedProgress?.status">
                                                    <option value="Proses">Sedang Proses ⏳</option>
                                                    <option value="Selesai">Selesai ✅</option>
                                                    <option value="Gagal">Gagal / Error ❌</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-bold text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">
                                            Simpan Progress
                                        </button>
                                        <button type="button" @click="openUpdateModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-gray-700 hover:bg-gray-100 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
