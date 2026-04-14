<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Operasional') }} 
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col md:flex-row justify-between items-start md:items-center shadow-sm relative overflow-hidden">
                
                <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-[#E8F1F1] to-transparent opacity-60 pointer-events-none"></div>

                <div class="relative z-10">
                    <h3 class="text-2xl font-black text-gray-800">
                        Selamat datang kembali, <span class="text-[#144C4D]">{{ Auth::user()->name ?? 'Tim GSPI' }}</span>! 
                    </h3>
                    <p class="text-sm font-medium text-gray-500 mt-1">
                        Pantau keseluruhan progres proyek dan performa tim Anda hari ini.
                    </p>
                </div>

                <div class="relative z-10 mt-5 md:mt-0 flex items-center bg-[#F4F7F6] border border-gray-200 px-4 py-3 rounded-xl shadow-inner">
                    <div class="bg-white p-2 rounded-lg text-[#F8931F] mr-3 shadow-sm border border-gray-100 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Hari Ini</p>
                        <p class="text-sm font-black text-gray-800">
                            {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

                <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden flex items-center p-6 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gray-800"></div>
                    <div class="p-3 rounded-lg bg-gray-100 text-gray-800 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Keseluruhan</p>
                        <p class="text-3xl font-black text-gray-900">{{ $totalSemuaProyek }}</p>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden flex items-center p-6 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#144C4D]"></div>
                    <div class="p-3 rounded-lg bg-[#E8F1F1] text-[#144C4D] mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Proyek Tahun {{ \Carbon\Carbon::now()->year }}</p>
                        <p class="text-3xl font-black text-[#144C4D]">{{ $totalProyek }}</p>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden flex items-center p-6 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#F8931F]"></div>
                    <div class="p-3 rounded-lg bg-orange-50 text-[#F8931F] mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Sedang Berjalan</p>
                        <p class="text-3xl font-black text-gray-900">{{ $proyekBerjalan }}</p>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden flex items-center p-6 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-500"></div>
                    <div class="p-3 rounded-lg bg-green-50 text-green-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Selesai</p>
                        <p class="text-3xl font-black text-gray-900">{{ $proyekSelesai }}</p>
                    </div>
                </div>

            </div>


            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-5 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                        <h3 class="text-lg font-bold text-gray-800">5 Proyek Terbaru</h3>
                    </div>
                    <a href="{{ route('projects.index') }}" class="text-sm text-[#144C4D] hover:text-[#F8931F] transition font-bold flex items-center gap-1">
                        Lihat Semua Proyek <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-white border-b border-gray-200 text-gray-500">
                            <tr>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">Kode</th>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">Nama Proyek</th>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">Klien</th>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">Tenggat Waktu</th>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($proyekTerbaru as $p)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-black text-gray-900">{{ $p->code }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-700">{{ $p->name }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $p->client_name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-md text-xs font-bold border
                                            {{ \Carbon\Carbon::parse($p->end_date)->isPast() && $p->status != 'finished'
                                                ? 'bg-red-50 text-red-700 border-red-200'
                                                : ($p->status == 'finished' 
                                                    ? 'bg-gray-50 text-gray-600 border-gray-200' 
                                                    : 'bg-green-50 text-green-700 border-green-200') }}">
                                            {{ \Carbon\Carbon::parse($p->end_date)->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('projects.show', $p->id) }}" class="inline-flex items-center justify-center px-4 py-1.5 bg-white border border-gray-300 rounded-md text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-[#F8931F] hover:border-[#F8931F] transition-all shadow-sm">
                                            Buka Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-500 italic">
                                        Belum ada proyek yang ditambahkan ke dalam sistem.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-5 border-b border-gray-200 flex items-center gap-2 bg-gray-50">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    <h3 class="text-lg font-bold text-gray-800">
                        Statistik Total Proyek 5 Tahun Terakhir
                    </h3>
                </div>

                <div class="p-6">
                    <div class="h-[350px] w-full">
                        <canvas id="projectChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const chartData = @json($chartData);

        const labels = chartData.map(item => item.tahun);
        const totals = chartData.map(item => item.total);

        const ctx = document.getElementById('projectChart').getContext('2d');

        // === GRADIENT DARK TEAL (#144C4D) ===
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(20, 76, 77, 0.25)');  // Dark Teal opasitas tinggi
        gradient.addColorStop(1, 'rgba(20, 76, 77, 0.02)');  // Dark Teal transparan di bawah

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Proyek',
                    data: totals,
                    borderColor: '#144C4D', // Garis Dark Teal
                    backgroundColor: gradient,
                    tension: 0.4, // Membuat garis melengkung elegan (curved)
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#F8931F', // Titik Orange
                    pointBorderWidth: 2,
                    pointBorderColor: '#ffffff'
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                animation: {
                    duration: 1400,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { weight: 'bold' },
                        displayColors: false
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6B7280', font: { weight: 'bold' } }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#6B7280',
                            font: { weight: 'bold' }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)',
                            drawBorder: false
                        }
                    }
                }
            }
        });
    </script>

</x-app-layout>