<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.show', $project->id) }}" class="text-teal-600 hover:underline">
                {{ $project->code }}
            </a>
            <span class="text-gray-400 mx-2">/</span>
            Quality Control (QC) ✅
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b border-gray-300 pb-2">🔍 Menu Quality Control (QC)</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-red-500 hover:shadow-md transition transform hover:-translate-y-1">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-2">1. QC Tim Ground</h4>
                            <p class="text-gray-500 text-sm mb-4 h-12">Cek ketelitian report, selisih koordinat Inacors, dan plot Google Earth.</p>
                            <a href="{{ route('projects.qc.ground', $project->id) }}" class="block w-full text-center bg-red-100 text-red-700 py-2 rounded hover:bg-red-200 font-bold text-sm transition">Buka Checklist QC</a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-orange-500 hover:shadow-md transition transform hover:-translate-y-1">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-2">2. QC UAV Foto Udara</h4>
                            <p class="text-gray-500 text-sm mb-4 h-12">Cek kualitas cahaya, overlap, GSD < 10cm, dan blur/berawan.</p>
                            <a href="{{ route('projects.qc.uav_photo', $project->id) }}" class="block w-full text-center bg-orange-100 text-orange-700 py-2 rounded hover:bg-orange-200 font-bold text-sm transition">Buka Checklist QC</a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-yellow-500 hover:shadow-md transition transform hover:-translate-y-1">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-2">3. QC UAV LiDAR</h4>
                            <p class="text-gray-500 text-sm mb-4 h-12">Cek gap antar lajur dan akurasi vertikal Point Cloud.</p>
                            <a href="{{ route('projects.qc.uav_lidar', $project->id) }}" class="block w-full text-center bg-yellow-100 text-yellow-700 py-2 rounded hover:bg-yellow-200 font-bold text-sm transition">Buka Checklist QC</a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-teal-500 hover:shadow-md transition transform hover:-translate-y-1">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-2">4. QC Pengolah Data</h4>
                            <p class="text-gray-500 text-sm mb-4 h-12">Cek ketelitian CE90/LE90, orthofoto seamless, noise Lidar, penamaan file.</p>
                            <a href="{{ route('projects.qc.processing', $project->id) }}" class="block w-full text-center bg-teal-100 text-teal-700 py-2 rounded hover:bg-teal-200 font-bold text-sm transition">Buka Checklist QC</a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-800 hover:shadow-md transition transform hover:-translate-y-1">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-2">5. QC Project Manager</h4>
                            <p class="text-gray-500 text-sm mb-4 h-12">Pengecekan final penulisan laporan dan nomenklatur dokumen.</p>
                            <a href="{{ route('projects.qc.manager', $project->id) }}" class="block w-full text-center bg-gray-200 text-gray-800 py-2 rounded hover:bg-gray-300 font-bold text-sm transition">Buka Checklist QC</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
