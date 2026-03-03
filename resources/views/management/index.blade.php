<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Asset & Karyawan 🏢
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        @if(session('success')) <div class="bg-green-100 text-green-700 p-4 rounded">{{ session('success') }}</div> @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <h3 class="font-bold text-lg mb-4 border-b pb-2 text-blue-700">1. Daftar Karyawan</h3>
                <form action="{{ route('management.employee.store') }}" method="POST" class="flex gap-2 mb-4">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Karyawan Baru" required class="w-full rounded border-gray-300 text-sm">
                    <button type="submit" class="bg-blue-600 text-white px-4 rounded hover:bg-blue-700 text-sm font-bold">Tambah</button>
                </form>
                <div class="max-h-64 overflow-y-auto">
                    <table class="w-full text-sm text-left border">
                        <tbody>
                            @foreach($employees as $emp)
                            <tr class="border-b">
                                <td class="p-2">{{ $emp->name }}</td>
                                <td class="p-2 text-right">
                                    <form action="{{ route('management.employee.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('Hapus karyawan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <h3 class="font-bold text-lg mb-4 border-b pb-2 text-orange-700">2. Daftar Asset UAV</h3>
                <form action="{{ route('management.uav.store') }}" method="POST" class="flex gap-2 mb-4">
                    @csrf
                    <input type="text" name="name" placeholder="Tipe/Nama UAV Baru" required class="w-full rounded border-gray-300 text-sm">
                    <button type="submit" class="bg-orange-600 text-white px-4 rounded hover:bg-orange-700 text-sm font-bold">Tambah</button>
                </form>
                <div class="max-h-64 overflow-y-auto">
                    <table class="w-full text-sm text-left border">
                        <tbody>
                            @foreach($uavs as $uav)
                            <tr class="border-b">
                                <td class="p-2">{{ $uav->name }}</td>
                                <td class="p-2 text-right">
                                    <form action="{{ route('management.uav.destroy', $uav->id) }}" method="POST" onsubmit="return confirm('Hapus UAV ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <h3 class="font-bold text-lg mb-4 border-b pb-2 text-purple-700">3. Daftar Asset Kamera</h3>
                <form action="{{ route('management.camera.store') }}" method="POST" class="flex gap-2 mb-4">
                    @csrf
                    <input type="text" name="name" placeholder="Tipe/Nama Kamera Baru" required class="w-full rounded border-gray-300 text-sm">
                    <button type="submit" class="bg-purple-600 text-white px-4 rounded hover:bg-purple-700 text-sm font-bold">Tambah</button>
                </form>
                <div class="max-h-64 overflow-y-auto">
                    <table class="w-full text-sm text-left border">
                        <tbody>
                            @foreach($cameras as $cam)
                            <tr class="border-b">
                                <td class="p-2">{{ $cam->name }}</td>
                                <td class="p-2 text-right">
                                    <form action="{{ route('management.camera.destroy', $cam->id) }}" method="POST" onsubmit="return confirm('Hapus Kamera ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <h3 class="font-bold text-lg mb-4 border-b pb-2 text-teal-700">4. Daftar Asset PC / Laptop</h3>
                <form action="{{ route('management.pc.store') }}" method="POST" class="flex gap-2 mb-4">
                    @csrf
                    <input type="text" name="name" placeholder="Nama PC (Cth: PC Panther)" required class="w-1/2 rounded border-gray-300 text-sm">
                    <input type="text" name="spec" placeholder="Spesifikasi (Opsional)" class="w-1/2 rounded border-gray-300 text-sm">
                    <button type="submit" class="bg-teal-600 text-white px-4 rounded hover:bg-teal-700 text-sm font-bold">Tambah</button>
                </form>
                <div class="max-h-64 overflow-y-auto">
                    <table class="w-full text-sm text-left border">
                        <tbody>
                            @foreach($pcs as $pc)
                            <tr class="border-b">
                                <td class="p-2 font-bold">{{ $pc->name }} <span class="font-normal text-xs text-gray-500 block">{{ $pc->spec }}</span></td>
                                <td class="p-2 text-right">
                                    <form action="{{ route('management.pc.destroy', $pc->id) }}" method="POST" onsubmit="return confirm('Hapus PC ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-indigo-700 border-b pb-2">Manajemen Unit GPS</h3>
                
                <div class="mb-6 bg-indigo-50 p-4 rounded border border-indigo-200">
                    <form action="{{ route('management.gps.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Merek / Nama GPS</label>
                            <input type="text" name="name" placeholder="Contoh: Trimble R8s" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Tipe GPS</label>
                            <input type="text" name="type" list="gps_types" placeholder="Contoh: Geodetik Base" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm">
                            <datalist id="gps_types">
                                <option value="Geodetik Base">
                                <option value="Geodetik Rover">
                                <option value="Handheld">
                                <option value="Echosounder">
                            </datalist>
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm font-bold transition">
                                + Tambah GPS
                            </button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama GPS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase w-1 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($gps_units as $gps)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $gps->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $gps->type ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('management.gps.destroy', $gps->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus GPS ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-white hover:bg-red-500 font-bold border border-red-500 px-3 py-1 rounded transition text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500 italic">Belum ada unit GPS yang terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
