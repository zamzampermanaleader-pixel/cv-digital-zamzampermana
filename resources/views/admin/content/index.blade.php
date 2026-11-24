@extends('admin.layouts.app')

@section('title', $config['title'])
@section('header', $config['title'])

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $config['title'] }}</h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola informasi {{ strtolower($config['title']) }} pada CV Digital Anda.
            </p>
        </div>

        <a href="{{ route('admin.content.create', $module) }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 shadow-sm">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah {{ $config['title'] }}
        </a>
    </div>

    {{-- NOTIFICATION --}}
    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total Data</p>
            <p class="text-2xl font-bold text-gray-800 mt-2">{{ $items->total() }}</p>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Data pada Halaman Ini</p>
            <p class="text-2xl font-bold text-gray-800 mt-2">{{ $items->count() }}</p>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Halaman</p>
            <p class="text-2xl font-bold text-gray-800 mt-2">{{ $items->currentPage() }}</p>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">

        <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-gray-800">Daftar {{ $config['title'] }}</h2>
                <p class="text-xs text-gray-500 mt-1">Informasi yang tersimpan dalam sistem.</p>
            </div>
            <span class="text-xs text-gray-500">Menampilkan {{ $items->count() }} dari {{ $items->total() }} data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-5 py-4 text-left font-semibold">No.</th>

                        @foreach($config['fields'] as $key => $field)
                            @if(!in_array($key, ['description', 'technologies']))
                                <th class="px-5 py-4 text-left font-semibold whitespace-nowrap">
                                    {{ $field['label'] }}
                                </th>
                            @endif
                        @endforeach

                        <th class="px-5 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($items as $index => $item)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-5 py-4 text-gray-500">
                                {{ $items->firstItem() + $index }}
                            </td>

                            @foreach($config['fields'] as $key => $field)
                                @if(!in_array($key, ['description', 'technologies']))
                                    <td class="px-5 py-4 text-gray-700 whitespace-nowrap">

                                        @if($field['type'] === 'checkbox')
                                            @if($item->$key)
                                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                    Ya
                                                </span>
                                            @else
                                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                                    Tidak
                                                </span>
                                            @endif

                                        @elseif(in_array($field['type'], ['image', 'file']))
                                            @if($item->$key)
                                                <span class="inline-flex items-center gap-1 text-blue-600">
                                                    <i data-lucide="file-check" class="w-4 h-4"></i>
                                                    Tersedia
                                                </span>
                                            @else
                                                <span class="text-gray-400">Belum ada</span>
                                            @endif

                                        @elseif($field['type'] === 'date')
                                            {{ $item->$key ? $item->$key->format('d/m/Y') : '-' }}

                                        @else
                                            {{ \Illuminate\Support\Str::limit((string) $item->$key, 45) ?: '-' }}
                                        @endif

                                    </td>
                                @endif
                            @endforeach

                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <div class="flex justify-end items-center gap-2">

                                    <a href="{{ route('admin.content.edit', [$module, $item->id]) }}"
                                       class="inline-flex items-center gap-1 px-3 py-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg text-xs font-semibold">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.content.destroy', [$module, $item->id]) }}"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg text-xs font-semibold">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="20" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                                        <i data-lucide="inbox" class="w-7 h-7 text-gray-400"></i>
                                    </div>
                                    <p class="font-semibold text-gray-700">Belum ada data</p>
                                    <p class="text-sm text-gray-500 mt-1">Silakan tambahkan data pertama Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div class="p-5 border-t border-gray-100">
                {{ $items->links() }}
            </div>
        @endif

    </div>
</div>
@endsection