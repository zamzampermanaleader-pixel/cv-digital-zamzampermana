@extends('admin.layouts.app')

@section('title', 'Notifikasi')
@section('header', 'Notifikasi Admin')

@section('content')
<div class="mx-auto max-w-6xl space-y-6">

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Notifikasi</h1>
            <p class="mt-1 text-sm text-slate-500">
                Pantau aktivitas dan pesan terbaru dari pengunjung website.
            </p>
        </div>

        @if($unreadCount > 0)
            <form method="POST" action="{{ route('admin.notifications.read-all') }}">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                    <i data-lucide="check-check" class="h-4 w-4"></i>
                    Tandai semua dibaca
                </button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Total Notifikasi</p>
                <span class="rounded-xl bg-blue-100 p-3 text-blue-700">
                    <i data-lucide="bell" class="h-5 w-5"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900">
                {{ number_format($totalNotifications) }}
            </p>
            <p class="mt-1 text-xs text-slate-400">Seluruh aktivitas tercatat</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Belum Dibaca</p>
                <span class="rounded-xl bg-amber-100 p-3 text-amber-700">
                    <i data-lucide="bell-ring" class="h-5 w-5"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900">
                {{ number_format($unreadCount) }}
            </p>
            <p class="mt-1 text-xs text-slate-400">Notifikasi yang perlu diperiksa</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="font-bold text-slate-800">Aktivitas Terbaru</h2>
            <p class="mt-1 text-xs text-slate-400">
                Menampilkan {{ $notifications->firstItem() ?? 0 }}–{{ $notifications->lastItem() ?? 0 }}
                dari {{ $notifications->total() }} notifikasi
            </p>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($notifications as $notification)
                @php($data = $notification->data)
                @php($messageId = $data['message_id'] ?? null)

                <div class="flex flex-col gap-4 p-5 transition hover:bg-slate-50 sm:flex-row sm:items-center">

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl
                        {{ $notification->read_at ? 'bg-slate-100 text-slate-500' : 'bg-blue-100 text-blue-700' }}">
                        <i data-lucide="{{ $notification->read_at ? 'mail-check' : 'mail' }}"
                           class="h-5 w-5"></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <p class="font-semibold text-slate-800">
                                {{ $data['title'] ?? 'Notifikasi baru' }}
                            </p>

                            @unless($notification->read_at)
                                <span class="rounded-full bg-blue-100 px-2.5 py-1 text-[10px] font-bold uppercase text-blue-700">
                                    Baru
                                </span>
                            @endunless
                        </div>

                        <p class="mt-1 text-sm text-slate-600">
                            {{ $data['sender_name'] ?? 'Pengunjung' }}
                            — {{ $data['subject'] ?? 'Pesan baru' }}
                        </p>

                        <p class="mt-2 text-xs text-slate-400">
                            <i data-lucide="clock" class="mr-1 inline h-3 w-3"></i>
                            {{ $notification->created_at?->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div class="flex shrink-0 flex-wrap gap-2">
                        <form method="POST"
                              action="{{ route('admin.notifications.read', $notification->id) }}">
                            @csrf

                            <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-blue-600 hover:bg-blue-50">
                                <i data-lucide="{{ $messageId ? 'external-link' : 'check' }}"
                                   class="h-4 w-4"></i>
                                {{ $messageId ? 'Buka' : 'Tandai dibaca' }}
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="px-5 py-16 text-center">
                    <i data-lucide="bell-off" class="mx-auto h-12 w-12 text-slate-300"></i>
                    <p class="mt-3 font-semibold text-slate-700">Belum ada notifikasi</p>
                    <p class="mt-1 text-sm text-slate-400">
                        Notifikasi akan muncul ketika ada aktivitas baru.
                    </p>
                </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">
                {{ $notifications->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
