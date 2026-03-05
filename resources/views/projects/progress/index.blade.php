<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.show', $project->id) }}" class="text-blue-600 hover:underline">
                {{ $project->name }}
            </a>
            <span class="text-gray-400 mx-2">/</span>
            Log Progress
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500 hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-indigo-700">Tim Ground 🌍</h3>
                            <span class="text-xs px-2 py-1 rounded font-bold shadow-sm
                                {{ $groundProgress == 100 ? 'bg-green-100 text-green-800' : ($groundProgress > 0 ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-600') }}">
                                {{ number_format($groundProgress, 1) }}% Selesai
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4">
                            <div class="{{ $groundProgress == 100 ? 'bg-green-500' : 'bg-indigo-500' }} h-1.5 rounded-full transition-all duration-1000" style="width: {{ $groundProgress }}%"></div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Monitoring pemasangan BM, ICP, GCP, dan pengukuran titik kontrol.</p>
                        <a href="{{ route('projects.ground.index', $project->id) }}" class="block w-full text-center bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 font-bold transition shadow-sm">
                            Buka Laporan Ground
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500 hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-blue-700">Tim UAV 🚁</h3>
                            <span class="text-xs px-2 py-1 rounded font-bold shadow-sm
                                {{ $uavProgress == 100 ? 'bg-green-100 text-green-800' : ($uavProgress > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600') }}">
                                {{ number_format($uavProgress, 1) }}% Selesai
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4">
                            <div class="{{ $uavProgress == 100 ? 'bg-green-500' : 'bg-blue-500' }} h-1.5 rounded-full transition-all duration-1000" style="width: {{ $uavProgress }}%"></div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Log penerbangan pilot, area akuisisi, dan monitoring flight.</p>
                        <a href="{{ route('projects.uav.index', $project->id) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 font-bold transition shadow-sm">
                            Buka Laporan UAV
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500 hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-green-700">Olah Foto Udara 📸</h3>
                            <span class="text-xs px-2 py-1 rounded font-bold shadow-sm
                                {{ $photoProgress == 100 ? 'bg-green-100 text-green-800' : ($photoProgress > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600') }}">
                                {{ number_format($photoProgress, 1) }}% Selesai
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4">
                            <div class="bg-green-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $photoProgress }}%"></div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Progress hamparan, aerotriangulasi, dan output orthophoto.</p>
                        <a href="{{ route('projects.photo.index', $project->id) }}" class="block w-full text-center bg-green-600 text-white py-2 rounded hover:bg-green-700 font-bold transition shadow-sm">
                            Buka Laporan Foto
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-orange-500 hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-orange-700">Olah LiDAR 📡</h3>
                            <span class="text-xs px-2 py-1 rounded font-bold shadow-sm
                                {{ $lidarProgress == 100 ? 'bg-green-100 text-green-800' : ($lidarProgress > 0 ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-600') }}">
                                {{ number_format($lidarProgress, 1) }}% Selesai
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4">
                            <div class="{{ $lidarProgress == 100 ? 'bg-green-500' : 'bg-orange-500' }} h-1.5 rounded-full transition-all duration-1000" style="width: {{ $lidarProgress }}%"></div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Progress klasifikasi point cloud, DTM, dan kontur.</p>
                        <a href="{{ route('projects.lidar.index', $project->id) }}" class="block w-full text-center bg-orange-600 text-white py-2 rounded hover:bg-orange-700 font-bold transition shadow-sm">
                            Buka Laporan Lidar
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>