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
                                    <label class="block text-sm font-medium text-gray-700">Nama Pemasang (Surveyor)</label>
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
                                    <label class="block text-sm font-medium text-gray-700">Nama Pengukur (Surveyor)</label>
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
                                        <option value="">-- Pilih Pengolah Data --</option>
                                        @foreach($pengolahData as $pengolah)
                                            <option value="{{ $pengolah->name }}" {{ $point->process_surveyor == $pengolah->name ? 'selected' : '' }}>
                                                {{ $pengolah->name }}
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

                        <div class="flex justify-end space-x-4">
                            <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-bold">
                                Simpan Progress
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
