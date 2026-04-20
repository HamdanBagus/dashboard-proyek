<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center flex-wrap gap-2">
                    
                    <a href="{{ route('projects.index') }}" class="group flex flex-row items-center gap-2 text-[#144C4D] hover:text-[#F8931F] transition whitespace-nowrap" title="Kembali ke Daftar Proyek">
                        <span class="bg-gray-100 text-[#144C4D] group-hover:bg-[#F8931F] group-hover:text-white p-1.5 rounded-lg transition shadow-sm flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </span>
                        <span class="group-hover:underline text-base sm:text-lg">Daftar Proyek</span>
                    </a>
                    <span class="text-gray-400 text-lg mx-1 shrink-0">/</span>
                    <span class="text-gray-700 truncate max-w-[150px] sm:max-w-xs md:max-w-md lg:max-w-lg" title="{{ $project->name }}">
                        {{ $project->name }}
                    </span>
                    
                    <span class="text-[10px] sm:text-xs font-black text-[#F8931F] bg-orange-50 px-2 py-1 rounded-md border border-orange-100 shadow-sm shrink-0 whitespace-nowrap">
                        {{ $project->code }}
                    </span>
                </h2>
            </div>

            <span class="px-4 py-1.5 text-[10px] sm:text-xs rounded-full font-black shadow-sm uppercase tracking-widest shrink-0
                @if($project->status == 'planning') bg-gray-100 text-gray-600 border border-gray-200
                @elseif($project->status == 'ongoing') bg-blue-50 text-blue-700 border border-blue-200
                @elseif($project->status == 'finished') bg-green-50 text-green-700 border border-green-200
                @endif">
                {{ $project->status == 'ongoing' ? 'Sedang Berjalan' : ($project->status == 'planning' ? 'Perencanaan' : 'Selesai') }}
            </span>
            
        </div>
    </x-slot>

    <div class="pt-6 pb-12 max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('projects.progress.index', $project->id) }}" class="group relative bg-[#144C4D] rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 overflow-hidden flex items-center p-6 border border-[#0e3536]">
                
                <div class="relative z-10 flex-1">
                    <h5 class="text-2xl font-black text-white mb-1 flex items-center gap-2">Log Progress <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></h5>
                    <p class="text-[#89b8b9] text-sm font-medium">Input laporan harian Ground, UAV, dan Pengolahan.</p>
                </div>
            </a>

            <a href="{{ route('projects.qc.index', $project->id) }}" class="group relative bg-[#F8931F] rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 overflow-hidden flex items-center p-6 border border-[#df8218]">
                <div class="relative z-10 flex-1">
                    <h5 class="text-2xl font-black text-white mb-1 flex items-center gap-2">Menu Quality Control <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></h5>
                    <p class="text-[#ffe0bc] text-sm font-medium">Akses formulir pengesahan dan checklist kualitas (QC).</p>
                </div>
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            <div class="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-gray-200">
                
                <div class="p-6 flex flex-col h-full">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-black text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Informasi Dasar
                        </h3>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('projects.edit', $project->id) }}" class="text-xs bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 px-3 py-1.5 rounded-md font-bold transition shadow-sm flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg> Edit
                            </a>
                        @endif
                    </div>

                    <div class="mb-6 bg-[#F4F7F6] border border-[#144C4D]/20 rounded-xl p-5 flex items-center justify-between shadow-inner">
                        <div>
                            <p class="text-xs font-bold text-[#144C4D] uppercase tracking-wider mb-1">Total Progress Proyek</p>
                            <p class="text-xs text-gray-500 font-medium">Akumulasi keseluruhan divisi</p>
                        </div>
                        <div class="relative w-16 h-16 shrink-0">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-gray-200" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="{{ $totalProjectProgress >= 100 ? 'text-green-500' : 'text-[#F8931F]' }}" 
                                    stroke-width="3.5" stroke-dasharray="{{ min($totalProjectProgress, 100) }}, 100" stroke="currentColor" fill="none" stroke-linecap="round"
                                    style="transition: stroke-dasharray 1s ease-in-out;"
                                    d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-sm font-black {{ $totalProjectProgress >= 100 ? 'text-green-600' : 'text-[#144C4D]' }}">
                                    {{ number_format($totalProjectProgress, 0) }}%
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-y-5 gap-x-4">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Nama Klien</p>
                            <p class="font-bold text-gray-900">{{ $project->client_name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Luas Area</p>
                            <p class="font-black text-[#144C4D]">{{ $project->area_size }} <span class="text-sm">Ha</span></p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Alamat Klien</p>
                            <p class="font-medium text-gray-800">{{ $project->client_address ?? '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Lokasi Proyek</p>
                            <p class="font-medium text-gray-800">{{ $project->project_location ?? '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Periode Pelaksanaan</p>
                            <p class="font-bold text-gray-900 bg-gray-50 border border-gray-200 inline-block px-3 py-1 rounded-md">
                                {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }} <span class="text-gray-400 mx-1">s/d</span> {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-gray-50 flex flex-col h-full">
                    <h3 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#F8931F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Detail & Produk
                    </h3>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 text-center">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Rencana Take OFF</p>
                            <p class="text-2xl font-black text-[#F8931F]">{{ $project->takeoff_count ?? 0 }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 text-center">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Rencana Titik Kontrol</p>
                            <p class="text-2xl font-black text-[#144C4D]">{{ $project->control_point_count ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="space-y-5 bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2 border-b pb-1">Produk Yang Dihasilkan</p>
                            @if(!empty($project->products) && count(array_filter($project->products)) > 0)
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach(array_filter($project->products) as $product)
                                        <span class="bg-[#F4F7F6] text-[#144C4D] text-xs font-bold px-2.5 py-1 rounded border border-[#144C4D]/20">{{ $product }}</span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-xs text-gray-400 italic">Belum ditentukan</p>
                            @endif
                        </div>

                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2 border-b pb-1">Spesifikasi Produk</p>
                            @if(!empty($project->product_specs) && count(array_filter($project->product_specs)) > 0)
                                <ul class="list-disc pl-4 text-xs font-medium text-gray-700 space-y-1">
                                    @foreach(array_filter($project->product_specs) as $spec)
                                        <li>{{ $spec }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-xs text-gray-400 italic">Belum ditentukan</p>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2">Kode Titik</p>
                                @if(!empty($project->point_codes) && count(array_filter($project->point_codes)) > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_filter($project->point_codes) as $code)
                                            <span class="bg-gray-100 text-gray-800 text-xs font-bold px-2 py-0.5 rounded">{{ $code }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-xs text-gray-400 italic">-</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2">Titik Ikat</p>
                                @if(!empty($project->tie_points) && count(array_filter($project->tie_points)) > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_filter($project->tie_points) as $tie)
                                            <span class="bg-gray-100 text-gray-800 text-xs font-bold px-2 py-0.5 rounded">{{ $tie }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-xs text-gray-400 italic">-</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

            <div x-data="{ openPersonnelModal: false }" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-5 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="text-base font-black text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Daftar Personil
                    </h3>
                    <button @click="openPersonnelModal = true" class="text-xs font-bold bg-[#F8931F] hover:bg-[#e08219] text-white px-3 py-1.5 rounded-lg shadow-sm transition">
                        + Atur Personil
                    </button>
                </div>

                <div class="overflow-x-auto max-h-80 overflow-y-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-white border-b border-gray-100 sticky top-0">
                            <tr>
                                <th class="px-5 py-3">Nama Lengkap</th>
                                <th class="px-5 py-3">Peran / Tugas</th>
                                <th class="px-5 py-3 text-center w-16">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($project->personnel as $person)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-5 py-3 font-bold text-gray-900">{{ $person->name }}</td>
                                    <td class="px-5 py-3">
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-[10px] uppercase tracking-wider font-bold rounded-md border border-gray-200">{{ $person->pivot->role }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-center">
                                        <form action="{{ route('projects.personnel.destroy', ['project' => $project->id, 'employee_id' => $person->id, 'role' => $person->pivot->role]) }}" method="POST" onsubmit="return confirm('Hapus personil ini dari proyek?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 p-1 rounded transition" title="Hapus">
                                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-8 text-center italic text-gray-400">Belum ada personil yang ditugaskan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div x-show="openPersonnelModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="openPersonnelModal" @click="openPersonnelModal = false" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="openPersonnelModal" x-transition class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                            <form action="{{ route('projects.personnel.store', $project->id) }}" method="POST">
                                @csrf
                                <div class="bg-white px-6 pt-6 pb-4">
                                    <h3 class="text-lg font-black text-gray-900 mb-4 border-b border-gray-100 pb-2" id="modal-title">Tambah Personil Proyek</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Karyawan</label>
                                            <select name="employee_id" required class="block w-full py-2.5 px-3 border border-gray-300 rounded-lg shadow-sm focus:ring-[#144C4D] focus:border-[#144C4D] text-sm font-medium">
                                                <option value="">-- Pilih Karyawan --</option>
                                                @foreach($employees as $emp)
                                                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Peran / Role</label>
                                            <select name="role" required class="block w-full py-2.5 px-3 border border-gray-300 rounded-lg shadow-sm focus:ring-[#144C4D] focus:border-[#144C4D] text-sm font-medium">
                                                <option value="">-- Pilih Peran --</option>
                                                <option value="Project Manager (PM)">Project Manager (PM)</option>
                                                <option value="Surveyor">Surveyor</option>
                                                <option value="Pilot">Pilot UAV</option>
                                                <option value="Asisten Pilot">Asisten Pilot</option>
                                                <option value="Pengolah Data">Pengolah Data</option>
                                                <option value="Koordinator Tim Ground">Koordinator Tim Ground</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end border-t border-gray-100">
                                    <button type="button" @click="openPersonnelModal = false" class="px-5 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm">
                                        Batal
                                    </button>
                                    <button type="submit" class="px-5 py-2 bg-[#144C4D] rounded-lg text-sm font-bold text-white hover:bg-[#0c2e2e] transition shadow-sm">
                                        Simpan Personil
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-5 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-base font-black text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#F8931F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Rencana Kebutuhan Alat
                    </h3>
                </div>
                
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <span class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 border-b border-gray-200 pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg> UAV / Drone
                        </span>
                        @if(is_array($project->planned_uavs) && count($project->planned_uavs) > 0)
                            <ul class="space-y-1.5">
                                @foreach($project->planned_uavs as $uav)
                                    <li class="text-sm font-bold text-gray-800 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 border-b border-gray-100 py-3 last:border-0 last:pb-0 first:pt-0">
    
                                        <div class="flex items-center gap-2.5 flex-wrap">
                                            <span class="truncate">{{ $uav['id'] ?? 'Unknown' }}</span>
                                            <span class="text-[#F8931F] bg-orange-50 px-2 py-0.5 rounded-md text-[10px] uppercase tracking-widest border border-orange-100 shrink-0">
                                                {{ $uav['qty'] ?? 0 }} Unit
                                            </span>
                                        </div>

                                        <a href="{{ route('projects.uav-log.show', ['project' => $project->id, 'uav_name' => $uav['id']]) }}" 
                                        class="inline-flex items-center justify-center gap-1.5 text-[10px] bg-[#144C4D] text-white px-3 py-2 rounded-lg hover:bg-[#0c2e2e] transition-all shadow-sm font-bold tracking-widest uppercase shrink-0 w-full sm:w-auto group">
                                            
                                            <svg class="w-3.5 h-3.5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            
                                            Cek Kondisi
                                        </a>

                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada data</span>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <span class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 border-b border-gray-200 pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg> Kamera / Sensor
                        </span>
                        @if(is_array($project->planned_cameras) && count($project->planned_cameras) > 0)
                            <ul class="space-y-1.5">
                                @foreach($project->planned_cameras as $cam)
                                    <li class="text-sm font-bold text-gray-800 flex justify-between">
                                        <span>{{ $cam['id'] ?? 'Unknown' }}</span> 
                                        <span class="text-[#144C4D] bg-[#E8F1F1] px-1.5 rounded">{{ $cam['qty'] ?? 0 }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada data</span>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <span class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 border-b border-gray-200 pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg> GPS Unit
                        </span>
                        @if(is_array($project->planned_gps) && count($project->planned_gps) > 0)
                            <ul class="space-y-1.5">
                                @foreach($project->planned_gps as $gps)
                                    <li class="text-sm font-bold text-gray-800 flex justify-between">
                                        <span>{{ $gps['id'] ?? 'Unknown' }}</span> 
                                        <span class="text-[#F8931F] bg-orange-50 px-1.5 rounded">{{ $gps['qty'] ?? 0 }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada data</span>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <span class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 border-b border-gray-200 pb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> PC Workstation
                        </span>
                        @if(is_array($project->planned_pcs) && count($project->planned_pcs) > 0)
                            <ul class="space-y-1.5">
                                @foreach($project->planned_pcs as $pc)
                                    <li class="text-sm font-bold text-gray-800 flex justify-between">
                                        <span>{{ $pc['id'] ?? 'Unknown' }}</span> 
                                        <span class="text-[#144C4D] bg-[#E8F1F1] px-1.5 rounded">{{ $pc['qty'] ?? 0 }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada data</span>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>