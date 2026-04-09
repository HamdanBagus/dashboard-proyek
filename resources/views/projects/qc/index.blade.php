<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                
                <a href="{{ route('projects.show', $project->id) }}" class="text-[#F8931F] hover:underline transition">
                    <span>Detail Proyek</span>
                    {{ $project->code }}
                </a>
                <span class="text-gray-400 mx-2">/</span>
                Menu Quality Control (QC) 
            </h2>
        </div>
    </x-slot>

    <div class="pt-6 pb-12 max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="bg-white px-6 py-4 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Proyek</p>
                <h3 class="text-lg font-black text-gray-800">{{ $project->name }}</h3>
            </div>
            <div class="flex gap-4">
                <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 text-center min-w-[120px]">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">KODE</span>
                    <span class="block text-sm font-black text-[#F8931F]">{{ $project->code }}</span>
                </div>
                <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 text-center min-w-[120px]">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">LUAS</span>
                    <span class="block text-sm font-black text-[#144C4D]">{{ $project->area_size }} Ha</span>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Pilih Tahapan QC
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-[#144C4D] transition-all transform hover:-translate-y-1 flex flex-col h-full overflow-hidden group">
                    <div class="h-2 w-full bg-gray-200 group-hover:bg-[#144C4D] transition-colors"></div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2.5 bg-[#E8F1F1] rounded-lg text-[#144C4D]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900">1. QC Tim Ground</h4>
                        </div>
                        <p class="text-gray-500 text-sm mb-6 flex-1">Verifikasi ketelitian report (BM/GCP/ICP), selisih koordinat Inacors, dan plotting Google Earth.</p>
                        <a href="{{ route('projects.qc.ground', $project->id) }}" class="block w-full text-center bg-gray-50 border border-gray-200 text-gray-700 py-2.5 rounded-lg hover:bg-[#F8931F] hover:text-white hover:border-[#F8931F] font-bold text-sm transition-all shadow-sm">
                            Buka Formulir QC
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-[#144C4D] transition-all transform hover:-translate-y-1 flex flex-col h-full overflow-hidden group">
                    <div class="h-2 w-full bg-gray-200 group-hover:bg-[#144C4D] transition-colors"></div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2.5 bg-[#E8F1F1] rounded-lg text-[#144C4D]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900">2. QC UAV Foto Udara</h4>
                        </div>
                        <p class="text-gray-500 text-sm mb-6 flex-1">Pengecekan kualitas pencahayaan, persentase overlap, ketelitian GSD, dan filter foto blur/berawan.</p>
                        <a href="{{ route('projects.qc.uav_photo', $project->id) }}" class="block w-full text-center bg-gray-50 border border-gray-200 text-gray-700 py-2.5 rounded-lg hover:bg-[#F8931F] hover:text-white hover:border-[#F8931F] font-bold text-sm transition-all shadow-sm">
                            Buka Formulir QC
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-[#144C4D] transition-all transform hover:-translate-y-1 flex flex-col h-full overflow-hidden group">
                    <div class="h-2 w-full bg-gray-200 group-hover:bg-[#144C4D] transition-colors"></div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2.5 bg-[#E8F1F1] rounded-lg text-[#144C4D]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900">3. QC UAV LiDAR</h4>
                        </div>
                        <p class="text-gray-500 text-sm mb-6 flex-1">Inspeksi visual Point Cloud, analisis akurasi vertikal (Z), dan pengecekan ada/tidaknya gap antar jalur terbang.</p>
                        <a href="{{ route('projects.qc.uav_lidar', $project->id) }}" class="block w-full text-center bg-gray-50 border border-gray-200 text-gray-700 py-2.5 rounded-lg hover:bg-[#F8931F] hover:text-white hover:border-[#F8931F] font-bold text-sm transition-all shadow-sm">
                            Buka Formulir QC
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-[#144C4D] transition-all transform hover:-translate-y-1 flex flex-col h-full overflow-hidden group lg:col-span-1 md:col-span-2">
                    <div class="h-2 w-full bg-gray-200 group-hover:bg-[#144C4D] transition-colors"></div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2.5 bg-[#E8F1F1] rounded-lg text-[#144C4D]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900">4. QC Pengolah Data</h4>
                        </div>
                        <p class="text-gray-500 text-sm mb-6 flex-1">Uji statistik CE90/LE90, pemeriksaan orthofoto seamless, filtering noise LiDAR, dan verifikasi struktur folder penyimpanan data.</p>
                        <a href="{{ route('projects.qc.processing', $project->id) }}" class="block w-full text-center bg-gray-50 border border-gray-200 text-gray-700 py-2.5 rounded-lg hover:bg-[#F8931F] hover:text-white hover:border-[#F8931F] font-bold text-sm transition-all shadow-sm">
                            Buka Formulir QC
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-[#144C4D] transition-all transform hover:-translate-y-1 flex flex-col h-full overflow-hidden group lg:col-span-2 md:col-span-2">
                    <div class="h-2 w-full bg-gray-200 group-hover:bg-[#144C4D] transition-colors"></div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2.5 bg-[#E8F1F1] rounded-lg text-[#144C4D]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900">5. QC Project Manager (Final)</h4>
                        </div>
                        <p class="text-gray-500 text-sm mb-6 flex-1">Pengecekan finalisasi seluruh aspek proyek, validasi penulisan laporan teknis, dan pengesahan kelengkapan dokumen pendukung (SLA, Peta, dll).</p>
                        <a href="{{ route('projects.qc.manager', $project->id) }}" class="block w-full text-center bg-[#144C4D] text-white py-2.5 rounded-lg hover:bg-[#0c2e2e] font-bold text-sm transition-all shadow-md">
                            Buka Formulir Pengesahan
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>