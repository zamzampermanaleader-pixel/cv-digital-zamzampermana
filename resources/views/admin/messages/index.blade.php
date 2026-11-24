@extends('admin.layouts.app')

@section('title', 'Pesan Masuk')
@section('header', 'Manajemen Pesan')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">Pesan Masuk</h1>
        <p class="mt-1 text-sm text-slate-500">
            Kelola pesan dan pertanyaan yang dikirim pengunjung website.
        </p>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Total Pesan</p>
                <span class="rounded-xl bg-blue-100 p-3 text-blue-700">
                    <i data-lucide="mail" class="h-5 w-5"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900">
                {{ number_format($totalMessages) }}
            </p>
            <p class="mt-1 text-xs text-slate-400">Seluruh pesan masuk</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Belum Dibaca</p>
                <span class="rounded-xl bg-amber-100 p-3 text-amber-700">
                    <i data-lucide="mail-open" class="h-5 w-5"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900">
                {{ number_format($unreadMessages) }}
            </p>
            <p class="mt-1 text-xs text-slate-400">Menunggu dibuka</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Sudah Dibaca</p>
                <span class="rounded-xl bg-green-100 p-3 text-green-700">
                    <i data-lucide="mail-check" class="h-5 w-5"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900">
                {{ number_format($readMessages) }}
            </p>
            <p class="mt-1 text-xs text-slate-400">Pesan yang telah dibuka</p>
        </div>

    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <form method="GET" action="{{ route('admin.messages.index') }}"
              class="flex flex-col gap-3 md:flex-row">

            <div class="relative flex-1">
                <i data-lucide="search"
                   class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama, email, subjek, atau isi pesan..."
                    class="w-full rounded-xl border border-slate-300 py-3 pl-10 pr-4 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <select name="status"
                    class="rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>
                    Semua Pesan
                </option>
                <option value="unread" {{ $status === 'unread' ? 'selected' : '' }}>
                    Belum Dibaca
                </option>
                <option value="read" {{ $status === 'read' ? 'selected' : '' }}>
                    Sudah Dibaca
                </option>
            </select>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                <i data-lucide="filter" class="h-4 w-4"></i>
                Cari
            </button>

            <a href="{{ route('admin.messages.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                Reset
            </a>

        </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
            <div>
                <h2 class="font-bold text-slate-800">Daftar Pesan</h2>
                <p class="mt-1 text-xs text-slate-400">
                    Menampilkan {{ $messages->firstItem() ?? 0 }}–{{ $messages->lastItem() ?? 0 }}
                    dari {{ $messages->total() }} pesan
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[750px] text-left text-sm">

                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Pengirim</th>
                        <th class="px-5 py-4">Subjek</th>
                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($messages as $message)
                        <tr class="transition hover:bg-slate-50">

                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700">
                                        {{ strtoupper(substr($message->name, 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">
                                        <p class="font-semibold text-slate-800">
                                            {{ $message->name }}
                                        </p>
                                        <p class="max-w-[220px] truncate text-xs text-slate-500">
                                            {{ $message->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-700">
                                    {{ $message->subject ?: 'Tanpa subjek' }}
                                </p>
                                <p class="mt-1 max-w-xs truncate text-xs text-slate-400">
                                    {{ $message->message }}
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-500">
                                {{ $message->created_at?->format('d M Y') }}
                                <p class="mt-1 text-slate-400">
                                    {{ $message->created_at?->format('H:i') }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                @if($message->is_read)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1.5 text-xs font-semibold text-green-700">
                                        <i data-lucide="check-circle" class="h-3.5 w-3.5"></i>
                                        Dibaca
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-700">
                                        <i data-lucide="circle-dot" class="h-3.5 w-3.5"></i>
                                        Baru
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('admin.messages.show', $message->id) }}"
                                       class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-blue-600 hover:bg-blue-50">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                        Buka
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.messages.destroy', $message->id) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="rounded-lg border border-slate-200 p-2 text-red-600 hover:bg-red-50"
                                                title="Hapus pesan">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-14 text-center">
                                <i data-lucide="inbox" class="mx-auto h-12 w-12 text-slate-300"></i>
                                <p class="mt-3 font-semibold text-slate-700">
                                    Tidak ada pesan ditemukan
                                </p>
                                <p class="mt-1 text-sm text-slate-400">
                                    Pesan akan muncul di sini ketika pengunjung menghubungi Anda.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">
                {{ $messages->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
