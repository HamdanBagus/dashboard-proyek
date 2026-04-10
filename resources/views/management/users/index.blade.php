<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Manajemen Pengguna (Akun Login)
            </h2>
        </div>
    </x-slot>

    <div class="pt-6 pb-12 max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6" x-data="{ showModal: false }">

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm font-medium">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            
            <div class="bg-gray-50 p-5 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="font-black text-gray-800 text-lg">Daftar Akun Sistem</h3>
                    <p class="text-xs text-gray-500 mt-1">Hanya karyawan yang terdaftar di sini yang bisa masuk ke dalam aplikasi.</p>
                </div>
                <button @click="showModal = true" class="bg-[#144C4D] text-white px-5 py-2.5 rounded-lg hover:bg-[#0c2e2e] text-sm font-bold shadow-sm transition flex items-center justify-center gap-2 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> 
                    Buat Akun Baru
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-white border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Karyawan / Pengguna</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email Akses</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Role (Hak Akses)</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-black text-gray-900 text-base">{{ $user->name }}</div>
                                @if($user->employee)
                                    <div class="text-[10px] font-bold text-[#144C4D] flex items-center gap-1 mt-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        Terhubung dengan Data Karyawan
                                    </div>
                                @else
                                    <div class="text-[10px] font-bold text-[#F8931F] flex items-center gap-1 mt-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        Akun Independen / Super Admin
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->role === 'admin')
                                    <span class="px-3 py-1 inline-flex text-[10px] font-black uppercase tracking-widest rounded-md bg-purple-100 text-purple-700 border border-purple-200">Admin</span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-[10px] font-black uppercase tracking-widest rounded-md bg-gray-100 text-gray-600 border border-gray-200">Staff</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($user->id !== Auth::id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mencabut akses login untuk pengguna ini? Data fisik karyawan tidak akan terhapus.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 border border-red-500 p-1.5 rounded-md transition" title="Hapus Akses">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Sedang Aktif</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">Belum ada data pengguna terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>

            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-200">
                    
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-black text-gray-900">Buat Akun Akses Baru</h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-red-500 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('users.store') }}" method="POST" class="p-6">
                        @csrf
                        <div class="space-y-5">
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1.5">Pilih Karyawan <span class="text-red-500">*</span></label>
                                <select name="employee_id" required class="w-full rounded-lg border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] shadow-sm text-sm font-medium">
                                    <option value="">-- Pilih Nama Karyawan --</option>
                                    @foreach($employeesWithoutAccount as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-[10px] text-gray-500 mt-1.5 italic">*Hanya menampilkan karyawan yang belum memiliki akun akses.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1.5">Email Akses <span class="text-red-500">*</span></label>
                                <input type="email" name="email" placeholder="contoh@geosurvey.co.id" required class="w-full rounded-lg border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] shadow-sm text-sm font-medium">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1.5">Password Default <span class="text-red-500">*</span></label>
                                <input type="password" name="password" placeholder="Minimal 8 karakter" required minlength="8" class="w-full rounded-lg border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] shadow-sm text-sm font-medium">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1.5">Hak Akses (Role) <span class="text-red-500">*</span></label>
                                <select name="role" required class="w-full rounded-lg border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] shadow-sm text-sm font-medium text-gray-700">
                                    <option value="staff">Staff (Hanya kelola tugas lapangan)</option>
                                    <option value="admin">Admin (Akses penuh manajemen proyek)</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-8 flex justify-end gap-3">
                            <button type="button" @click="showModal = false" class="bg-white border border-gray-300 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-gray-50 transition shadow-sm">
                                Batal
                            </button>
                            <button type="submit" class="bg-[#144C4D] text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-[#0c2e2e] transition shadow-sm">
                                Simpan Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>