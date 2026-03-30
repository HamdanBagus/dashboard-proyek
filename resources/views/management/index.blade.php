<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z"></path>
            </svg>
            <h2 class="font-bold text-xl text-gray-800 leading-tightbreadcrumbs-title">
                Manajemen Asset & Karyawan
            </h2>
        </div>
    </x-slot>

    <div class="py-12 mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        @if(session('success')) 
            <div class="bg-[#F4F7F6] border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="font-medium success-text">{{ session('success') }}</span>
            </div> 
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 items-start">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col h-full overflow-hidden content-card employee-card">
                <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center gap-3 card-header">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <h3 class="font-bold text-gray-800 card-title">Daftar Karyawan</h3>
                </div>
                <div class="p-5 flex-1 flex flex-col card-body">
                    <form action="{{ route('management.employee.store') }}" method="POST" class="flex gap-2 mb-5 add-form employee-form">
                        @csrf
                        <input type="text" name="name" placeholder="Nama Karyawan Baru" required class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-500 focus:ring-gray-500 shadow-sm form-input">
                        <button type="submit" class="bg-[#F8931F] text-white px-4 rounded-lg hover:bg-[#E0811A] text-sm font-bold shadow-sm transition btn-add employee-add">Tambah</button>
                    </form>
                    <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg table-container">
                        <table class="w-full text-sm text-left management-table employee-table">
                            <tbody class="divide-y divide-gray-100 table-body">
                                @forelse($employees as $emp)
                                <tr class="hover:bg-gray-50 transition table-row employee-row">
                                    <td class="px-4 py-3 font-medium text-gray-700 table-cell employee-cell">{{ $emp->name }}</td>
                                    <td class="px-4 py-3 text-right w-10 table-cell employee-cell">
                                        <form action="{{ route('management.employee.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('Hapus karyawan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md transition btn-delete" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="px-4 py-6 text-center text-gray-400 italic table-cell no-data">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col h-full overflow-hidden content-card uav-card">
                <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center gap-3 card-header">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    <h3 class="font-bold text-gray-800 card-title">Daftar Asset UAV</h3>
                </div>
                <div class="p-5 flex-1 flex flex-col card-body">
                    <form action="{{ route('management.uav.store') }}" method="POST" class="flex gap-2 mb-5 add-form uav-form">
                        @csrf
                        <input type="text" name="name" placeholder="Tipe/Nama UAV Baru" required class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-500 focus:ring-gray-500 shadow-sm form-input">
                        <button type="submit" class="bg-[#F8931F] text-white px-4 rounded-lg hover:bg-[#E0811A] text-sm font-bold shadow-sm transition btn-add uav-add">Tambah</button>
                    </form>
                    <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg table-container">
                        <table class="w-full text-sm text-left management-table uav-table">
                            <tbody class="divide-y divide-gray-100 table-body">
                                @forelse($uavs as $uav)
                                <tr class="hover:bg-gray-50 transition table-row uav-row">
                                    <td class="px-4 py-3 font-medium text-gray-700 table-cell uav-cell">{{ $uav->name }}</td>
                                    <td class="px-4 py-3 text-right w-10 table-cell uav-cell">
                                        <form action="{{ route('management.uav.destroy', $uav->id) }}" method="POST" onsubmit="return confirm('Hapus UAV ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md transition btn-delete" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="px-4 py-6 text-center text-gray-400 italic table-cell no-data">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col h-full overflow-hidden content-card camera-card">
                <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center gap-3 card-header">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <h3 class="font-bold text-gray-800 card-title">Daftar Asset Kamera</h3>
                </div>
                <div class="p-5 flex-1 flex flex-col card-body">
                    <form action="{{ route('management.camera.store') }}" method="POST" class="flex gap-2 mb-5 add-form camera-form">
                        @csrf
                        <input type="text" name="name" placeholder="Tipe/Nama Kamera Baru" required class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-500 focus:ring-gray-500 shadow-sm form-input">
                        <button type="submit" class="bg-[#F8931F] text-white px-4 rounded-lg hover:bg-[#E0811A] text-sm font-bold shadow-sm transition btn-add camera-add">Tambah</button>
                    </form>
                    <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg table-container">
                        <table class="w-full text-sm text-left management-table camera-table">
                            <tbody class="divide-y divide-gray-100 table-body">
                                @forelse($cameras as $cam)
                                <tr class="hover:bg-gray-50 transition table-row camera-row">
                                    <td class="px-4 py-3 font-medium text-gray-700 table-cell camera-cell">{{ $cam->name }}</td>
                                    <td class="px-4 py-3 text-right w-10 table-cell camera-cell">
                                        <form action="{{ route('management.camera.destroy', $cam->id) }}" method="POST" onsubmit="return confirm('Hapus Kamera ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md transition btn-delete" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="px-4 py-6 text-center text-gray-400 italic table-cell no-data">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col h-full overflow-hidden content-card pc-card xl:col-span-1 md:col-span-2">
                <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center gap-3 card-header">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <h3 class="font-bold text-gray-800 card-title">Daftar Asset PC / Laptop</h3>
                </div>
                <div class="p-5 flex-1 flex flex-col card-body">
                    <form action="{{ route('management.pc.store') }}" method="POST" class="flex gap-2 mb-5 add-form pc-form">
                        @csrf
                        <input type="text" name="name" placeholder="Nama PC (Cth: PC-01)" required class="w-1/2 rounded-lg border-gray-300 text-sm focus:border-gray-500 focus:ring-gray-500 shadow-sm form-input pc-name">
                        <input type="text" name="spec" placeholder="Spesifikasi (Opsional)" class="w-1/2 rounded-lg border-gray-300 text-sm focus:border-gray-500 focus:ring-gray-500 shadow-sm form-input pc-spec">
                        <button type="submit" class="bg-[#F8931F] text-white px-4 rounded-lg hover:bg-[#E0811A] text-sm font-bold shadow-sm transition btn-add pc-add">Tambah</button>
                    </form>
                    <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg table-container">
                        <table class="w-full text-sm text-left management-table pc-table">
                            <tbody class="divide-y divide-gray-100 table-body">
                                @forelse($pcs as $pc)
                                <tr class="hover:bg-gray-50 transition table-row pc-row">
                                    <td class="px-4 py-3 table-cell pc-cell">
                                        <div class="font-bold text-gray-700 pc-name-display">{{ $pc->name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5 pc-spec-display">{{ $pc->spec ?: 'Tidak ada deskripsi spesifikasi' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-right w-10 align-middle table-cell pc-cell">
                                        <form action="{{ route('management.pc.destroy', $pc->id) }}" method="POST" onsubmit="return confirm('Hapus PC ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md transition btn-delete" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="px-4 py-6 text-center text-gray-400 italic table-cell no-data">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col h-full overflow-hidden content-card gps-card xl:col-span-2 md:col-span-2">
                <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center gap-3 card-header">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <h3 class="font-bold text-gray-800 card-title">Manajemen Unit GPS</h3>
                </div>
                <div class="p-5 flex-1 flex flex-col card-body">
                    <form action="{{ route('management.gps.store') }}" method="POST" class="flex gap-4 items-end mb-5 add-form gps-form">
                        @csrf
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Merek / Nama GPS</label>
                            <input type="text" name="name" placeholder="Cth: Trimble R8s" class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-500 focus:ring-gray-500 shadow-sm form-input" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Tipe GPS</label>
                            <input type="text" name="type" list="gps_types" placeholder="Cth: Geodetik Base" class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-500 focus:ring-gray-500 shadow-sm form-input">
                            <datalist id="gps_types">
                                <option value="Geodetik Base">
                                <option value="Geodetik Rover">
                                <option value="Handheld">
                                <option value="Echosounder">
                            </datalist>
                        </div>
                        <div>
                            <button type="submit" class="bg-[#F8931F] text-white px-6 py-2 rounded-lg hover:bg-[#E0811A] text-sm font-bold shadow-sm transition h-[38px] btn-add gps-add">
                                Tambah Unit
                            </button>
                        </div>
                    </form>
                    <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg table-container">
                        <table class="w-full text-sm text-left management-table gps-table">
                            <thead class="bg-gray-50 border-b border-gray-200 table-header">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider table-header-cell">Nama GPS</th>
                                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider table-header-cell">Tipe</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-16 table-header-cell">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 table-body">
                                @forelse($gps_units as $gps)
                                <tr class="hover:bg-gray-50 transition table-row gps-row">
                                    <td class="px-4 py-3 font-bold text-gray-700 table-cell gps-cell name-cell">{{ $gps->name }}</td>
                                    <td class="px-4 py-3 text-gray-500 table-cell gps-cell type-cell">
                                        <span class="bg-[#F4F7F6] border border-gray-200 text-gray-600 px-2 py-1 rounded text-xs font-semibold gps-type-badge">
                                            {{ $gps->type ?? 'Tidak diketahui' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center table-cell gps-cell action-cell">
                                        <form action="{{ route('management.gps.destroy', $gps->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus GPS ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md transition btn-delete" title="Hapus">
                                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="px-4 py-6 text-center text-gray-400 italic table-cell no-data">Belum ada unit GPS terdaftar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>