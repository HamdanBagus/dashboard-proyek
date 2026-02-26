<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Proyek: ') }} <span class="text-blue-600">{{ $project->code }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <strong class="font-bold">Gagal Menyimpan!</strong>
                            <ul class="list-disc pl-5 mt-2 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('projects.update', $project->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            <div class="space-y-6">

                                <div class="space-y-4">
                                    <h3 class="font-bold border-b pb-2 text-blue-700">Informasi Dasar</h3>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Kode Proyek</label>
                                        <input type="text" name="code" value="{{ old('code', $project->code) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Proyek</label>
                                        <input type="text" name="name" value="{{ old('name', $project->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Klien</label>
                                        <input type="text" name="client_name" value="{{ old('client_name', $project->client_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Alamat Klien</label>
                                        <textarea name="client_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('client_address', $project->client_address) }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Lokasi Proyek</label>
                                        <textarea name="project_location" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('project_location', $project->project_location) }}</textarea>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <h3 class="font-bold border-b pb-2 text-blue-700">Detail Pelaksanaan</h3>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Luas Area (Ha)</label>
                                        <input type="number" step="0.01" name="area_size" value="{{ old('area_size', $project->area_size) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                            <input type="date" name="start_date" value="{{ old('start_date', $project->start_date) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                            <input type="date" name="end_date" value="{{ old('end_date', $project->end_date) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">Status Proyek Saat Ini</label>
                                        <select name="status" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-base font-bold text-gray-800 bg-gray-50">
                                            <option value="planning" {{ old('status', $project->status) == 'planning' ? 'selected' : '' }}>🟠 Planning (Perencanaan)</option>
                                            <option value="ongoing" {{ old('status', $project->status) == 'ongoing' ? 'selected' : '' }}>🟡 Ongoing (Sedang Berjalan)</option>
                                            <option value="finished" {{ old('status', $project->status) == 'finished' ? 'selected' : '' }}>🟢 Finished (Selesai)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <h3 class="font-bold border-b pb-2 text-blue-700">Rencana Kebutuhan Alat (Opsional)</h3>
                                    <div class="grid grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700">Jml UAV / Drone</label>
                                            <input type="number" name="planned_uav" value="{{ old('planned_uav', $project->planned_uav) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700">Jml Alat LiDAR</label>
                                            <input type="number" name="planned_lidar" value="{{ old('planned_lidar', $project->planned_lidar) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700">Jml GPS</label>
                                            <input type="number" name="planned_gps" value="{{ old('planned_gps', $project->planned_gps) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="space-y-6 bg-gray-50 p-6 rounded-lg border border-gray-200">
                                <h3 class="font-bold border-b border-gray-300 pb-2 text-indigo-700 text-lg">Detail Persiapan Proyek</h3>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jml Rencana Take OFF</label>
                                        <input type="number" name="takeoff_count" value="{{ old('takeoff_count', $project->takeoff_count) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jml Titik Kontrol</label>
                                        <input type="number" name="control_point_count" value="{{ old('control_point_count', $project->control_point_count) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500">
                                    </div>
                                </div>

                                <div x-data="{ items: {{ json_encode(old('products', !empty($project->products) ? $project->products : [''])) }} }">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Produk Yang Dihasilkan</label>
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex gap-2 mb-2">
                                            <input type="text" x-model="items[index]" name="products[]" placeholder="Contoh: Peta Ortho" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 text-sm">
                                            <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1" class="bg-red-500 text-white px-3 rounded hover:bg-red-600 font-bold transition">X</button>
                                        </div>
                                    </template>
                                    <button type="button" @click="items.push('')" class="text-xs bg-indigo-100 text-indigo-700 font-bold px-3 py-1 rounded hover:bg-indigo-200 mt-1 transition">+ Tambah Produk</button>
                                </div>

                                <div x-data="{ items: {{ json_encode(old('product_specs', !empty($project->product_specs) ? $project->product_specs : [''])) }} }">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Spesifikasi Produk</label>
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex gap-2 mb-2">
                                            <input type="text" x-model="items[index]" name="product_specs[]" placeholder="Contoh: Skala 1:1000" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 text-sm">
                                            <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1" class="bg-red-500 text-white px-3 rounded hover:bg-red-600 font-bold transition">X</button>
                                        </div>
                                    </template>
                                    <button type="button" @click="items.push('')" class="text-xs bg-indigo-100 text-indigo-700 font-bold px-3 py-1 rounded hover:bg-indigo-200 mt-1 transition">+ Tambah Spesifikasi</button>
                                </div>

                                <div x-data="{ items: {{ json_encode(old('point_codes', !empty($project->point_codes) ? $project->point_codes : [''])) }} }">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Kode Nama Titik (GCP/ICP)</label>
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex gap-2 mb-2">
                                            <input type="text" x-model="items[index]" name="point_codes[]" placeholder="Contoh: BMDSG" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 text-sm">
                                            <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1" class="bg-red-500 text-white px-3 rounded hover:bg-red-600 font-bold transition">X</button>
                                        </div>
                                    </template>
                                    <button type="button" @click="items.push('')" class="text-xs bg-indigo-100 text-indigo-700 font-bold px-3 py-1 rounded hover:bg-indigo-200 mt-1 transition">+ Tambah Kode Titik</button>
                                </div>

                                <div x-data="{ items: {{ json_encode(old('tie_points', !empty($project->tie_points) ? $project->tie_points : [''])) }} }">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Rencana Titik Ikat</label>
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex gap-2 mb-2">
                                            <input type="text" x-model="items[index]" name="tie_points[]" placeholder="Contoh: BIG / CORS" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 text-sm">
                                            <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1" class="bg-red-500 text-white px-3 rounded hover:bg-red-600 font-bold transition">X</button>
                                        </div>
                                    </template>
                                    <button type="button" @click="items.push('')" class="text-xs bg-indigo-100 text-indigo-700 font-bold px-3 py-1 rounded hover:bg-indigo-200 mt-1 transition">+ Tambah Titik Ikat</button>
                                </div>

                            </div>

                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                            <a href="{{ route('projects.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded transition">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-md transition">Simpan Perubahan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
