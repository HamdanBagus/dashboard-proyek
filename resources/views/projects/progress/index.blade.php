<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('projects.show', $project->id) }}" class="text-[#F8931F] hover:underline transition">
                    <span>Proyek</span>
                    {{ $project->name }}
                </a>
                <span class="text-gray-400 mx-2">/</span>
                Log Progress
            </h2>
        </div>
    </x-slot>

    <div class="pt-6 pb-12 max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="bg-white px-6 py-4 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Status Proyek</p>
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-black text-gray-800">{{ $project->code }}</h3>
                    <span class="px-3 py-1 text-[10px] rounded-full font-bold shadow-sm uppercase tracking-widest border
                        @if($project->status == 'planning') bg-gray-50 text-gray-600 border-gray-200
                        @elseif($project->status == 'ongoing') bg-blue-50 text-blue-700 border-blue-200
                        @elseif($project->status == 'finished') bg-green-50 text-green-700 border-green-200
                        @endif">
                        {{ $project->status == 'ongoing' ? 'Sedang Berjalan' : ($project->status == 'planning' ? 'Perencanaan' : 'Selesai') }}
                    </span>
                </div>
            </div>
            
            <div class="flex items-center gap-3 bg-[#F4F7F6] px-4 py-2.5 rounded-lg border border-gray-200">
                <div class="text-right">
                    <span class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest">Total Keseluruhan</span>
                    <span class="block text-sm font-black text-[#144C4D]">{{ number_format(($groundProgress + $uavProgress + $photoProgress + $lidarProgress) / 4, 1) }}% Selesai</span>
                </div>
                <svg class="w-8 h-8 text-[#144C4D] opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>

        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2 flex items-center gap-2 mt-8">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Pilih Divisi / Tim
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-[#144C4D] transition-all transform hover:-translate-y-1 flex flex-col h-full overflow-hidden group">
                <div class="h-2 w-full bg-gray-200 group-hover:bg-[#144C4D] transition-colors"></div>
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-[#E8F1F1] rounded-lg text-[#144C4D]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Tim Ground</h3>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-md font-bold shadow-sm uppercase tracking-widest border
                            {{ $groundProgress == 100 ? 'bg-green-50 text-green-700 border-green-200' : ($groundProgress > 0 ? 'bg-[#F4F7F6] text-[#144C4D] border-[#144C4D]/30' : 'bg-gray-50 text-gray-500 border-gray-200') }}">
                            {{ number_format($groundProgress, 1) }}%
                        </span>
                    </div>
                    
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mb-5 overflow-hidden">
                        <div class="{{ $groundProgress == 100 ? 'bg-green-500' : 'bg-[#144C4D]' }} h-1.5 rounded-full transition-all duration-1000" style="width: {{ $groundProgress }}%"></div>
                    </div>
                    
                    <p class="text-gray-500 text-sm mb-6 flex-1">Monitoring progres pemasangan BM, ICP, GCP, serta log pengukuran titik kontrol di lapangan.</p>
                    
                    <a href="{{ route('projects.ground.index', $project->id) }}" class="block w-full text-center bg-gray-50 border border-gray-200 text-gray-700 py-2.5 rounded-lg hover:bg-[#144C4D] hover:text-white hover:border-[#144C4D] font-bold text-sm transition-all shadow-sm">
                        Buka Laporan Ground
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-[#144C4D] transition-all transform hover:-translate-y-1 flex flex-col h-full overflow-hidden group">
                <div class="h-2 w-full bg-gray-200 group-hover:bg-[#144C4D] transition-colors"></div>
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-[#E8F1F1] rounded-lg text-[#144C4D]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Tim UAV</h3>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-md font-bold shadow-sm uppercase tracking-widest border
                            {{ $uavProgress == 100 ? 'bg-green-50 text-green-700 border-green-200' : ($uavProgress > 0 ? 'bg-[#F4F7F6] text-[#144C4D] border-[#144C4D]/30' : 'bg-gray-50 text-gray-500 border-gray-200') }}">
                            {{ number_format($uavProgress, 1) }}%
                        </span>
                    </div>
                    
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mb-5 overflow-hidden">
                        <div class="{{ $uavProgress == 100 ? 'bg-green-500' : 'bg-[#144C4D]' }} h-1.5 rounded-full transition-all duration-1000" style="width: {{ $uavProgress }}%"></div>
                    </div>
                    
                    <p class="text-gray-500 text-sm mb-6 flex-1">Rekap log penerbangan pilot, status area akuisisi, laporan kendala cuaca, dan monitoring total *flight*.</p>
                    
                    <a href="{{ route('projects.uav.index', $project->id) }}" class="block w-full text-center bg-gray-50 border border-gray-200 text-gray-700 py-2.5 rounded-lg hover:bg-[#144C4D] hover:text-white hover:border-[#144C4D] font-bold text-sm transition-all shadow-sm">
                        Buka Laporan UAV
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-[#F8931F] transition-all transform hover:-translate-y-1 flex flex-col h-full overflow-hidden group">
                <div class="h-2 w-full bg-gray-200 group-hover:bg-[#F8931F] transition-colors"></div>
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-orange-50 rounded-lg text-[#F8931F]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Pengolahan Foto Udara</h3>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-md font-bold shadow-sm uppercase tracking-widest border
                            {{ $photoProgress == 100 ? 'bg-green-50 text-green-700 border-green-200' : ($photoProgress > 0 ? 'bg-orange-50 text-[#F8931F] border-[#F8931F]/30' : 'bg-gray-50 text-gray-500 border-gray-200') }}">
                            {{ number_format($photoProgress, 1) }}%
                        </span>
                    </div>
                    
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mb-5 overflow-hidden">
                        <div class="{{ $photoProgress == 100 ? 'bg-green-500' : 'bg-[#F8931F]' }} h-1.5 rounded-full transition-all duration-1000" style="width: {{ $photoProgress }}%"></div>
                    </div>
                    
                    <p class="text-gray-500 text-sm mb-6 flex-1">Progres tahapan per-hamparan (alignment, aerotriangulasi, densifikasi) dan status generasi *orthophoto*.</p>
                    
                    <a href="{{ route('projects.photo.index', $project->id) }}" class="block w-full text-center bg-gray-50 border border-gray-200 text-gray-700 py-2.5 rounded-lg hover:bg-[#F8931F] hover:text-white hover:border-[#F8931F] font-bold text-sm transition-all shadow-sm">
                        Buka Laporan Foto Udara
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-[#F8931F] transition-all transform hover:-translate-y-1 flex flex-col h-full overflow-hidden group">
                <div class="h-2 w-full bg-gray-200 group-hover:bg-[#F8931F] transition-colors"></div>
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-orange-50 rounded-lg text-[#F8931F]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Pengolahan LiDAR</h3>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-md font-bold shadow-sm uppercase tracking-widest border
                            {{ $lidarProgress == 100 ? 'bg-green-50 text-green-700 border-green-200' : ($lidarProgress > 0 ? 'bg-orange-50 text-[#F8931F] border-[#F8931F]/30' : 'bg-gray-50 text-gray-500 border-gray-200') }}">
                            {{ number_format($lidarProgress, 1) }}%
                        </span>
                    </div>
                    
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mb-5 overflow-hidden">
                        <div class="{{ $lidarProgress == 100 ? 'bg-green-500' : 'bg-[#F8931F]' }} h-1.5 rounded-full transition-all duration-1000" style="width: {{ $lidarProgress }}%"></div>
                    </div>
                    
                    <p class="text-gray-500 text-sm mb-6 flex-1">Progres tahapan Trajectory, kalibrasi *Point Cloud*, klasifikasi DTM/DSM, dan pembentukan garis kontur per hamparan.</p>
                    
                    <a href="{{ route('projects.lidar.index', $project->id) }}" class="block w-full text-center bg-gray-50 border border-gray-200 text-gray-700 py-2.5 rounded-lg hover:bg-[#F8931F] hover:text-white hover:border-[#F8931F] font-bold text-sm transition-all shadow-sm">
                        Buka Laporan LiDAR
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>