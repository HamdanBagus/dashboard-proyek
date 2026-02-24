<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.qc.index', $project->id) }}" class="text-green-600 hover:underline">Formulir & QC</a>
            <span class="text-gray-400 mx-2">/</span> Persiapan Olah Data 🖥️
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success')) <div class="bg-green-100 text-green-700 p-4 rounded">{{ session('success') }}</div> @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="font-bold text-lg mb-4 border-b pb-2">Informasi Proyek & Titik</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li><strong>Nama Proyek:</strong> {{ $project->name }} ({{ $project->code }})</li>
                    <li><strong>Luas Area:</strong> {{ $project->area_size }} Ha</li>
                    <li><strong>Titik Kontrol:</strong>
                        BM: {{ $project->groundReport->bm_count ?? 0 }},
                        GCP: {{ $project->groundReport->gcp_count ?? 0 }},
                        ICP: {{ $project->groundReport->icp_count ?? 0 }}
                    </li>
                    <li><strong>Pengolah Data:</strong>
                        @foreach($project->personnel->where('pivot.role', 'Pengolah Data') as $p) {{ $p->name }}, @endforeach
                    </li>
                </ul>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="font-bold text-lg mb-4 border-b pb-2 text-green-700">Isian Persiapan Olah Data</h3>
                <form action="{{ route('projects.form.processing.update', $project->id) }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Produk Yang Diminta</label>
                        <textarea name="requested_products" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: Orthophoto, DTM, DSM">{{ $form->requested_products }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ketelitian Produk (Satuan ml)</label>
                        <input type="text" name="product_accuracy" value="{{ $form->product_accuracy }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: 50 ml">
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded font-bold hover:bg-green-700">Simpan Formulir</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
