@extends('admin.layouts.app')

@section('title', 'Dashboard Administrator')
@section('header', 'Dashboard')

@section('content')

@php
    $statistics = [
        [
            'title' => 'Profil',
            'count' => $profileCount,
            'icon' => 'user-round',
            'iconClass' => 'bg-blue-50 text-blue-600',
            'route' => 'admin.profile.edit',
        ],
        [
            'title' => 'Pendidikan',
            'count' => $educationCount,
            'icon' => 'graduation-cap',
            'iconClass' => 'bg-violet-50 text-violet-600',
            'route' => 'admin.content.index',
            'parameter' => 'educations',
        ],
        [
            'title' => 'Pengalaman',
            'count' => $experienceCount,
            'icon' => 'briefcase-business',
            'iconClass' => 'bg-amber-50 text-amber-600',
            'route' => 'admin.content.index',
            'parameter' => 'experiences',
        ],
        [
            'title' => 'Keahlian',
            'count' => $skillCount,
            'icon' => 'zap',
            'iconClass' => 'bg-emerald-50 text-emerald-600',
            'route' => 'admin.content.index',
            'parameter' => 'skills',
        ],
        [
            'title' => 'Sertifikat',
            'count' => $certificateCount,
            'icon' => 'award',
            'iconClass' => 'bg-pink-50 text-pink-600',
            'route' => 'admin.content.index',
            'parameter' => 'certificates',
        ],
        [
            'title' => 'Proyek',
            'count' => $projectCount,
            'icon' => 'folder-kanban',
            'iconClass' => 'bg-cyan-50 text-cyan-600',
            'route' => 'admin.content.index',
            'parameter' => 'projects',
        ],
        [
            'title' => 'Pesan Masuk',
            'count' => $messageCount,
            'icon' => 'messages-square',
            'iconClass' => 'bg-indigo-50 text-indigo-600',
            'route' => 'admin.messages.index',
        ],
        [
            'title' => 'Belum Dibaca',
            'count' => $unreadMessages,
            'icon' => 'mail',
            'iconClass' => 'bg-red-50 text-red-600',
            'route' => 'admin.messages.index',
        ],
    ];

    $maxActivity = max(1, (int) $activity->max('count'));
@endphp

