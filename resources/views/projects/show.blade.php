<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }} <span class="text-sm text-gray-500">({{ $project->code }})</span>
            </h2>
            <span class="px-3 py-1 text-sm rounded-full
                {{ $project->status == 'finished' ? 'bg-green-200 text-green-800' :
                  ($project->status == 'ongoing' ? 'bg-yellow-200 text-yellow-800' : 'bg-gray-200 text-gray-800') }}">
                {{ ucfirst($project->status) }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('projects.progress.index', $project->id) }}" class="block p-6 bg-blue-600 border border-blue-600 rounded-lg shadow hover:bg-blue-700 transition">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">Log Progress 📊</h5>
                    <p class="font-normal text-blue-100">
                        Input progress harian Ground, UAV, dan Pengolahan Data.
                    </p>
                </a>

                <a href="{{ route('projects.qc.index', $project->id) }}" class="block p-6 bg-teal-600 border border-teal-600 rounded-lg shadow hover:bg-teal-700 transition">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">Formulir & QC ✅</h5>
                    <p class="font-normal text-teal-100">
                        Akses formulir persiapan dan checklist Quality Control.
                    </p>
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Proyek</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Klien</p>
                            <p class="font-medium">{{ $project->client_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Luas Area</p>
                            <p class="font-medium">{{ $project->area_size }} Ha</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Lokasi</p>
                            <p class="font-medium">{{ $project->project_location ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Periode</p>
                            <p class="font-medium">
                                {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }} -
                                {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div x-data="{ openPersonnelModal: false }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 relative">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">List Personil</h3>

                        <button @click="openPersonnelModal = true" class="text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded shadow transition">
                            + Atur Personil
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2">Nama</th>
                                    <th class="px-4 py-2">Peran</th>
                                    <th class="px-4 py-2 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($project->personnel as $person)
                                    <tr class="bg-white border-b">
                                        <td class="px-4 py-2 font-medium text-gray-900">{{ $person->name }}</td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded border">{{ $person->pivot->role }}</span>
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            <form action="{{ route('projects.personnel.destroy', ['project' => $project->id, 'employee_id' => $person->id, 'role' => $person->pivot->role]) }}" method="POST" onsubmit="return confirm('Hapus personil ini dari proyek?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-4 text-center italic text-gray-500">Belum ada personil yang ditugaskan di proyek ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div x-show="openPersonnelModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                            <div x-show="openPersonnelModal" @click="openPersonnelModal = false" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="openPersonnelModal" x-transition class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <form action="{{ route('projects.personnel.store', $project->id) }}" method="POST">
                                    @csrf
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">Tambah Personil Proyek</h3>

                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Nama Karyawan</label>
                                                <select name="employee_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                    <option value="">-- Pilih Karyawan --</option>
                                                    @foreach($employees as $emp)
                                                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Peran / Role</label>
                                                <select name="role" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                    <option value="">-- Pilih Peran --</option>
                                                    <option value="PM">Project Manager (PM)</option>
                                                    <option value="Surveyor">Surveyor</option>
                                                    <option value="Pilot">Pilot UAV</option>
                                                    <option value="Asisten Pilot">Asisten Pilot</option>
                                                    <option value="Pengolah Data">Pengolah Data</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                            Simpan Personil
                                        </button>
                                        <button type="button" @click="openPersonnelModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">List Peralatan</h3>
                        @if(auth()->user()->role === 'admin')
                            <button class="text-xs bg-gray-800 text-white px-3 py-1 rounded">Atur Alat</button>
                        @endif
                    </div>

                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">Jenis</th>
                                <th class="px-4 py-2">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b">
                                <td class="px-4 py-2">UAV / Drone</td>
                                <td class="px-4 py-2">{{ $project->planned_uav }} Unit</td>
                            </tr>
                            <tr class="bg-white border-b">
                                <td class="px-4 py-2">LiDAR</td>
                                <td class="px-4 py-2">{{ $project->planned_lidar }} Unit</td>
                            </tr>
                            <tr class="bg-white border-b">
                                <td class="px-4 py-2">GPS Geodetik</td>
                                <td class="px-4 py-2">{{ $project->planned_gps }} Unit</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
