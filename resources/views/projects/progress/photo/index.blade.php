<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('projects.progress.index', $project->id) }}" class="text-[#F8931F] hover:underline transition">
                    Log Progress
                </a>
                <span class="text-gray-400 mx-2">/</span>
                Laporan Foto Udara 
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-200 h-full flex flex-col">
                <h3 class="text-lg font-black mb-6 border-b border-gray-100 pb-2 text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Persentase Progress Keseluruhan
                </h3>

                <div class="flex flex-col md:flex-row items-center justify-between bg-[#E8F1F1] p-6 rounded-2xl border border-[#144C4D]/20 shadow-inner flex-1">
                    <div class="flex-1 mb-6 md:mb-0 md:pr-8 text-center md:text-left">
                        <h4 class="text-2xl font-black text-[#144C4D] mb-2">Total Laporan Foto Udara</h4>
                        <p class="text-sm text-[#144C4D]/80 font-medium leading-relaxed mb-6">
                            Kalkulasi otomatis dari rata-rata progres tahapan pengolahan dan ketersediaan file output (deliverables) di seluruh area.
                        </p>
                        <div class="inline-flex items-center">
                            <span class="bg-white text-[#144C4D] px-5 py-2.5 rounded-xl text-sm font-bold border border-gray-200 shadow-sm flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#F8931F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                Terdaftar: {{ $hamparanCount }} Hamparan
                            </span>
                        </div>
                    </div>

                    <div class="relative w-40 h-40 shrink-0 mx-auto md:mx-0">
                        <svg class="w-full h-full transform -rotate-90 drop-shadow-sm" viewBox="0 0 36 36">
                            <path class="text-white/60" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="{{ $pctOverall == 100 ? 'text-green-500' : 'text-[#F8931F]' }}" 
                                  stroke-width="3" stroke-dasharray="{{ $pctOverall }}, 100" stroke="currentColor" fill="none" stroke-linecap="round" 
                                  style="transition: stroke-dasharray 1.5s ease-in-out;" 
                                  d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center flex-col">
                            <span class="text-3xl font-black {{ $pctOverall == 100 ? 'text-green-600' : 'text-[#144C4D]' }}">
                                {{ number_format($pctOverall, 1) }}<span class="text-xl">%</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-200 h-full flex flex-col">
                <h3 class="text-lg font-black mb-6 border-b border-gray-100 pb-2 text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#F8931F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Waktu Pengerjaan
                </h3>
                <form action="{{ route('photo-reports.update', $report->id) }}" method="POST" class="flex flex-col flex-1">
                    @csrf @method('PUT')
                    <div class="space-y-5 flex-1">
                        <div>
                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ $report->start_date }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Tanggal Selesai</label>
                            <input type="date" name="end_date" value="{{ $report->end_date }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-6 bg-[#144C4D] text-white px-5 py-3 rounded-lg text-sm font-bold hover:bg-[#0c2e2e] shadow-sm transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Tanggal
                    </button>
                </form>
            </div>

        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            
            <div class="bg-gray-50 p-6 border-b border-gray-200">
                <h3 class="text-base font-black text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                    Daftar Hamparan (Area)
                </h3>
                
                <form action="{{ route('photo-hamparans.store', $report->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    @csrf
                    <div class="md:col-span-5">
                        <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Nama Area / Hamparan</label>
                        <input type="text" name="name" placeholder="Contoh: Area A (Utara)" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1.5">Luas (Hektar)</label>
                        <input type="number" step="0.01" name="size" placeholder="0.00" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium" required>
                    </div>
                    <div class="md:col-span-3">
                        <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2.5 rounded-lg hover:bg-gray-900 text-sm font-bold shadow-sm transition flex justify-center items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Tambah Hamparan
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                <table class="w-full table-auto divide-y divide-gray-200">
                    <thead class="bg-white sticky top-0 shadow-sm z-10">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Nama Hamparan</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Luas Area</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Progress Gabungan</th>
                            <th class="px-6 py-4 w-32 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($hamparans as $hamparan)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-black text-gray-900 text-base">{{ $hamparan->name }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold text-gray-700 bg-gray-100 px-3 py-1 rounded-lg border border-gray-200">{{ $hamparan->size }} Ha</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-3">
                                    <div class="w-32 bg-gray-200 rounded-full h-2">
                                        <div class="{{ $hamparan->persentase_gabungan == 100 ? 'bg-green-500' : 'bg-[#F8931F]' }} h-2 rounded-full transition-all duration-500 shadow-sm" style="width: {{ $hamparan->persentase_gabungan }}%"></div>
                                    </div>
                                    <span class="text-xs font-black {{ $hamparan->persentase_gabungan == 100 ? 'text-green-600' : 'text-[#144C4D]' }} w-8">{{ number_format($hamparan->persentase_gabungan, 0) }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('photo-hamparans.show', $hamparan->id) }}" class="text-[#144C4D] bg-[#E8F1F1] hover:bg-[#144C4D] hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold border border-[#144C4D]/20 transition flex items-center gap-1.5 shadow-sm" title="Buka Detail">
                                        Detail <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                    <form action="{{ route('photo-hamparans.destroy', $hamparan->id) }}" method="POST" onsubmit="return confirm('Yakin menghapus hamparan ini beserta log tahapan dan output di dalamnya?');" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-white hover:bg-red-500 border border-transparent hover:border-red-500 p-1.5 rounded-lg transition" title="Hapus Hamparan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                                Belum ada hamparan yang didaftarkan. Silakan tambah hamparan baru melalui form di atas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>