<div class="space-y-8">

    {{-- WELCOME --}}
    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-700 to-indigo-800 p-6 md:p-8 text-white shadow-lg">
        <div class="relative z-10 max-w-2xl">
            <p class="text-sm font-semibold uppercase tracking-widest text-blue-200">
                Panel Pengelolaan CV
            </p>

            <h1 class="mt-3 text-2xl md:text-3xl font-bold">
                Selamat datang, {{ auth()->user()->name }}!
            </h1>

            <p class="mt-3 text-sm md:text-base leading-7 text-blue-100">
                Kelola profil, pendidikan, pengalaman kerja, keahlian,
                sertifikat, dan portofolio melalui satu dashboard administrator.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('admin.profile.edit') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-blue-700 hover:bg-blue-50 transition">
                    <i data-lucide="user-round" class="w-4 h-4"></i>
                    Edit Profil
                </a>

                <a href="{{ route('home') }}" target="_blank"
                   class="inline-flex items-center gap-2 rounded-xl border border-white/30 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    Lihat Website
                </a>
            </div>
        </div>

        <div class="absolute -right-10 -bottom-24 h-72 w-72 rounded-full bg-white/10"></div>
        <div class="absolute right-28 -top-20 h-48 w-48 rounded-full bg-white/5"></div>
    </section>


    {{-- STATISTICS --}}
    <section>
        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-900">
                    Ringkasan Data
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Jumlah seluruh data yang tersimpan dalam sistem.
                </p>
            </div>

            <span class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700">
                <i data-lucide="database" class="mr-1 inline w-3.5 h-3.5"></i>
                Statistik CV
            </span>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @foreach($statistics as $item)
                <a href="{{ isset($item['parameter'])
                        ? route($item['route'], $item['parameter'])
                        : route($item['route']) }}"
                   class="group rounded-2xl border border-slate-200 bg-white p-5 transition hover:-translate-y-1 hover:shadow-lg">

                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">
                            {{ $item['title'] }}
                        </p>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl {{ $item['iconClass'] }}">
                            <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5"></i>
                        </div>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <h3 class="text-3xl font-bold text-slate-900">
                            {{ number_format($item['count']) }}
                        </h3>

                        <i data-lucide="arrow-up-right"
                           class="h-5 w-5 text-slate-300 transition group-hover:text-blue-600"></i>
                    </div>

                    <p class="mt-2 text-xs text-slate-400">
                        Total data tersimpan
                    </p>
                </a>
            @endforeach
        </div>
    </section>


    {{-- ACTIVITY AND ADMIN INFO --}}
    <section class="grid grid-cols-1 gap-5 xl:grid-cols-3">

        {{-- ACTIVITY CHART --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 xl:col-span-2">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="font-bold text-slate-900">
                        Aktivitas Pesan
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Jumlah pesan pengunjung dalam 7 hari terakhir.
                    </p>
                </div>

                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <span class="h-2.5 w-2.5 rounded-full bg-blue-600"></span>
                    Pesan masuk
                </div>
            </div>

            <div class="mt-8 flex h-48 items-end justify-between gap-3 border-b border-slate-100 pb-2">
                @foreach($activity as $day)
                    @php
                        $barHeight = $day['count'] > 0
                            ? max(8, ($day['count'] / $maxActivity) * 100)
                            : 3;
                    @endphp

                    <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                        <span class="text-xs font-semibold text-slate-600">
                            {{ $day['count'] }}
                        </span>

                        <div class="flex h-full w-full items-end justify-center">
                            <div class="w-full max-w-12 rounded-t-lg bg-blue-600 transition hover:bg-blue-700"
                                 style="height: {{ $barHeight }}%">
                            </div>
                        </div>

                        <span class="text-xs font-medium text-slate-500">
                            {{ $day['label'] }}
                        </span>

                        <span class="text-[10px] text-slate-400">
                            {{ $day['date'] }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 flex items-center justify-between">
                <p class="text-xs text-slate-400">
                    Data aktivitas diperbarui berdasarkan pesan yang masuk.
                </p>

                <a href="{{ route('admin.messages.index') }}"
                   class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                    Lihat semua pesan
                </a>
            </div>
        </div>


        {{-- ADMIN ACCOUNT --}}
        <div class="rounded-2xl bg-slate-950 p-6 text-white">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10">
                <i data-lucide="shield-check" class="h-6 w-6 text-blue-300"></i>
            </div>

            <h2 class="mt-5 text-lg font-bold">
                Administrator
            </h2>

            <p class="mt-2 text-sm leading-6 text-slate-400">
                Anda masuk sebagai administrator dan memiliki akses
                untuk mengelola konten website CV Digital.
            </p>

            <div class="mt-6 border-t border-slate-800 pt-5">
                <p class="text-xs text-slate-500">Nama akun</p>
                <p class="mt-1 font-semibold">
                    {{ auth()->user()->name }}
                </p>

                <p class="mt-4 text-xs text-slate-500">Email akun</p>
                <p class="mt-1 break-all text-sm font-medium">
                    {{ auth()->user()->email }}
                </p>

                <div class="mt-5 inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-2 text-xs font-semibold text-emerald-400">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    Akun aktif
                </div>
            </div>
        </div>
    </section>


    {{-- RECENT MESSAGES --}}
    <section class="grid grid-cols-1 gap-5 xl:grid-cols-2">

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <div>
                    <h2 class="font-bold text-slate-900">
                        Pesan Terbaru
                    </h2>
                    <p class="mt-1 text-xs text-slate-500">
                        Pesan dari pengunjung website.
                    </p>
                </div>

                <a href="{{ route('admin.messages.index') }}"
                   class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                    Lihat semua
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentMessages as $message)
                    <a href="{{ route('admin.messages.show', $message->id) }}"
                       class="flex items-start gap-3 p-5 transition hover:bg-slate-50">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50 font-bold text-blue-700">
                            {{ strtoupper(substr($message->name, 0, 1)) }}
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <p class="truncate text-sm font-semibold text-slate-800">
                                    {{ $message->name }}
                                </p>

                                @if(!$message->is_read)
                                    <span class="rounded-full bg-blue-50 px-2 py-1 text-[10px] font-semibold text-blue-700">
                                        Baru
                                    </span>
                                @else
                                    <span class="text-[10px] text-slate-400">
                                        Dibaca
                                    </span>
                                @endif
                            </div>

                            <p class="mt-1 truncate text-xs text-slate-500">
                                {{ $message->subject ?: 'Tanpa subjek' }}
                            </p>

                            <p class="mt-2 text-[11px] text-slate-400">
                                {{ $message->created_at?->translatedFormat('d M Y, H:i') }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center">
                        <i data-lucide="mail-open" class="mx-auto h-9 w-9 text-slate-300"></i>
                        <p class="mt-3 text-sm font-medium text-slate-600">
                            Belum ada pesan masuk.
                        </p>
                        <p class="mt-1 text-xs text-slate-400">
                            Pesan pengunjung akan muncul di sini.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>


        {{-- RECENT NOTIFICATIONS --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <div>
                    <h2 class="font-bold text-slate-900">
                        Notifikasi Terbaru
                    </h2>
                    <p class="mt-1 text-xs text-slate-500">
                        Informasi aktivitas sistem.
                    </p>
                </div>

                <a href="{{ route('admin.notifications.index') }}"
                   class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                    Lihat semua
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentNotifications as $notification)
                    <div class="flex items-start gap-3 p-5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                            <i data-lucide="bell" class="h-5 w-5"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-semibold text-slate-800">
                                    {{ $notification->data['title'] ?? 'Notifikasi sistem' }}
                                </p>

                                @if(!$notification->read_at)
                                    <span class="h-2 w-2 shrink-0 rounded-full bg-blue-600"></span>
                                @endif
                            </div>

                            <p class="mt-1 text-xs text-slate-500">
                                {{ $notification->data['sender_name'] ?? 'Aktivitas administrator' }}
                            </p>

                            <p class="mt-2 text-[11px] text-slate-400">
                                {{ $notification->created_at?->translatedFormat('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <i data-lucide="bell-ring" class="mx-auto h-9 w-9 text-slate-300"></i>
                        <p class="mt-3 text-sm font-medium text-slate-600">
                            Belum ada notifikasi.
                        </p>
                        <p class="mt-1 text-xs text-slate-400">
                            Notifikasi aktivitas akan muncul di sini.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    {{-- QUICK ACCESS --}}
    <section>
        <div class="mb-5">
            <h2 class="font-bold text-slate-900">
                Akses Cepat
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Pilih bagian website yang ingin Anda kelola.
            </p>
        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-6">

            <a href="{{ route('admin.profile.edit') }}"
               class="rounded-2xl border border-slate-200 bg-white p-4 text-center transition hover:-translate-y-1 hover:shadow-md">
                <i data-lucide="user-round" class="mx-auto h-6 w-6 text-blue-600"></i>
                <p class="mt-3 text-xs font-semibold text-slate-700">Profil</p>
            </a>

            <a href="{{ route('admin.content.index', 'educations') }}"
               class="rounded-2xl border border-slate-200 bg-white p-4 text-center transition hover:-translate-y-1 hover:shadow-md">
                <i data-lucide="graduation-cap" class="mx-auto h-6 w-6 text-violet-600"></i>
                <p class="mt-3 text-xs font-semibold text-slate-700">Pendidikan</p>
            </a>

            <a href="{{ route('admin.content.index', 'experiences') }}"
               class="rounded-2xl border border-slate-200 bg-white p-4 text-center transition hover:-translate-y-1 hover:shadow-md">
                <i data-lucide="briefcase-business" class="mx-auto h-6 w-6 text-amber-600"></i>
                <p class="mt-3 text-xs font-semibold text-slate-700">Pengalaman</p>
            </a>

            <a href="{{ route('admin.content.index', 'skills') }}"
               class="rounded-2xl border border-slate-200 bg-white p-4 text-center transition hover:-translate-y-1 hover:shadow-md">
                <i data-lucide="zap" class="mx-auto h-6 w-6 text-emerald-600"></i>
                <p class="mt-3 text-xs font-semibold text-slate-700">Keahlian</p>
            </a>

            <a href="{{ route('admin.content.index', 'certificates') }}"
               class="rounded-2xl border border-slate-200 bg-white p-4 text-center transition hover:-translate-y-1 hover:shadow-md">
                <i data-lucide="award" class="mx-auto h-6 w-6 text-pink-600"></i>
                <p class="mt-3 text-xs font-semibold text-slate-700">Sertifikat</p>
            </a>

            <a href="{{ route('admin.content.index', 'projects') }}"
               class="rounded-2xl border border-slate-200 bg-white p-4 text-center transition hover:-translate-y-1 hover:shadow-md">
                <i data-lucide="folder-kanban" class="mx-auto h-6 w-6 text-cyan-600"></i>
                <p class="mt-3 text-xs font-semibold text-slate-700">Portofolio</p>
            </a>

        </div>
    </section>

</div>

@endsection