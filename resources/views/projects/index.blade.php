<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Proyek') }}
            </h2>
        </div>
    </x-slot>

    <div class="pt-6 pb-12 max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col gap-5">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-100 pb-4">
                <h3 class="text-lg font-black text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#F8931F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Daftar Proyek
                </h3>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('projects.create') }}" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-[#144C4D] hover:bg-[#0c2e2e] text-white font-bold py-2 px-5 rounded-lg shadow-sm transition whitespace-nowrap text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Proyek Baru
                    </a>
                @endif
            </div>

            <form action="{{ route('projects.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 items-center w-full">
                
                <div class="w-full sm:flex-1 relative">
                    <div class="relative flex items-stretch focus-within:z-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" onblur="this.form.submit()" placeholder="Cari Nama / Kode Proyek (Tekan Enter)..." class="block w-full rounded-lg pl-10 border-gray-300 focus:border-[#144C4D] focus:ring focus:ring-[#144C4D]/20 sm:text-sm font-medium transition h-[42px]">
                    </div>
                </div>

                <div class="w-full sm:w-48 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </div>
                    <select name="sort" class="block w-full pl-9 rounded-lg border-gray-300 focus:border-[#144C4D] focus:ring focus:ring-[#144C4D]/20 sm:text-sm font-bold text-gray-700 transition h-[42px]" onchange="this.form.submit()">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Abjad (A - Z)</option>
                        <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Abjad (Z - A)</option>
                    </select>
                </div>

                @if(request('search') || request('sort'))
                    <div class="w-full sm:w-auto flex shrink-0">
                        <a href="{{ route('projects.index') }}" class="w-full inline-flex justify-center items-center px-3 border border-red-200 text-sm font-bold rounded-lg text-red-600 bg-red-50 hover:bg-red-500 hover:text-white transition shadow-sm h-[42px]" title="Reset Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    </div>
                @endif

            </form>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0 shadow-sm z-10">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b w-32">Kode</th>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Nama Proyek & Klien</th>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Waktu Pelaksanaan</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Status</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="bg-orange-50 text-[#F8931F] font-black px-3 py-1.5 rounded-md border border-orange-100 text-sm tracking-wide">
                                    {{ $project->code }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-gray-900 text-base mb-1">{{ $project->name }}</div>
                                <div class="text-xs font-bold text-gray-500 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    {{ $project->client_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs font-bold text-gray-700 mb-0.5">Mulai: <span class="text-gray-500 font-medium">{{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}</span></div>
                                <div class="text-xs font-bold text-gray-700">Target: <span class="text-gray-500 font-medium">{{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}</span></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1.5 inline-flex text-[10px] font-black uppercase tracking-widest rounded-lg border
                                    @if($project->status == 'planning') bg-gray-100 text-gray-600 border-gray-200
                                    @elseif($project->status == 'ongoing') bg-blue-50 text-blue-700 border-blue-200
                                    @elseif($project->status == 'finished') bg-green-50 text-green-700 border-green-200
                                    @endif">
                                    {{ $project->status == 'ongoing' ? 'Sedang Berjalan' : ($project->status == 'planning' ? 'Perencanaan' : 'Selesai') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('projects.show', $project->id) }}" class="text-[#144C4D] bg-[#E8F1F1] hover:bg-[#144C4D] hover:text-white border border-[#144C4D]/20 p-2 rounded-lg transition shadow-sm" title="Buka Detail Proyek">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('projects.edit', $project->id) }}" class="text-[#F8931F] hover:text-white hover:bg-[#F8931F] border border-[#F8931F] p-2 rounded-lg transition shadow-sm" title="Edit Proyek">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus Proyek ini beserta seluruh data progres dan QC di dalamnya?');" class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 border border-red-500 p-2 rounded-lg transition shadow-sm" title="Hapus Proyek">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <p class="text-gray-500 italic font-medium">
                                    @if(request('search') || request('start_date') || request('sort'))
                                        Pencarian proyek dengan filter tersebut tidak ditemukan.
                                    @else
                                        Belum ada data proyek yang terdaftar.
                                    @endif
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($projects->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $projects->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>