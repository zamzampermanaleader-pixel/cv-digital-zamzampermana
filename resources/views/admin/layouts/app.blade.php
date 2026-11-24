<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard') | {{ \App\Models\Setting::where('key', 'site_title')->value('value') ?: 'CV Digital' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
        }

        .sidebar-link {
            transition: all .2s ease;
        }

        .sidebar-link:hover {
            transform: translateX(3px);
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

@php
    $currentModule = request()->route('module') ?? '';
    $siteTitle = \App\Models\Setting::where('key', 'site_title')->value('value') ?: 'CV Digital';
    $unreadCount = \App\Models\Message::where('is_read', false)->count();
    $unreadNotifications = auth()->user()->unreadNotifications()->count();

    $activeClass = 'bg-blue-600 text-white shadow-lg shadow-blue-900/20';
    $inactiveClass = 'text-slate-400 hover:bg-slate-800 hover:text-white';
@endphp

<div class="min-h-screen">

    <!-- MOBILE OVERLAY -->
    <div id="sidebarOverlay"
         class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"
         onclick="toggleSidebar()">
    </div>

    <!-- SIDEBAR -->
    <aside id="adminSidebar"
           class="fixed top-0 left-0 z-50 h-screen w-72 bg-slate-950 text-white flex flex-col -translate-x-full md:translate-x-0 transition-transform duration-300">

        <!-- BRAND -->
        <div class="px-6 py-7 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center">
                    <i data-lucide="briefcase-business" class="w-6 h-6"></i>
                </div>

                <div>
                    <h1 class="text-lg font-bold tracking-wide">{{ strtoupper($siteTitle) }}</h1>
                    <p class="text-xs text-slate-400">Administrator Panel</p>
                </div>
            </div>
        </div>

        <!-- NAVIGATION -->
        <div class="flex-1 overflow-y-auto sidebar-scroll px-4 py-6">

            <p class="text-[10px] font-bold tracking-[2px] text-slate-500 uppercase px-3 mb-3">
                Menu Utama
            </p>

            <nav class="space-y-1">

                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.profile.edit') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.profile.*') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="user-round" class="w-5 h-5"></i>
                    Profil Saya
                </a>

            </nav>

            <p class="text-[10px] font-bold tracking-[2px] text-slate-500 uppercase px-3 mt-8 mb-3">
                Manajemen CV
            </p>

            <nav class="space-y-1">

                <a href="{{ route('admin.content.index', 'educations') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $currentModule === 'educations' ? $activeClass : $inactiveClass }}">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                    Pendidikan
                </a>

                <a href="{{ route('admin.content.index', 'experiences') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $currentModule === 'experiences' ? $activeClass : $inactiveClass }}">
                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                    Pengalaman
                </a>

                <a href="{{ route('admin.content.index', 'skills') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $currentModule === 'skills' ? $activeClass : $inactiveClass }}">
                    <i data-lucide="brain" class="w-5 h-5"></i>
                    Keahlian
                </a>

                <a href="{{ route('admin.content.index', 'certificates') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $currentModule === 'certificates' ? $activeClass : $inactiveClass }}">
                    <i data-lucide="award" class="w-5 h-5"></i>
                    Sertifikat
                </a>

                <a href="{{ route('admin.content.index', 'projects') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $currentModule === 'projects' ? $activeClass : $inactiveClass }}">
                    <i data-lucide="folder-kanban" class="w-5 h-5"></i>
                    Portofolio
                </a>

                <a href="{{ route('admin.content.index', 'social-links') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $currentModule === 'social-links' ? $activeClass : $inactiveClass }}">
                    <i data-lucide="share-2" class="w-5 h-5"></i>
                    Media Sosial
                </a>

            </nav>

            <p class="text-[10px] font-bold tracking-[2px] text-slate-500 uppercase px-3 mt-8 mb-3">
                Sistem
            </p>

            <nav class="space-y-1">

                <a href="{{ route('admin.messages.index') }}"
                   class="sidebar-link flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.messages.*') ? $activeClass : $inactiveClass }}">

                    <span class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                        Pesan Masuk
                    </span>

                    @if($unreadCount > 0)
                        <span class="text-xs bg-red-500 text-white rounded-full px-2 py-1">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.notifications.index') }}"
                   class="sidebar-link flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.notifications.*') ? $activeClass : $inactiveClass }}">
                    <span class="flex items-center gap-3">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        Notifikasi
                    </span>
                    @if($unreadNotifications > 0)
                        <span class="text-xs bg-amber-500 text-white rounded-full px-2 py-1">
                            {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.security.password') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.security.*') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                    Keamanan Akun
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.users.*') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    Manajemen Admin
                </a>

                
                <a href="{{ route('admin.settings.index') }}"
                class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.settings.*') ? $activeClass : $inactiveClass }}">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    Pengaturan Website
                </a>


            </nav>

            <div class="mt-8">
                <a href="{{ route('home') }}" target="_blank"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-emerald-400 hover:bg-slate-800">
                    <i data-lucide="external-link" class="w-5 h-5"></i>
                    Lihat Website Publik
                </a>
            </div>

        </div>

        <!-- ADMIN SIDEBAR PROFILE -->
        <div class="border-t border-slate-800 p-4">
            <div class="flex items-center gap-3 mb-4">

                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold truncate">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-slate-400 truncate">
                        {{ auth()->user()->email }}
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf

                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-red-400 hover:bg-red-500/10 transition">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    Keluar dari Panel
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <div class="min-h-screen md:ml-72">

        <!-- HEADER -->
        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-slate-200">

            <div class="h-20 px-5 md:px-8 flex items-center justify-between">

                <div class="flex items-center gap-4">

                    <button id="sidebarToggle"
                            type="button"
                            onclick="toggleSidebar()"
                            aria-label="Buka menu navigasi"
                            aria-controls="adminSidebar"
                            aria-expanded="false"
                            class="md:hidden p-2 rounded-lg hover:bg-slate-100">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>

                    <div>
                        <h2 class="font-bold text-slate-800">
                            @yield('header', 'Dashboard')
                        </h2>

                        <p class="text-xs text-slate-400 mt-1 hidden sm:block">
                            CV Digital Management System
                        </p>
                    </div>

                </div>

                <div class="flex items-center gap-3">

                    <a href="{{ route('admin.notifications.index') }}"
                       class="relative p-3 rounded-xl hover:bg-slate-100 transition"
                       title="Notifikasi admin">

                        <i data-lucide="bell" class="w-5 h-5 text-slate-600"></i>

                        @if($unreadNotifications > 0)
                            <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-red-500 text-white text-[10px] flex items-center justify-center border-2 border-white">
                                {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                            </span>
                        @endif

                    </a>

                    <div class="hidden sm:flex items-center gap-3 border-l border-slate-200 pl-4">

                        <div class="text-right">
                            <p class="text-sm font-semibold text-slate-800">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-slate-400">Administrator</p>
                        </div>

                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                    </div>

                </div>

            </div>

        </header>

        <!-- PAGE CONTENT -->
        <main class="p-5 md:p-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </main>

        <footer class="px-8 py-5 border-t border-slate-200 text-center text-xs text-slate-400">
            &#169; {{ date('Y') }} {{ \App\Models\Setting::where('key', 'site_title')->value('value') ?: 'CV Digital' }}. All Rights Reserved.
        </footer>

    </div>

</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const button = document.getElementById('sidebarToggle');

        sidebar.classList.toggle('-translate-x-full');

        const isOpen = !sidebar.classList.contains('-translate-x-full');

        overlay.classList.toggle('hidden', !isOpen);

        if (button) {
            button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            button.setAttribute(
                'aria-label',
                isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi'
            );
        }
    }

    function closeSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const button = document.getElementById('sidebarToggle');

        if (!sidebar || !overlay) return;

        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');

        if (button) {
            button.setAttribute('aria-expanded', 'false');
            button.setAttribute('aria-label', 'Buka menu navigasi');
        }
    }

    document.querySelectorAll('#adminSidebar nav a, #adminSidebar > div a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                closeSidebar();
            }
        });
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            closeSidebar();
        }
    });

    lucide.createIcons();
</script>

</body>
</html>



