<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} 📊
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            
            <!-- CARD STATISTIK -->

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white shadow-sm rounded-lg border-l-4 border-blue-500 flex items-center p-6">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 text-3xl mr-4">📁</div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Proyek (Tahun Ini)</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalProyek }}</p>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-lg border-l-4 border-green-500 flex items-center p-6">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 text-3xl mr-4">⏳</div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Sedang Berjalan</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $proyekBerjalan }}</p>
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-lg border-l-4 border-gray-800 flex items-center p-6">
                    <div class="p-3 rounded-full bg-gray-200 text-gray-800 text-3xl mr-4">✅</div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Selesai</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $proyekSelesai }}</p>
                    </div>
                </div>

            </div>


            <!-- TABEL PROYEK TERBARU -->

            <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">5 Proyek Terbaru</h3>
                    <a href="{{ route('projects.index') }}"
                       class="text-sm text-blue-600 hover:underline font-semibold">
                       Lihat Semua Proyek →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="p-4 font-semibold">Kode</th>
                                <th class="p-4 font-semibold">Nama Proyek</th>
                                <th class="p-4 font-semibold">Klien</th>
                                <th class="p-4 font-semibold">Tenggat Waktu</th>
                                <th class="p-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse($proyekTerbaru as $p)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 font-bold text-gray-900">{{ $p->code }}</td>
                                    <td class="p-4 text-gray-700">{{ $p->name }}</td>
                                    <td class="p-4 text-gray-700">{{ $p->client_name }}</td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 rounded text-xs font-bold
                                            {{ \Carbon\Carbon::parse($p->end_date)->isPast()
                                                ? 'bg-gray-200 text-gray-800'
                                                : 'bg-green-100 text-green-800' }}">
                                            {{ \Carbon\Carbon::parse($p->end_date)->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <a href="{{ route('projects.show', $p->id) }}"
                                           class="text-blue-600 hover:underline font-bold text-xs">
                                           Buka Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="p-6 text-center text-gray-500 italic">
                                        Belum ada proyek yang ditambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

            <!-- LINE CHART -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">
                    📈 Tren Total Proyek 5 Tahun Terakhir
                </h3>

                <div class="h-[350px]">
                    <canvas id="projectChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <!-- CHART SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const chartData = @json($chartData);

    const labels = chartData.map(item => item.tahun);
    const totals = chartData.map(item => item.total);

    const ctx = document.getElementById('projectChart').getContext('2d');

    // === GRADIENT PROFESSIONAL ===
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)');  // soft blue top
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0.02)');  // fade bottom

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Proyek',
                data: totals,
                borderColor: '#2563EB',
                backgroundColor: gradient,
                tension: 0.4,
                fill: true,
                borderWidth: 3,
                pointRadius: 3,
                pointHoverRadius: 6,
                pointBackgroundColor: '#2563EB',
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
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6B7280'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color: '#6B7280'
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                }
            }
        }
    });
</script>

</x-app-layout>
