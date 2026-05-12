<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Maintenance UAV
        </h2>
    </x-slot>

    <div class="py-8" x-data="{ showModal: false, editData: {} }">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <form action="{{ route('uav-maintenance.store') }}" method="POST" class="flex items-end gap-4">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Pilih UAV untuk di-Maintenance</label>
                        <select name="asset_uav_id" required class="w-full rounded-lg border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D]">
                            <option value="">-- Pilih UAV --</option>
                            @foreach($uavs as $uav)
                                <option value="{{ $uav->id }}">{{ $uav->name }} (SN: {{ $uav->serial_number ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-[#144C4D] text-white px-6 py-2.5 rounded-lg hover:bg-[#0c2e2e] font-bold shadow-md transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-[10px] font-semibold text-gray-400 uppercase tracking-widest whitespace-nowrap">Info UAV</th>
                    <th class="px-4 py-3 text-left text-[10px] font-semibold text-gray-400 uppercase tracking-widest whitespace-nowrap">Lokasi & Tanggal</th>
                    <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-400 uppercase tracking-widest whitespace-nowrap">KM</th>
                    <th class="px-4 py-3 text-left text-[10px] font-semibold text-gray-400 uppercase tracking-widest min-w-[180px]">Catatan Kendala</th>
                    <th class="px-4 py-3 text-left text-[10px] font-semibold text-gray-400 uppercase tracking-widest min-w-[160px]">Bagian Diganti</th>
                    <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-400 uppercase tracking-widest whitespace-nowrap">Dokumen</th>
                    <th class="px-4 py-3 text-center text-[10px] font-semibold text-gray-400 uppercase tracking-widest whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($maintenances as $item)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">

                        {{-- Info UAV --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-gray-900 text-sm">{{ $item->uav->name }}</div>
                            <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-medium text-gray-500 bg-gray-100 border border-gray-200 rounded tracking-widest uppercase">
                                SN: {{ $item->uav->serial_number ?? 'N/A' }}
                            </span>
                        </td>

                        {{-- Lokasi & Tanggal --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-1 text-[12px] font-semibold text-[#0F6E56] mb-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $item->service_location ?? 'Belum diset' }}
                            </div>
                            <div class="text-[11px] text-gray-500 leading-relaxed">
                                <span class="font-semibold text-amber-500">Kirim:</span>
                                {{ $item->delivery_date ? \Carbon\Carbon::parse($item->delivery_date)->format('d M Y') : '—' }}
                                <br>
                                <span class="font-semibold text-green-600">Kembali:</span>
                                {{ $item->return_date ? \Carbon\Carbon::parse($item->return_date)->format('d M Y') : '—' }}
                            </div>
                        </td>

                        {{-- Kilometer --}}
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <span class="block text-base font-semibold text-gray-800">
                                {{ number_format($item->kilometer ?? 0, 0, ',', '.') }}
                            </span>
                            <span class="text-[10px] font-medium text-gray-400 uppercase tracking-widest">KM</span>
                        </td>

                        {{-- Catatan Kendala --}}
                        <td class="px-4 py-3">
                            <p class="text-xs text-gray-500 italic leading-relaxed">
                                {{ $item->issue_notes ?: '—' }}
                            </p>
                        </td>

                        {{-- Bagian Diganti --}}
                        <td class="px-4 py-3">
                            <p class="text-xs font-medium text-amber-600 leading-relaxed">
                                {{ $item->replaced_parts ?: '—' }}
                            </p>
                        </td>

                        {{-- Dokumen --}}
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            @if($item->documentation)
                                <a href="{{ asset('uploads/' . $item->documentation) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                    Lihat
                                </a>
                            @else
                                <span class="inline-block px-3 py-1.5 text-[10px] font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg">
                                    Kosong
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex justify-center items-center gap-2">
                                {{-- Tombol Edit --}}
                                <button type="button"
                                    @click="
                                        editData = {
                                            id: {{ $item->id }},
                                            uav_name: '{{ $item->uav->name }}',
                                            serial_number: '{{ $item->uav->serial_number }}',
                                            kilometer: '{{ $item->kilometer }}',
                                            service_location: '{{ $item->service_location }}',
                                            delivery_date: '{{ $item->delivery_date }}',
                                            return_date: '{{ $item->return_date }}',
                                            issue_notes: '{{ str_replace([chr(13), chr(10)], ' ', $item->issue_notes) }}',
                                            replaced_parts: '{{ str_replace([chr(13), chr(10)], ' ', $item->replaced_parts) }}'
                                        };
                                        showModal = true;
                                    "
                                    class="p-1.5 text-amber-500 border border-amber-300 rounded-md hover:bg-amber-500 hover:text-white transition-colors"
                                    title="Edit data">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('uav-maintenance.destroy', $item->id) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Yakin ingin menghapus data maintenance ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-red-500 border border-red-300 rounded-md hover:bg-red-500 hover:text-white transition-colors"
                                            title="Hapus data">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-14 text-center">
                            <svg class="w-10 h-10 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <p class="text-sm text-gray-400 italic">Belum ada riwayat maintenance UAV.</p>
                            <p class="text-xs text-gray-400 mt-1">Silakan tambah data baru melalui form di atas.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

        </div>

        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModal" x-transition.opacity @click="showModal = false" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50"></div>
                
                <div x-show="showModal" x-transition class="relative inline-block w-full max-w-2xl p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                    <div class="flex justify-between items-center mb-5 border-b pb-3">
                        <h3 class="text-xl font-black text-gray-800">Update Detail Maintenance</h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>

                    <form x-bind:action="'/uav-maintenance/' + editData.id" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="grid grid-cols-2 gap-4 mb-4 bg-gray-50 p-4 rounded-lg">
                            <div>
                                <label class="block text-xs font-bold text-gray-500">Nama UAV</label>
                                <input type="text" x-model="editData.uav_name" readonly class="mt-1 block w-full bg-gray-100 border-transparent rounded-md text-sm cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500">Serial Number</label>
                                <input type="text" x-model="editData.serial_number" readonly class="mt-1 block w-full bg-gray-100 border-transparent rounded-md text-sm cursor-not-allowed">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Jumlah Kilometer</label>
                                <input type="number" name="kilometer" x-model="editData.kilometer" class="mt-1 block w-full rounded-md border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Lokasi Servis</label>
                                <input type="text" name="service_location" x-model="editData.service_location" class="mt-1 block w-full rounded-md border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Tgl Pengiriman</label>
                                <input type="date" name="delivery_date" x-model="editData.delivery_date" class="mt-1 block w-full rounded-md border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Tgl Pengembalian</label>
                                <input type="date" name="return_date" x-model="editData.return_date" class="mt-1 block w-full rounded-md border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] text-sm">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700">Catatan Kendala</label>
                            <textarea name="issue_notes" x-model="editData.issue_notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] text-sm"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700">Keterangan Bagian Diganti</label>
                            <textarea name="replaced_parts" x-model="editData.replaced_parts" rows="2" class="mt-1 block w-full rounded-md border-gray-300 focus:border-[#144C4D] focus:ring-[#144C4D] text-sm"></textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-700">Dokumentasi (Max 2MB)</label>
                            <input type="file" name="documentation" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#144C4D]/10 file:text-[#144C4D] hover:file:bg-[#144C4D]/20">
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t">
                            <button type="button" @click="showModal = false" class="px-5 py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200">Batal</button>
                            <button type="submit" class="px-5 py-2 bg-[#144C4D] text-white font-bold rounded-lg hover:bg-[#0c2e2e]">Simpan Detail</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
</x-app-layout>