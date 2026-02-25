<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Proyek Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Kode Proyek</label>
                                    <input type="text" name="code" value="{{ old('code') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: PRJ-001">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Proyek</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nama Pekerjaan">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Klien</label>
                                    <input type="text" name="client_name" value="{{ old('client_name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Klien</label>
                                    <textarea name="client_address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3">{{ old('client_address') }}</textarea>
                                </div>
                            </div>

                            <div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Luas Area (Ha)</label>
                                    <input type="number" step="0.01" name="area_size" value="{{ old('area_size') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi Proyek</label>
                                    <textarea name="project_location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3">{{ old('project_location') }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
                                    <input type="date" name="start_date" value="{{ old('start_date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Selesai</label>
                                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <h3 class="text-gray-800 text-lg font-bold mb-4">Rencana Kebutuhan Alat (Opsional)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah UAV / Drone</label>
                                    <input type="number" name="planned_uav" value="{{ old('planned_uav', 0) }}" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Alat LiDAR</label>
                                    <input type="number" name="planned_lidar" value="{{ old('planned_lidar', 0) }}" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah GPS Geodetik</label>
                                    <input type="number" name="planned_gps" value="{{ old('planned_gps', 0) }}" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition">
                                Simpan Proyek
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
