<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z"></path>
            </svg>
            <h2 class="font-bold text-xl text-gray-800 leading-tight breadcrumbs-title">
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

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col h-full overflow-hidden" x-data="{ showModal: false, showEditModal: false, editData: { id: '', name: '' } }">
                <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <h3 class="font-bold text-gray-800">Daftar Karyawan</h3>
                    </div>
                    <button @click="showModal = true" type="button" class="bg-[#F8931F] text-white p-1.5 rounded shadow-sm hover:bg-[#E0811A] transition" title="Tambah Karyawan">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg">
                        <table class="w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-100">
                                @forelse($employees as $emp)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-medium text-gray-700">{{ $emp->name }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button type="button" @click="editData = { id: {{ $emp->id }}, name: '{{ addslashes($emp->name) }}' }; showEditModal = true" class="text-gray-400 hover:text-blue-600 hover:bg-blue-50 p-1.5 rounded-md transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <form action="{{ route('management.employee.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('Hapus karyawan ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md transition" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="px-4 py-6 text-center text-gray-400 italic">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="showModal" @click="showModal = false" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50"></div>
                        <div x-show="showModal" class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6 border border-gray-100">
                            <h3 class="text-lg font-black text-gray-900 mb-4 border-b pb-2">Tambah Karyawan Baru</h3>
                            <form action="{{ route('management.employee.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" placeholder="Ketik nama karyawan..." required class="w-full rounded-lg border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] shadow-sm sm:text-sm">
                                </div>
                                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                    <button type="button" @click="showModal = false" class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition">Batal</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#F8931F] rounded-lg hover:bg-[#E0811A] shadow-sm transition">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="showEditModal" @click="showEditModal = false" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50"></div>
                        <div x-show="showEditModal" class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6 border border-gray-100">
                            <h3 class="text-lg font-black text-gray-900 mb-4 border-b pb-2">Edit Karyawan</h3>
                            <form :action="'/management/employee/' + editData.id" method="POST">
                                @csrf @method('PUT')
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" x-model="editData.name" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm sm:text-sm">
                                </div>
                                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                    <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition">Batal</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm transition">Update Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col h-full overflow-hidden" x-data="{ showModal: false, showEditModal: false, editData: { id: '', name: '', serial_number: '', pic_id: '' } }">
                <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        <h3 class="font-bold text-gray-800">Daftar Asset UAV</h3>
                    </div>
                    <button @click="showModal = true" type="button" class="bg-[#F8931F] text-white p-1.5 rounded shadow-sm hover:bg-[#E0811A] transition" title="Tambah UAV">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg">
                        <table class="w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-100">
                                @forelse($uavs as $uav)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-gray-700">{{ $uav->name }}</div>
                                        <div class="text-[11px] font-semibold text-gray-400 mt-0.5 uppercase tracking-wider">
                                            SN: <span class="text-gray-600">{{ $uav->serial_number ?? '-' }}</span> 
                                            <span class="mx-1">|</span> 
                                            PIC: <span class="text-[#F8931F]">{{ $uav->pic ? $uav->pic->name : 'Belum diatur' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button type="button" @click="editData = { id: {{ $uav->id }}, name: '{{ addslashes($uav->name) }}', serial_number: '{{ addslashes($uav->serial_number) }}', pic_id: '{{ $uav->pic_id ?? '' }}' }; showEditModal = true" class="text-gray-400 hover:text-blue-600 hover:bg-blue-50 p-1.5 rounded-md transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <form action="{{ route('management.uav.destroy', $uav->id) }}" method="POST" onsubmit="return confirm('Hapus UAV ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md transition" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="px-4 py-6 text-center text-gray-400 italic">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="showModal" @click="showModal = false" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50"></div>
                        <div x-show="showModal" class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6 border border-gray-100">
                            <h3 class="text-lg font-black text-gray-900 mb-4 border-b pb-2">Tambah Asset UAV</h3>
                            <form action="{{ route('management.uav.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tipe/Nama UAV <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" placeholder="Cth: DJI Matrice 300 RTK" required class="w-full rounded-lg border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] shadow-sm sm:text-sm">
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nomor Serial (SN)</label>
                                        <input type="text" name="serial_number" placeholder="Cth: 1ZVCH..." class="w-full rounded-lg border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] shadow-sm sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Penanggung Jawab</label>
                                        <select name="pic_id" class="w-full rounded-lg border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] shadow-sm sm:text-sm">
                                            <option value="">-- Pilih PIC --</option>
                                            @foreach($employees as $emp)
                                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                    <button type="button" @click="showModal = false" class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition">Batal</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#F8931F] rounded-lg hover:bg-[#E0811A] shadow-sm transition">Simpan Asset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="showEditModal" @click="showEditModal = false" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50"></div>
                        <div x-show="showEditModal" class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6 border border-gray-100">
                            <h3 class="text-lg font-black text-gray-900 mb-4 border-b pb-2">Edit Asset UAV</h3>
                            <form :action="'/management/uav/' + editData.id" method="POST">
                                @csrf @method('PUT')
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tipe/Nama UAV <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" x-model="editData.name" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm sm:text-sm">
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nomor Serial (SN)</label>
                                        <input type="text" name="serial_number" x-model="editData.serial_number" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Penanggung Jawab</label>
                                        <select name="pic_id" x-model="editData.pic_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm sm:text-sm">
                                            <option value="">-- Pilih PIC --</option>
                                            @foreach($employees as $emp)
                                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                    <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition">Batal</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm transition">Update Asset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col h-full overflow-hidden" x-data="{ showModal: false }">
                <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <h3 class="font-bold text-gray-800">Daftar Asset Kamera</h3>
                    </div>
                    <button @click="showModal = true" type="button" class="bg-[#F8931F] text-white p-1.5 rounded shadow-sm hover:bg-[#E0811A] transition" title="Tambah Kamera">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg">
                        <table class="w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-100">
                                @forelse($cameras as $cam)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-medium text-gray-700">{{ $cam->name }}</td>
                                    <td class="px-4 py-3 text-right w-10">
                                        <form action="{{ route('management.camera.destroy', $cam->id) }}" method="POST" onsubmit="return confirm('Hapus Kamera ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md transition" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="px-4 py-6 text-center text-gray-400 italic">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="showModal" @click="showModal = false" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50"></div>
                        <div x-show="showModal" class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6 border border-gray-100">
                            <h3 class="text-lg font-black text-gray-900 mb-4 border-b pb-2">Tambah Asset Kamera</h3>
                            <form action="{{ route('management.camera.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tipe/Nama Kamera</label>
                                    <input type="text" name="name" placeholder="Cth: Zenmuse P1" required class="w-full rounded-lg border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] shadow-sm sm:text-sm">
                                </div>
                                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                    <button type="button" @click="showModal = false" class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition">Batal</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#F8931F] rounded-lg hover:bg-[#E0811A] shadow-sm transition">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col h-full overflow-hidden xl:col-span-1 md:col-span-2" x-data="{ showModal: false }">
                <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <h3 class="font-bold text-gray-800">Daftar Asset PC / Laptop</h3>
                    </div>
                    <button @click="showModal = true" type="button" class="bg-[#F8931F] text-white p-1.5 rounded shadow-sm hover:bg-[#E0811A] transition" title="Tambah PC/Laptop">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg">
                        <table class="w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-100">
                                @forelse($pcs as $pc)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-gray-700">{{ $pc->name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $pc->spec ?: 'Tidak ada deskripsi spesifikasi' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-right w-10 align-middle">
                                        <form action="{{ route('management.pc.destroy', $pc->id) }}" method="POST" onsubmit="return confirm('Hapus PC ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md transition" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="px-4 py-6 text-center text-gray-400 italic">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="showModal" @click="showModal = false" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50"></div>
                        <div x-show="showModal" class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6 border border-gray-100">
                            <h3 class="text-lg font-black text-gray-900 mb-4 border-b pb-2">Tambah Asset PC / Laptop</h3>
                            <form action="{{ route('management.pc.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Komputer</label>
                                    <input type="text" name="name" placeholder="Cth: PC-01 atau Laptop Asus" required class="w-full rounded-lg border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] shadow-sm sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Spesifikasi Detail (Opsional)</label>
                                    <input type="text" name="spec" placeholder="Cth: i9, 64GB RAM, RTX 3090" class="w-full rounded-lg border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] shadow-sm sm:text-sm">
                                </div>
                                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                    <button type="button" @click="showModal = false" class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition">Batal</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#F8931F] rounded-lg hover:bg-[#E0811A] shadow-sm transition">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col h-full overflow-hidden xl:col-span-2 md:col-span-2" x-data="{ showModal: false }">
                <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <h3 class="font-bold text-gray-800">Manajemen Unit GPS</h3>
                    </div>
                    <button @click="showModal = true" type="button" class="bg-[#F8931F] text-white p-1.5 rounded shadow-sm hover:bg-[#E0811A] transition" title="Tambah GPS">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama GPS</th>
                                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-16">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($gps_units as $gps)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-bold text-gray-700">{{ $gps->name }}</td>
                                    <td class="px-4 py-3 text-gray-500">
                                        <span class="bg-[#F4F7F6] border border-gray-200 text-gray-600 px-2 py-1 rounded text-xs font-semibold">
                                            {{ $gps->type ?? 'Tidak diketahui' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <form action="{{ route('management.gps.destroy', $gps->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus GPS ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md transition" title="Hapus"><svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="px-4 py-6 text-center text-gray-400 italic">Belum ada unit GPS terdaftar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="showModal" @click="showModal = false" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50"></div>
                        <div x-show="showModal" class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6 border border-gray-100">
                            <h3 class="text-lg font-black text-gray-900 mb-4 border-b pb-2">Tambah Asset GPS</h3>
                            <form action="{{ route('management.gps.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Merek / Nama GPS</label>
                                    <input type="text" name="name" placeholder="Cth: Trimble R8s" required class="w-full rounded-lg border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] shadow-sm sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tipe GPS</label>
                                    <input type="text" name="type" list="gps_types" placeholder="Pilih atau ketik tipe..." class="w-full rounded-lg border-gray-300 focus:border-[#F8931F] focus:ring-[#F8931F] shadow-sm sm:text-sm">
                                    <datalist id="gps_types">
                                        <option value="Geodetik Base">
                                        <option value="Geodetik Rover">
                                        <option value="Handheld">
                                        <option value="Echosounder">
                                    </datalist>
                                </div>
                                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                    <button type="button" @click="showModal = false" class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition">Batal</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#F8931F] rounded-lg hover:bg-[#E0811A] shadow-sm transition">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>