<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.qc.index', $project->id) }}" class="text-purple-600 hover:underline">Formulir & QC</a>
            <span class="text-gray-400 mx-2">/</span> Persiapan Ground 🌍
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success')) <div class="bg-green-100 text-green-700 p-4 rounded">{{ session('success') }}</div> @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="font-bold text-lg mb-4 border-b pb-2">Informasi Proyek & Tim</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li><strong>Nama Proyek:</strong> {{ $project->name }}</li>
                    <li><strong>Lokasi:</strong> {{ $project->project_location ?? '-' }}</li>
                    <li><strong>Daftar Peralatan:</strong> GPS ({{ $project->planned_gps }} Unit)</li>
                    <li><strong>Personil:</strong>
                        @foreach($project->personnel->where('pivot.role', 'Surveyor') as $p) {{ $p->name }}, @endforeach
                    </li>
                </ul>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="font-bold text-lg mb-4 border-b pb-2 text-purple-700">Isian Persiapan Ground</h3>
                <form action="{{ route('projects.form.ground.update', $project->id) }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Rencana Titik Kontrol</label>
                        <input type="text" name="planned_control_points" value="{{ $form->planned_control_points }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: 5 BM, 10 ICP">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Nama Titik</label>
                        <input type="text" name="point_codes" value="{{ $form->point_codes }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: BM-01 s/d BM-05">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rencana Titik Ikat</label>
                        <input type="text" name="planned_tie_points" value="{{ $form->planned_tie_points }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: CORS BIG Bandung">
                    </div>
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded font-bold hover:bg-purple-700">Simpan Formulir</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
