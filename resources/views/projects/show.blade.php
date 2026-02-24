<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }} <span class="text-sm text-gray-500">({{ $project->code }})</span>
            </h2>
            <span class="px-3 py-1 text-sm rounded-full
                {{ $project->status == 'finished' ? 'bg-green-200 text-green-800' :
                  ($project->status == 'ongoing' ? 'bg-yellow-200 text-yellow-800' : 'bg-gray-200 text-gray-800') }}">
                {{ ucfirst($project->status) }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('projects.progress.index', $project->id) }}" class="block p-6 bg-blue-600 border border-blue-600 rounded-lg shadow hover:bg-blue-700 transition">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">Log Progress 📊</h5>
                    <p class="font-normal text-blue-100">
                        Input progress harian Ground, UAV, dan Pengolahan Data.
                    </p>
                </a>

                <a href="#" class="block p-6 bg-teal-600 border border-teal-600 rounded-lg shadow hover:bg-teal-700 transition">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">Formulir & QC ✅</h5>
                    <p class="font-normal text-teal-100">
                        Akses formulir persiapan dan checklist Quality Control.
                    </p>
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Proyek</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Klien</p>
                            <p class="font-medium">{{ $project->client_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Luas Area</p>
                            <p class="font-medium">{{ $project->area_size }} Ha</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Lokasi</p>
                            <p class="font-medium">{{ $project->project_location ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Periode</p>
                            <p class="font-medium">
                                {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }} -
                                {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">List Personil</h3>
                        @if(auth()->user()->role === 'admin')
                            <button class="text-xs bg-gray-800 text-white px-3 py-1 rounded">Atur Personil</button>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2">Nama</th>
                                    <th class="px-4 py-2">Peran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($project->personnel as $person)
                                    <tr class="bg-white border-b">
                                        <td class="px-4 py-2">{{ $person->name }}</td>
                                        <td class="px-4 py-2">{{ $person->pivot->role }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-2 text-center italic">Belum ada personil.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">List Peralatan</h3>
                        @if(auth()->user()->role === 'admin')
                            <button class="text-xs bg-gray-800 text-white px-3 py-1 rounded">Atur Alat</button>
                        @endif
                    </div>

                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">Jenis</th>
                                <th class="px-4 py-2">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b">
                                <td class="px-4 py-2">UAV / Drone</td>
                                <td class="px-4 py-2">{{ $project->planned_uav }} Unit</td>
                            </tr>
                            <tr class="bg-white border-b">
                                <td class="px-4 py-2">LiDAR</td>
                                <td class="px-4 py-2">{{ $project->planned_lidar }} Unit</td>
                            </tr>
                            <tr class="bg-white border-b">
                                <td class="px-4 py-2">GPS Geodetik</td>
                                <td class="px-4 py-2">{{ $project->planned_gps }} Unit</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
