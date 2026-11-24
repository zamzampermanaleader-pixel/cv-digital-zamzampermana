@extends('admin.layouts.app')

@section('title', 'Pendidikan')
@section('header', 'Manajemen Pendidikan')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Pendidikan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola riwayat pendidikan yang ditampilkan pada CV digital.</p>
        </div>

        <a href="{{ route('admin.content.create', 'educations') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah Pendidikan
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white border rounded-2xl p-5">
            <p class="text-sm text-gray-500">Total Pendidikan</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $items->total() }}</p>
        </div>
        <div class="bg-white border rounded-2xl p-5">
            <p class="text-sm text-gray-500">Ditampilkan di CV</p>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $items->getCollection()->where('is_visible', true)->count() }}</p>
        </div>
        <div class="bg-white border rounded-2xl p-5">
            <p class="text-sm text-gray-500">Halaman</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $items->currentPage() }}</p>
        </div>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-5 border-b">
            <h2 class="font-bold text-gray-800">Daftar Pendidikan</h2>
            <p class="text-sm text-gray-500 mt-1">Informasi pendidikan yang sudah tersimpan.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-5 py-4 text-left">No.</th>
                        <th class="px-5 py-4 text-left">Institusi</th>
                        <th class="px-5 py-4 text-left">Gelar / Jenjang</th>
                        <th class="px-5 py-4 text-left">Bidang Studi</th>
                        <th class="px-5 py-4 text-left">Periode</th>
                        <th class="px-5 py-4 text-left">Status</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($items as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 text-gray-500">{{ $items->firstItem() + $index }}</td>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-gray-800">{{ $item->institution }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $item->location ?: 'Lokasi belum diisi' }}</p>
                            </td>
                            <td class="px-5 py-4">{{ $item->degree ?: '-' }}</td>
                            <td class="px-5 py-4">{{ $item->field_of_study ?: '-' }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                {{ $item->start_date?->format('Y') ?: '-' }}
                                -
                                {{ $item->is_current ? 'Sekarang' : ($item->end_date?->format('Y') ?: '-') }}
                            </td>
                            <td class="px-5 py-4">
                                @if($item->is_visible)
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Ditampilkan</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">Disembunyikan</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.content.edit', ['educations', $item->id]) }}"
                                       class="px-3 py-2 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-semibold">
                                        Edit
                                    </a>
                                    <form method="POST"
                                          action="{{ route('admin.content.destroy', ['educations', $item->id]) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus pendidikan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-2 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 text-xs font-semibold">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="graduation-cap" class="w-12 h-12 text-gray-300 mb-3"></i>
                                    <p class="font-semibold text-gray-700">Belum ada riwayat pendidikan</p>
                                    <p class="text-sm text-gray-500 mt-1">Tambahkan pendidikan pertama Anda.</p>
                                    <a href="{{ route('admin.content.create', 'educations') }}"
                                       class="mt-4 text-blue-600 font-semibold hover:underline">Tambah sekarang</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div class="p-5 border-t">{{ $items->links() }}</div>
        @endif
    </div>
</div>
@endsection