<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Proyek') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                        <h3 class="text-lg font-bold w-full sm:w-auto">Daftar Proyek</h3>

                        <div class="flex w-full sm:w-auto space-x-2">
                            <form action="{{ route('projects.index') }}" method="GET" class="flex w-full sm:w-auto">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / Kode..." class="rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full text-sm">
                                <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-r-md border border-l-0 border-gray-300 text-sm transition">
                                    Cari
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('projects.index') }}" class="ml-2 text-red-500 hover:text-red-700 flex items-center text-sm font-bold">Batal</a>
                                @endif
                            </form>

                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('projects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md whitespace-nowrap text-sm transition">
                                    + Tambah Proyek Baru
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Kode</th>
                                    <th class="py-3 px-6 text-left">Nama Proyek</th>
                                    <th class="py-3 px-6 text-left">Klien</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse($projects as $project)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium">{{ $project->code }}</td>
                                    <td class="py-3 px-6 text-left">{{ $project->name }}</td>
                                    <td class="py-3 px-6 text-left">{{ $project->client_name }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs font-bold">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center space-x-2">
                                            <a href="{{ route('projects.show', $project->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            @if(auth()->user()->role === 'admin')
                                                <a href="{{ route('projects.edit', $project->id) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('projects.destroy', $project->id) }}" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-6 px-6 text-center text-gray-500 italic">
                                        @if(request('search'))
                                            Proyek dengan kata kunci "<strong>{{ request('search') }}</strong>" tidak ditemukan.
                                        @else
                                            Belum ada data proyek.
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $projects->withQueryString()->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
