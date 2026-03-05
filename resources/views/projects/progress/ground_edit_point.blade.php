<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Update Progress Titik: <span class="text-blue-600">{{ $point->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('ground-points.update', $point->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 mb-6 shadow-sm">
                            <h3 class="font-bold text-lg mb-4 text-gray-800 border-b border-gray-200 pb-2">Informasi Dasar Titik</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama / Kode Titik</label>
                                    <input type="text" name="name" value="{{ $point->name }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-bold text-gray-900" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Jenis Titik</label>
                                    <select name="point_type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-bold text-gray-900" required>
                                        <option value="BM" {{ $point->point_type == 'BM' ? 'selected' : '' }}>BM (Benchmark)</option>
                                        <option value="ICP" {{ $point->point_type == 'ICP' ? 'selected' : '' }}>ICP (Independent Check Point)</option>
                                        <option value="GCP" {{ $point->point_type == 'GCP' ? 'selected' : '' }}>GCP (Ground Control Point)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h3 class="font-bold text-lg mb-4 text-indigo-700 border-b pb-2">1. Pemasangan</h3>

                                <div class="mb-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="install_status" value="1" {{ $point->install_status ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-5 w-5">
                                        <span class="ml-2 text-gray-700 font-bold">Sudah Dipasang?</span>
                                    </label>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Pasang</label>
                                    <input type="date" name="install_date" value="{{ $point->install_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Nama Pemasang</label>
                                    <select name="install_surveyor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">-- Pilih Surveyor --</option>
                                        @foreach($surveyors as $surveyor)
                                            <option value="{{ $surveyor->name }}" {{ $point->install_surveyor == $surveyor->name ? 'selected' : '' }}>
                                                {{ $surveyor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h3 class="font-bold text-lg mb-4 text-blue-700 border-b pb-2">2. Pengukuran</h3>

                                <div class="mb-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="measure_status" value="1" {{ $point->measure_status ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 h-5 w-5">
                                        <span class="ml-2 text-gray-700 font-bold">Sudah Diukur?</span>
                                    </label>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Ukur</label>
                                    <input type="date" name="measure_date" value="{{ $point->measure_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Nama Pengukur</label>
                                    <select name="measure_surveyor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">-- Pilih Surveyor --</option>
                                        @foreach($surveyors as $surveyor)
                                            <option value="{{ $surveyor->name }}" {{ $point->measure_surveyor == $surveyor->name ? 'selected' : '' }}>
                                                {{ $surveyor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h3 class="font-bold text-lg mb-4 text-green-700 border-b pb-2">3. Pengolahan</h3>

                                <div class="mb-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="process_status" value="1" {{ $point->process_status ? 'checked' : '' }} class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500 h-5 w-5">
                                        <span class="ml-2 text-gray-700 font-bold">Sudah Diolah?</span>
                                    </label>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Olah</label>
                                    <input type="date" name="process_date" value="{{ $point->process_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Nama Pengolah Data</label>
                                    <select name="process_surveyor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                        <option value="">-- Pilih Surveyor --</option>
                                        @foreach($surveyors as $person) 
                                            <option value="{{ $person->name }}" {{ $point->process_surveyor == $person->name ? 'selected' : '' }}>
                                                {{ $person->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                            <textarea name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $point->notes }}</textarea>
                        </div>

                        <div class="flex justify-end space-x-4 border-t border-gray-200 pt-6">
                            <a href="{{ url()->previous() }}" class="bg-gray-200 text-gray-700 font-bold px-6 py-2 rounded hover:bg-gray-300 transition">Batal</a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 font-bold transition">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>