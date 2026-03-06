<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }} <span class="text-sm text-gray-500">({{ $project->code }})</span>
            </h2>
            <span class="px-3 py-1 text-sm rounded-full font-bold shadow-sm
                @if($project->status == 'planning') bg-orange-100 text-orange-800
                @elseif($project->status == 'ongoing') bg-yellow-200 text-yellow-800
                @elseif($project->status == 'finished') bg-green-200 text-green-800
                @endif">
                {{ ucfirst($project->status) }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('projects.progress.index', $project->id) }}" class="block p-6 bg-blue-600 border border-blue-600 rounded-xl shadow hover:bg-blue-700 transition transform hover:-translate-y-1">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">Log Progress 📊</h5>
                    <p class="font-normal text-blue-100">
                        Input progress harian Ground, UAV, dan Pengolahan Data.
                    </p>
                </a>

                <a href="{{ route('projects.qc.index', $project->id) }}" class="block p-6 bg-teal-600 border border-teal-600 rounded-xl shadow hover:bg-teal-700 transition transform hover:-translate-y-1">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">Formulir QC ✅</h5>
                    <p class="font-normal text-teal-100">
                        Akses formulir dan checklist Quality Control (QC).
                    </p>
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="flex flex-col h-full">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-2">
                            <h3 class="text-lg font-bold text-blue-700">Informasi Dasar Proyek</h3>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('projects.edit', $project->id) }}" 
                                class="text-xs bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-800 px-3 py-1 rounded font-bold transition shadow-sm">
                                    Edit Proyek
                                </a>
                            @endif
                        </div>
                        <div class="mb-6 bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-1">Total Progress Proyek</p>
                                <p class="text-xs text-blue-600 font-medium">Rata-rata dari 4 divisi</p>
                            </div>
                            <div class="relative w-16 h-16 shrink-0">
                                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                    <path class="text-blue-200" stroke-width="3.5" stroke="currentColor" fill="none" 
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <path class="{{ $totalProjectProgress >= 100 ? 'text-green-500' : 'text-blue-600' }}" 
                                        stroke-width="3.5" 
                                        stroke-dasharray="{{ min($totalProjectProgress, 100) }}, 100" 
                                        stroke="currentColor" 
                                        fill="none" 
                                        stroke-linecap="round"
                                        style="transition: stroke-dasharray 1s ease-in-out;"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-sm font-extrabold {{ $totalProjectProgress >= 100 ? 'text-green-600' : 'text-blue-900' }}">
                                        {{ number_format($totalProjectProgress, 0) }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-y-4 gap-x-4 mt-2">
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Nama Klien</p>
                                <p class="font-medium text-gray-900">{{ $project->client_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Luas Area</p>
                                <p class="font-medium text-gray-900">{{ $project->area_size }} Ha</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Alamat Klien</p>
                                <p class="font-medium text-gray-900">{{ $project->client_address ?? '-' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Lokasi Proyek</p>
                                <p class="font-medium text-gray-900">{{ $project->project_location ?? '-' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Periode Pelaksanaan</p>
                                <p class="font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                        <h3 class="text-lg font-bold text-indigo-700 mb-4 border-b border-gray-300 pb-2">Detail Persiapan & Produk</h3>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-white p-3 rounded shadow-sm border border-gray-200 text-center">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Rencana Take OFF</p>
                                <p class="text-xl font-bold text-indigo-700 mt-1">{{ $project->takeoff_count ?? 0 }}</p>
                            </div>
                            <div class="bg-white p-3 rounded shadow-sm border border-gray-200 text-center">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Rencana Titik Kontrol</p>
                                <p class="text-xl font-bold text-indigo-700 mt-1">{{ $project->control_point_count ?? 0 }}</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Produk Yang Dihasilkan</p>
                                @if(!empty($project->products) && count(array_filter($project->products)) > 0)
                                    <ul class="list-disc pl-5 text-sm text-gray-800">
                                        @foreach(array_filter($project->products) as $product)
                                            <li>{{ $product }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-gray-400 italic">-</p>
                                @endif
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Spesifikasi Produk</p>
                                @if(!empty($project->product_specs) && count(array_filter($project->product_specs)) > 0)
                                    <ul class="list-disc pl-5 text-sm text-gray-800">
                                        @foreach(array_filter($project->product_specs) as $spec)
                                            <li>{{ $spec }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-gray-400 italic">-</p>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-4 pt-2">
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Kode Nama Titik</p>
                                    @if(!empty($project->point_codes) && count(array_filter($project->point_codes)) > 0)
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach(array_filter($project->point_codes) as $code)
                                                <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-0.5 rounded">{{ $code }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-400 italic">-</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Rencana Titik Ikat</p>
                                    @if(!empty($project->tie_points) && count(array_filter($project->tie_points)) > 0)
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach(array_filter($project->tie_points) as $tie)
                                                <span class="bg-gray-200 text-gray-800 text-xs font-semibold px-2 py-0.5 rounded">{{ $tie }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-400 italic">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div x-data="{ openPersonnelModal: false }" class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 relative flex flex-col">
                    <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-2">
                        <h3 class="text-lg font-bold text-gray-900">List Personil</h3>
                        <button @click="openPersonnelModal = true" class="text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded shadow transition">
                            + Atur Personil
                        </button>
                    </div>

                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-sm text-left text-gray-500 border">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3">Nama</th>
                                    <th class="px-4 py-3">Peran</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($project->personnel as $person)
                                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 font-bold text-gray-900">{{ $person->name }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded border">{{ $person->pivot->role }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <form action="{{ route('projects.personnel.destroy', ['project' => $project->id, 'employee_id' => $person->id, 'role' => $person->pivot->role]) }}" method="POST" onsubmit="return confirm('Hapus personil ini dari proyek?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 border border-red-500 px-3 py-1 rounded text-xs font-bold transition">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center italic text-gray-500">Belum ada personil yang ditugaskan di proyek ini.</td>
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
                                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4 border-b pb-2" id="modal-title">Tambah Personil Proyek</h3>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Karyawan</label>
                                                <select name="employee_id" required class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                    <option value="">-- Pilih Karyawan --</option>
                                                    @foreach($employees as $emp)
                                                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Peran / Role</label>
                                                <select name="role" required class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                    <option value="">-- Pilih Peran --</option>
                                                    <option value="Project Manager (PM)">Project Manager (PM)</option>
                                                    <option value="Surveyor">Surveyor</option>
                                                    <option value="Pilot">Pilot UAV</option>
                                                    <option value="Asisten Pilot">Asisten Pilot</option>
                                                    <option value="Pengolah Data">Pengolah Data</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-bold text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">
                                            Simpan Personil
                                        </button>
                                        <button type="button" @click="openPersonnelModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-gray-700 hover:bg-gray-100 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 flex flex-col">
                    <h3 class="text-lg font-bold text-blue-700 mb-4 border-b border-gray-200 pb-2">Rencana Kebutuhan Alat</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 flex-1">
                        
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">UAV / Drone</span>
                            @if(is_array($project->planned_uavs) && count($project->planned_uavs) > 0)
                                <ul class="list-disc pl-5 text-sm text-gray-800 font-medium space-y-1">
                                    @foreach($project->planned_uavs as $uav)
                                        <li>{{ $uav['id'] ?? 'Tidak diketahui' }} <span class="text-blue-600 font-bold">({{ $uav['qty'] ?? 0 }} Unit)</span></li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-sm text-gray-400 italic">Tidak ada data</span>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kamera / Sensor</span>
                            @if(is_array($project->planned_cameras) && count($project->planned_cameras) > 0)
                                <ul class="list-disc pl-5 text-sm text-gray-800 font-medium space-y-1">
                                    @foreach($project->planned_cameras as $cam)
                                        <li>{{ $cam['id'] ?? 'Tidak diketahui' }} <span class="text-blue-600 font-bold">({{ $cam['qty'] ?? 0 }} Unit)</span></li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-sm text-gray-400 italic">Tidak ada data</span>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">GPS Unit</span>
                            @if(is_array($project->planned_gps) && count($project->planned_gps) > 0)
                                <ul class="list-disc pl-5 text-sm text-gray-800 font-medium space-y-1">
                                    @foreach($project->planned_gps as $gps)
                                        <li>{{ $gps['id'] ?? 'Tidak diketahui' }} <span class="text-blue-600 font-bold">({{ $gps['qty'] ?? 0 }} Unit)</span></li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-sm text-gray-400 italic">Tidak ada data</span>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">PC Workstation</span>
                            @if(is_array($project->planned_pcs) && count($project->planned_pcs) > 0)
                                <ul class="list-disc pl-5 text-sm text-gray-800 font-medium space-y-1">
                                    @foreach($project->planned_pcs as $pc)
                                        <li>{{ $pc['id'] ?? 'Tidak diketahui' }} <span class="text-blue-600 font-bold">({{ $pc['qty'] ?? 0 }} Unit)</span></li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-sm text-gray-400 italic">Tidak ada data</span>
                            @endif
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>