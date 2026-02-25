<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Proyek: ') }} {{ $project->code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('projects.update', $project->id) }}" method="POST">
                        @csrf
                        @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h3 class="font-bold border-b pb-2 text-blue-700">Informasi Dasar</h3>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Proyek</label>
                                    <input type="text" name="name" value="{{ old('name', $project->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kode Proyek</label>
                                    <input type="text" name="code" value="{{ old('code', $project->code) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Klien</label>
                                    <input type="text" name="client_name" value="{{ old('client_name', $project->client_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Alamat Klien</label>
                                    <textarea name="client_address" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('client_address', $project->client_address) }}</textarea>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h3 class="font-bold border-b pb-2 text-blue-700">Detail Teknis & Pelaksanaan</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Luas Area (Ha)</label>
                                        <input type="number" step="0.01" name="area_size" value="{{ old('area_size', $project->area_size) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Lokasi Proyek</label>
                                        <input type="text" name="project_location" value="{{ old('project_location', $project->project_location) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                        <input type="date" name="start_date" value="{{ old('start_date', $project->start_date) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                        <input type="date" name="end_date" value="{{ old('end_date', $project->end_date) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </div>
                                </div>

                                <h3 class="font-bold border-b pb-2 text-blue-700 mt-6">Rencana Alat (Opsional)</h3>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jml UAV</label>
                                        <input type="number" name="planned_uav" value="{{ old('planned_uav', $project->planned_uav) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jml LiDAR</label>
                                        <input type="number" name="planned_lidar" value="{{ old('planned_lidar', $project->planned_lidar) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jml GPS</label>
                                        <input type="number" name="planned_gps" value="{{ old('planned_gps', $project->planned_gps) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('projects.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan Perubahan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
