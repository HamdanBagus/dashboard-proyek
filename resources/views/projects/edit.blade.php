<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('projects.index') }}" class="text-[#F8931F] hover:underline transition">
                    Daftar Proyek
                </a>
                <span class="text-gray-400 mx-2">/</span>
                {{ __('Edit Proyek: ') }} <span class="text-[#144C4D] font-black">{{ $project->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="pt-6 pb-12 max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-5 rounded-xl shadow-sm mb-6">
                <div class="flex items-center gap-2 font-black text-lg mb-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                    Gagal Menyimpan Perubahan!
                </div>
                <ul class="list-disc pl-8 text-sm font-medium space-y-1 text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            <div class="p-6 sm:p-8">
                
                <form action="{{ route('projects.update', $project->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                        <div class="lg:col-span-7 space-y-8">

                            <div class="space-y-5">
                                <h3 class="text-lg font-black border-b border-gray-100 pb-2 text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Informasi Dasar
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Kode Proyek</label>
                                        <input type="text" name="code" value="{{ old('code', $project->code) }}" required placeholder="Contoh: PRJ-001"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Nama Proyek</label>
                                        <input type="text" name="name" value="{{ old('name', $project->name) }}" required placeholder="Nama Pekerjaan"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Nama Klien</label>
                                    <input type="text" name="client_name" value="{{ old('client_name', $project->client_name) }}" required placeholder="Nama Instansi/Perusahaan"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Alamat Klien</label>
                                    <textarea name="client_address" rows="2" placeholder="Alamat lengkap instansi..."
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">{{ old('client_address', $project->client_address) }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Lokasi Proyek</label>
                                    <textarea name="project_location" rows="2" placeholder="Kecamatan, Kabupaten/Kota, Provinsi..."
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">{{ old('project_location', $project->project_location) }}</textarea>
                                </div>
                            </div>

                            <div class="space-y-5">
                                <h3 class="text-lg font-black border-b border-gray-100 pb-2 text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#F8931F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Detail Pelaksanaan
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Luas Area (Hektar)</label>
                                        <input type="number" step="0.01" name="area_size" value="{{ old('area_size', $project->area_size) }}" required placeholder="0.00"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Status Proyek Saat Ini</label>
                                        <select name="status" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-bold text-gray-800 bg-gray-50">
                                            <option value="planning" {{ old('status', $project->status) == 'planning' ? 'selected' : '' }}>🟠 Planning (Perencanaan)</option>
                                            <option value="ongoing" {{ old('status', $project->status) == 'ongoing' ? 'selected' : '' }}>🟡 Ongoing (Sedang Berjalan)</option>
                                            <option value="finished" {{ old('status', $project->status) == 'finished' ? 'selected' : '' }}>🟢 Finished (Selesai)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Tanggal Mulai</label>
                                        <input type="date" name="start_date" value="{{ old('start_date', $project->start_date) }}" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Tanggal Selesai</label>
                                        <input type="date" name="end_date" value="{{ old('end_date', $project->end_date) }}" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] sm:text-sm font-medium">
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h3 class="text-lg font-black border-b border-gray-100 pb-2 text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#144C4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    Rencana Kebutuhan Alat
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div x-data="{ items: {{ json_encode(old('planned_uavs', is_array($project->planned_uavs) && count($project->planned_uavs) > 0 ? $project->planned_uavs : [['id' => '', 'qty' => 1]])) }} }" class="bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm">
                                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 border-b border-gray-200 pb-1">UAV / Drone</label>
                                        <template x-for="(item, index) in items" :key="index">
                                            <div class="flex gap-2 mb-3">
                                                <select :name="'planned_uavs['+index+'][id]'" x-model="item.id" class="block w-2/3 rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] sm:text-sm font-medium">
                                                    <option value="">-- Pilih UAV --</option>
                                                    @foreach($uavs as $uav)
                                                        <option value="{{ $uav->name }}">{{ $uav->name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="number" :name="'planned_uavs['+index+'][qty]'" x-model="item.qty" min="1" placeholder="Qty" class="block w-1/4 rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] sm:text-sm font-medium text-center">
                                                <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1" class="w-10 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg font-black transition flex justify-center items-center">X</button>
                                            </div>
                                        </template>
                                        <button type="button" @click="items.push({id: '', qty: 1})" class="text-[10px] bg-white border border-gray-300 text-gray-600 font-bold px-3 py-1.5 rounded-lg hover:bg-gray-100 transition uppercase tracking-widest">+ Tambah UAV</button>
                                    </div>

                                    <div x-data="{ items: {{ json_encode(old('planned_cameras', is_array($project->planned_cameras) && count($project->planned_cameras) > 0 ? $project->planned_cameras : [['id' => '', 'qty' => 1]])) }} }" class="bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm">
                                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 border-b border-gray-200 pb-1">Kamera / Sensor</label>
                                        <template x-for="(item, index) in items" :key="index">
                                            <div class="flex gap-2 mb-3">
                                                <select :name="'planned_cameras['+index+'][id]'" x-model="item.id" class="block w-2/3 rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] sm:text-sm font-medium">
                                                    <option value="">-- Pilih Sensor --</option>
                                                    @foreach($cameras as $cam)
                                                        <option value="{{ $cam->name }}">{{ $cam->name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="number" :name="'planned_cameras['+index+'][qty]'" x-model="item.qty" min="1" placeholder="Qty" class="block w-1/4 rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] sm:text-sm font-medium text-center">
                                                <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1" class="w-10 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg font-black transition flex justify-center items-center">X</button>
                                            </div>
                                        </template>
                                        <button type="button" @click="items.push({id: '', qty: 1})" class="text-[10px] bg-white border border-gray-300 text-gray-600 font-bold px-3 py-1.5 rounded-lg hover:bg-gray-100 transition uppercase tracking-widest">+ Tambah Sensor</button>
                                    </div>

                                    <div x-data="{ items: {{ json_encode(old('planned_gps', is_array($project->planned_gps) && count($project->planned_gps) > 0 ? $project->planned_gps : [['id' => '', 'qty' => 1]])) }} }" class="bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm">
                                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 border-b border-gray-200 pb-1">GPS (Geodetik)</label>
                                        <template x-for="(item, index) in items" :key="index">
                                            <div class="flex gap-2 mb-3">
                                                <select :name="'planned_gps['+index+'][id]'" x-model="item.id" class="block w-2/3 rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] sm:text-sm font-medium">
                                                    <option value="">-- Pilih GPS --</option>
                                                    @foreach($gps_units as $gps)
                                                        <option value="{{ $gps->name }}">{{ $gps->name }} ({{ $gps->type }})</option>
                                                    @endforeach
                                                </select>
                                                <input type="number" :name="'planned_gps['+index+'][qty]'" x-model="item.qty" min="1" placeholder="Qty" class="block w-1/4 rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] sm:text-sm font-medium text-center">
                                                <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1" class="w-10 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg font-black transition flex justify-center items-center">X</button>
                                            </div>
                                        </template>
                                        <button type="button" @click="items.push({id: '', qty: 1})" class="text-[10px] bg-white border border-gray-300 text-gray-600 font-bold px-3 py-1.5 rounded-lg hover:bg-gray-100 transition uppercase tracking-widest">+ Tambah GPS</button>
                                    </div>

                                    <div x-data="{ items: {{ json_encode(old('planned_pcs', is_array($project->planned_pcs) && count($project->planned_pcs) > 0 ? $project->planned_pcs : [['id' => '', 'qty' => 1]])) }} }" class="bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm">
                                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 border-b border-gray-200 pb-1">PC / Workstation</label>
                                        <template x-for="(item, index) in items" :key="index">
                                            <div class="flex gap-2 mb-3">
                                                <select :name="'planned_pcs['+index+'][id]'" x-model="item.id" class="block w-2/3 rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] sm:text-sm font-medium">
                                                    <option value="">-- Pilih PC --</option>
                                                    @foreach($pcs as $pc)
                                                        <option value="{{ $pc->name }}">{{ $pc->name }}</option>
                                                    @endforeach
                                                    <option value="Laptop Pribadi">Laptop Pribadi</option>
                                                </select>
                                                <input type="number" :name="'planned_pcs['+index+'][qty]'" x-model="item.qty" min="1" placeholder="Qty" class="block w-1/4 rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] sm:text-sm font-medium text-center">
                                                <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1" class="w-10 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg font-black transition flex justify-center items-center">X</button>
                                            </div>
                                        </template>
                                        <button type="button" @click="items.push({id: '', qty: 1})" class="text-[10px] bg-white border border-gray-300 text-gray-600 font-bold px-3 py-1.5 rounded-lg hover:bg-gray-100 transition uppercase tracking-widest">+ Tambah PC</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="lg:col-span-5 space-y-6">
                            <div class="bg-[#F4F7F6] p-6 rounded-2xl border border-[#144C4D]/20 shadow-inner h-full flex flex-col">
                                <h3 class="font-black border-b border-[#144C4D]/20 pb-3 text-[#144C4D] text-lg flex items-center gap-2 mb-5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    Detail Persiapan & Output
                                </h3>

                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Rencana Take OFF</label>
                                        <input type="number" name="takeoff_count" value="{{ old('takeoff_count', $project->takeoff_count) }}" min="0"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F8931F] focus:ring-[#F8931F] font-bold text-lg text-[#F8931F]">
                                    </div>
                                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Rencana Titik Kontrol</label>
                                        <input type="number" name="control_point_count" value="{{ old('control_point_count', $project->control_point_count) }}" min="0"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] focus:ring-[#144C4D] font-bold text-lg text-[#144C4D]">
                                    </div>
                                </div>

                                <div x-data="{ items: {{ json_encode(old('products', !empty($project->products) ? $project->products : [''])) }} }" class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-4">
                                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Produk Yang Dihasilkan</label>
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex gap-2 mb-2">
                                            <input type="text" x-model="items[index]" name="products[]" placeholder="Contoh: Peta Ortho"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] sm:text-sm font-medium">
                                            <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1"
                                                class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-3 rounded-lg font-black transition flex justify-center items-center">X</button>
                                        </div>
                                    </template>
                                    <button type="button" @click="items.push('')" class="text-[10px] bg-[#E8F1F1] text-[#144C4D] font-bold px-3 py-1.5 rounded-lg hover:bg-[#144C4D] hover:text-white mt-1 transition uppercase tracking-widest">+ Tambah Produk</button>
                                </div>

                                <div x-data="{ items: {{ json_encode(old('product_specs', !empty($project->product_specs) ? $project->product_specs : [''])) }} }" class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-4">
                                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Spesifikasi Produk</label>
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex gap-2 mb-2">
                                            <input type="text" x-model="items[index]" name="product_specs[]" placeholder="Contoh: Skala 1:1000"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] sm:text-sm font-medium">
                                            <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1"
                                                class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-3 rounded-lg font-black transition flex justify-center items-center">X</button>
                                        </div>
                                    </template>
                                    <button type="button" @click="items.push('')" class="text-[10px] bg-[#E8F1F1] text-[#144C4D] font-bold px-3 py-1.5 rounded-lg hover:bg-[#144C4D] hover:text-white mt-1 transition uppercase tracking-widest">+ Tambah Spesifikasi</button>
                                </div>

                                <div x-data="{ items: {{ json_encode(old('point_codes', !empty($project->point_codes) ? $project->point_codes : [''])) }} }" class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-4">
                                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Kode Titik (GCP/ICP)</label>
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex gap-2 mb-2">
                                            <input type="text" x-model="items[index]" name="point_codes[]" placeholder="Contoh: BMDSG"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] sm:text-sm font-medium uppercase">
                                            <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1"
                                                class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-3 rounded-lg font-black transition flex justify-center items-center">X</button>
                                        </div>
                                    </template>
                                    <button type="button" @click="items.push('')" class="text-[10px] bg-[#E8F1F1] text-[#144C4D] font-bold px-3 py-1.5 rounded-lg hover:bg-[#144C4D] hover:text-white mt-1 transition uppercase tracking-widest">+ Tambah Kode Titik</button>
                                </div>

                                <div x-data="{ items: {{ json_encode(old('tie_points', !empty($project->tie_points) ? $project->tie_points : [''])) }} }" class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Rencana Titik Ikat</label>
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex gap-2 mb-2">
                                            <input type="text" x-model="items[index]" name="tie_points[]" placeholder="Contoh: BIG / CORS"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#144C4D] sm:text-sm font-medium uppercase">
                                            <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1"
                                                class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-3 rounded-lg font-black transition flex justify-center items-center">X</button>
                                        </div>
                                    </template>
                                    <button type="button" @click="items.push('')" class="text-[10px] bg-[#E8F1F1] text-[#144C4D] font-bold px-3 py-1.5 rounded-lg hover:bg-[#144C4D] hover:text-white mt-1 transition uppercase tracking-widest">+ Tambah Titik Ikat</button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col-reverse sm:flex-row justify-end gap-3">
                        <a href="{{ route('projects.index') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition shadow-sm text-center text-sm">
                            Batal
                        </a>
                        <button type="submit" class="bg-[#144C4D] hover:bg-[#0c2e2e] text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition text-center text-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>