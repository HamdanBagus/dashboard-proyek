<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('projects.uav.index', $project->id) }}" class="text-[#F8931F] hover:underline transition">
                    Laporan Tim UAV
                </a>
                <span class="text-gray-400 mx-2">/</span>
                Rekap Performa Pilot 
            </h2>
        </div>
    </x-slot>

    <div class="pt-6 pb-12 max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-t-4 border-[#144C4D]">
            <h3 class="text-xl font-black text-gray-900 flex items-center gap-2">
                <svg class="w-6 h-6 text-[#F8931F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Statistik Performa Pilot UAV
            </h3>
            <p class="text-sm text-gray-500 mt-2">Data berikut menampilkan rekapitulasi <strong>seluruh log penerbangan</strong> (semua status) yang dikerjakan oleh masing-masing pilot pada proyek <span class="font-bold text-[#144C4D] bg-[#E8F1F1] px-2 py-0.5 rounded">{{ $project->name }}</span>.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            @forelse($pilotStats as $index => $stat)
                <div x-data="{ open: false }" class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 hover:shadow-md transition-shadow flex flex-col min-w-0">
                    
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="bg-[#144C4D] text-white rounded-lg w-8 h-8 flex items-center justify-center font-black text-sm shadow-sm">
                                {{ $index + 1 }}
                            </div>
                            <h4 class="font-black text-lg text-gray-800">{{ $stat['name'] }}</h4>
                        </div>
                        <div class="text-[#F8931F] bg-orange-50 p-2 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-white p-4 rounded-xl border border-gray-200 text-center shadow-sm hover:shadow-md transition transform hover:-translate-y-0.5">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Total Akuisisi</p>
                                <p class="text-2xl font-black text-[#144C4D]">{{ number_format($stat['total_area'], 1) }} <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Ha</span></p>
                            </div>
                            <div class="bg-white p-4 rounded-xl border border-gray-200 text-center shadow-sm hover:shadow-md transition transform hover:-translate-y-0.5">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Total Flight</p>
                                <p class="text-2xl font-black text-[#F8931F]">{{ $stat['flight_count'] }} <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Flight</span></p>
                            </div>
                        </div>

                        <div class="space-y-4 border-t border-gray-100 pt-5 mb-5">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Jumlah Hari Terbang:</span>
                                <span class="text-sm font-black text-gray-800 bg-gray-100 border border-gray-200 px-3 py-1 rounded-lg">{{ $stat['days_flown'] }} Hari</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Rata-rata Kemampuan / Hari:</span>
                                <span class="text-sm font-black text-green-700 bg-green-50 border border-green-200 px-3 py-1 rounded-lg shadow-sm">{{ number_format($stat['average_per_day'], 2) }} Ha/Hari</span>
                            </div>
                        </div>

                        <div class="mt-auto border-t border-gray-100 pt-5">
                            <button type="button" @click="open = !open" class="flex items-center justify-center w-full text-xs font-bold text-[#144C4D] hover:text-white hover:bg-[#144C4D] transition-all bg-[#E8F1F1] py-2.5 rounded-lg border border-[#144C4D]/20 gap-2">
                                <span x-show="!open">Tampilkan Detail Log Penerbangan</span>
                                <span x-show="open" style="display: none;">Sembunyikan Detail Log</span>
                                <svg class="w-4 h-4 transform transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="open" style="display: none;" x-transition class="mt-4 overflow-x-auto border border-gray-200 rounded-xl max-h-64 overflow-y-auto shadow-inner bg-gray-50">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-white sticky top-0 shadow-sm z-10">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Unit UAV</th>
                                            <th class="px-4 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Hasil & Jml</th>
                                            <th class="px-4 py-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        @foreach($stat['logs'] as $log)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-3 whitespace-nowrap text-xs font-bold text-gray-900">
                                                {{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-xs font-bold text-[#144C4D]">
                                                {{ $log->uav->name ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                                <div class="font-black text-gray-800 text-sm">{{ $log->area_acquired }} Ha</div>
                                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ $log->flight_count }} Flight</div>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="px-2 py-1 inline-flex text-[10px] font-black uppercase tracking-widest rounded-md border
                                                    {{ $log->status == 'Finished Flight' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                                    {{ $log->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-12 rounded-xl shadow-sm text-center border border-gray-200">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    <p class="text-gray-500 italic">Belum ada data log penerbangan yang tercatat di proyek ini.</p>
                </div>
            @endforelse
        </div>

        <div class="flex justify-start border-t border-gray-200 pt-6">
            <a href="{{ route('projects.uav.index', $project->id) }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Laporan UAV
            </a>
        </div>

    </div>
</x-app-layout>