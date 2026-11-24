
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $profile?->full_name ?? 'CV Digital Zamzam' }} | Portfolio</title>
    <meta name="description" content="{{ $profile?->summary ?? 'Portofolio dan CV Digital profesional.' }}">
    <meta name="author" content="{{ $profile?->full_name ?? 'CV Digital' }}">
    <meta name="theme-color" content="#080d19">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        html { scroll-behavior: smooth; scroll-padding-top: 100px; }

        body {
            background: #080d19;
            color: #e5e7eb;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
        }

        .gradient-text {
            background: linear-gradient(100deg, #38bdf8, #818cf8, #c084fc);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .glass {
            background: rgba(255,255,255,.045);
            border: 1px solid rgba(255,255,255,.09);
            backdrop-filter: blur(16px);
        }

        .section { padding: 100px 0; }

        .hero-glow {
            background:
                radial-gradient(circle at 20% 30%, rgba(14,165,233,.15), transparent 35%),
                radial-gradient(circle at 80% 70%, rgba(129,140,248,.13), transparent 35%);
        }

        .card-hover {
            transition: transform .3s ease, border-color .3s ease, background .3s ease;
        }

        .card-hover:hover {
            transform: translateY(-6px);
            border-color: rgba(56,189,248,.4);
            background: rgba(255,255,255,.075);
        }

        .admin-button {
            background: linear-gradient(110deg, #0284c7, #4f46e5);
            transition: all .25s ease;
        }

        .admin-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(56,189,248,.2);
        }

        .section-label {
            color: #38bdf8;
            letter-spacing: .2em;
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        input, textarea {
            color-scheme: dark;
        }

        .profile-ring {
            background: linear-gradient(135deg, #38bdf8, #818cf8, #c084fc);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="antialiased">

@php
    $photo = $profile?->photo
        ? asset('storage/' . ltrim($profile->photo, '/'))
        : null;
@endphp

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 right-0 z-50 border-b border-white/10 bg-[#080d19]/90 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <a href="#home" class="text-xl md:text-2xl font-black tracking-tight gradient-text">
            MY PORTFOLIO<span class="text-sky-400">.</span>
        </a>

        <div class="hidden lg:flex items-center gap-7 text-sm text-gray-300">
            <a href="#home" class="hover:text-sky-400 transition">Beranda</a>
            <a href="#about" class="hover:text-sky-400 transition">Tentang</a>
            <a href="#education" class="hover:text-sky-400 transition">Pendidikan</a>
            <a href="#experience" class="hover:text-sky-400 transition">Pengalaman</a>
            <a href="#projects" class="hover:text-sky-400 transition">Proyek</a>
            <a href="#contact" class="hover:text-sky-400 transition">Kontak</a>
        </div>

        <div class="hidden lg:flex items-center">
            <a href="{{ url('/admin/login') }}"
                class="admin-button inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold">
                <i data-lucide="lock-keyhole" class="w-4 h-4"></i>
                Login Admin
            </a>
        </div>

        <button id="menuButton"
                class="lg:hidden text-white p-2 rounded-lg hover:bg-white/10"
                aria-label="Buka menu"
                aria-expanded="false">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="hidden lg:hidden border-t border-white/10 bg-[#080d19]">
        <div class="px-6 py-5 space-y-4">
            <a href="#home" class="block text-gray-300 hover:text-sky-400">Beranda</a>
            <a href="#about" class="block text-gray-300 hover:text-sky-400">Tentang</a>
            <a href="#education" class="block text-gray-300 hover:text-sky-400">Pendidikan</a>
            <a href="#experience" class="block text-gray-300 hover:text-sky-400">Pengalaman</a>
            <a href="#projects" class="block text-gray-300 hover:text-sky-400">Proyek</a>
            <a href="#contact" class="block text-gray-300 hover:text-sky-400">Kontak</a>

            <a href="{{ url('/admin/login') }}"
               class="admin-button flex items-center justify-center gap-2 w-full rounded-xl py-3 text-white font-semibold">
                <i data-lucide="lock-keyhole" class="w-4 h-4"></i>
                Login Admin
            </a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section id="home" class="relative min-h-screen flex items-center pt-28 pb-20 hero-glow overflow-hidden">
    <div class="absolute top-32 right-0 w-72 h-72 bg-sky-500/10 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-10 left-0 w-72 h-72 bg-indigo-500/10 blur-[120px] rounded-full"></div>

    <div class="relative max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">

        <div>
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass text-sm text-sky-300 mb-8">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                Selamat datang di portofolio digital saya
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black leading-tight mb-7">
                Halo, Saya
                <span class="block gradient-text mt-2">
                    {{ $profile?->full_name ?? 'Nama Anda' }}
                </span>
            </h1>

            <h2 class="text-xl md:text-2xl text-gray-300 font-medium mb-6">
                {{ $profile?->headline ?? 'Professional Portfolio & Digital CV' }}
            </h2>

            <p class="text-gray-400 leading-8 text-base md:text-lg max-w-2xl mb-9">
                {{ $profile?->summary ?? 'Selamat datang di portofolio digital saya. Silakan jelajahi profil, pengalaman, pendidikan, dan proyek yang telah saya kerjakan.' }}
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="#projects"
                   class="admin-button inline-flex items-center gap-2 px-7 py-3.5 rounded-xl text-white font-semibold">
                    Jelajahi Portofolio
                    <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('cv.download') }}"
                   class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl border border-white/20 hover:bg-white/10 transition font-semibold">
                    <i data-lucide="download" class="w-5 h-5"></i>
                    Download CV
                </a>
            </div>

            @if($profile?->location)
                <div class="flex items-center gap-2 text-gray-500 mt-9 text-sm">
                    <i data-lucide="map-pin" class="w-4 h-4 text-sky-400"></i>
                    {{ $profile->location }}
                </div>
            @endif
        </div>

        <div class="flex justify-center">
            <div class="relative">
                <div class="absolute inset-0 rounded-full bg-sky-500/20 blur-3xl scale-90"></div>

                <div class="relative w-72 h-72 sm:w-96 sm:h-96 rounded-full p-[5px] profile-ring shadow-2xl shadow-sky-500/20">
                    <div class="w-full h-full rounded-full bg-[#101827] p-2">
                        @if($photo)
                            <img src="{{ $photo }}"
                                 alt="Foto {{ $profile?->full_name }}"
                                 class="w-full h-full object-cover rounded-full">
                        @else
                            <div class="w-full h-full rounded-full bg-slate-800 flex items-center justify-center">
                                <i data-lucide="user-round" class="w-32 h-32 text-sky-400"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="absolute -bottom-4 -left-8 glass rounded-2xl px-5 py-4 shadow-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-500/15 flex items-center justify-center">
                            <i data-lucide="briefcase-business" class="text-sky-400"></i>
                        </div>
                        <div>
                            <p class="text-white font-bold text-sm">Professional</p>
                            <p class="text-gray-500 text-xs">Digital Portfolio</p>
                        </div>
                    </div>
                </div>

                <div class="absolute -top-4 -right-5 glass rounded-2xl px-4 py-3">
                    <i data-lucide="sparkles" class="text-yellow-400 w-6 h-6"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section id="about" class="section bg-white/[0.02]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="section-label mb-4">Tentang Saya</p>
            <h2 class="text-3xl md:text-4xl font-bold">Mengenal Lebih Dekat</h2>
            <p class="text-gray-500 mt-4">Profil singkat dan informasi pribadi saya.</p>
        </div>

        <div class="glass rounded-3xl p-7 md:p-10 card-hover">
            <p class="text-gray-300 leading-9 text-lg">
                {{ $profile?->summary ?? 'Informasi tentang diri saya akan ditampilkan di sini.' }}
            </p>

            <div class="grid sm:grid-cols-2 gap-6 mt-9">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-sky-400/10 flex items-center justify-center">
                        <i data-lucide="mail" class="text-sky-400"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-500">Email</p>
                        <p class="text-gray-200 break-all">{{ $profile?->email ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-sky-400/10 flex items-center justify-center">
                        <i data-lucide="phone" class="text-sky-400"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Telepon</p>
                        <p class="text-gray-200">{{ $profile?->phone ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-sky-400/10 flex items-center justify-center">
                        <i data-lucide="map-pin" class="text-sky-400"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Lokasi</p>
                        <p class="text-gray-200">{{ $profile?->location ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-sky-400/10 flex items-center justify-center">
                        <i data-lucide="globe" class="text-sky-400"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-500">Website</p>
                        <p class="text-gray-200 break-all">{{ $profile?->website ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- EDUCATION -->
<section id="education" class="section">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="section-label mb-4">Riwayat Akademik</p>
            <h2 class="text-3xl md:text-4xl font-bold">Pendidikan</h2>
        </div>

        <div class="space-y-5">
            @forelse($educations->where('is_visible', true) as $education)
                <div class="glass rounded-2xl p-6 md:p-8 card-hover">
                    <div class="flex gap-5">
                        <div class="hidden sm:flex w-12 h-12 shrink-0 rounded-xl bg-sky-500/10 items-center justify-center">
                            <i data-lucide="graduation-cap" class="text-sky-400 w-6 h-6"></i>
                        </div>

                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white">{{ $education->institution }}</h3>
                            <p class="text-sky-400 mt-2 font-medium">
                                {{ $education->degree }} {{ $education->field_of_study }}
                            </p>
                            @if($education->location)
                                <p class="text-gray-500 text-sm mt-2">{{ $education->location }}</p>
                            @endif
                            <p class="text-gray-500 text-sm mt-2">
                                {{ $education->start_date?->format('Y') ?? '-' }}
                                -
                                {{ $education->is_current ? 'Sekarang' : ($education->end_date?->format('Y') ?? '-') }}
                            </p>
                            @if($education->description)
                                <p class="text-gray-400 mt-4 leading-7">{{ $education->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center">Belum ada data pendidikan.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- EXPERIENCE -->
<section id="experience" class="section bg-white/[0.02]">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="section-label mb-4">Perjalanan Karier</p>
            <h2 class="text-3xl md:text-4xl font-bold">Pengalaman Kerja</h2>
        </div>

        <div class="space-y-5">
            @forelse($experiences->where('is_visible', true) as $experience)
                <div class="glass rounded-2xl p-6 md:p-8 card-hover">
                    <div class="flex gap-5">
                        <div class="hidden sm:flex w-12 h-12 shrink-0 rounded-xl bg-indigo-500/10 items-center justify-center">
                            <i data-lucide="briefcase-business" class="text-indigo-400 w-6 h-6"></i>
                        </div>

                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white">{{ $experience->position }}</h3>
                            <p class="text-sky-400 mt-2">{{ $experience->company }}</p>
                            <p class="text-gray-500 text-sm mt-2">
                                {{ $experience->start_date?->format('M Y') ?? '-' }}
                                -
                                {{ $experience->is_current ? 'Sekarang' : ($experience->end_date?->format('M Y') ?? '-') }}
                            </p>
                            @if($experience->description)
                                <p class="text-gray-400 mt-4 leading-7">{{ $experience->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center">Belum ada pengalaman kerja.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- SKILLS -->
<section id="skills" class="section">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="section-label mb-4">Kompetensi</p>
            <h2 class="text-3xl md:text-4xl font-bold">Keahlian</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($skills->where('is_visible', true) as $skill)
                <div class="glass rounded-2xl p-6 card-hover">
                    <div class="flex justify-between items-center mb-4 gap-3">
                        <h3 class="font-semibold text-white">{{ $skill->name }}</h3>
                        <span class="text-sky-400 font-bold">{{ $skill->proficiency }}%</span>
                    </div>

                    <div class="h-2 rounded-full bg-gray-700 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-sky-400 to-indigo-500 rounded-full"
                             style="width: {{ min(100, max(0, $skill->proficiency ?? 0)) }}%"></div>
                    </div>

                    @if($skill->category)
                        <p class="text-gray-500 text-sm mt-4">{{ $skill->category }}</p>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 text-center col-span-full">Belum ada data keahlian.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- PROJECTS -->
<section id="projects" class="section bg-white/[0.02]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="section-label mb-4">Karya Saya</p>
            <h2 class="text-3xl md:text-4xl font-bold">Portofolio Proyek</h2>
            <p class="text-gray-500 mt-4">Beberapa karya dan proyek yang pernah saya kerjakan.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
            @forelse($projects->where('is_visible', true) as $project)
                <article class="glass rounded-2xl overflow-hidden card-hover">
                    @if($project->image_path)
                        <img src="{{ asset('storage/' . ltrim($project->image_path, '/')) }}"
                             alt="{{ $project->title }}"
                             loading="lazy"
                             class="w-full h-56 object-cover">
                    @else
                        <div class="w-full h-56 bg-gradient-to-br from-slate-800 to-indigo-950 flex items-center justify-center">
                            <i data-lucide="monitor" class="w-16 h-16 text-sky-400"></i>
                        </div>
                    @endif

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white">{{ $project->title }}</h3>

                        <p class="text-gray-400 mt-3 leading-7">
                            {{ $project->description }}
                        </p>

                        @if($project->technologies)
                            <div class="flex flex-wrap gap-2 mt-5">
                                @foreach($project->technologies as $technology)
                                    <span class="text-xs bg-sky-400/10 text-sky-300 border border-sky-400/10 px-3 py-1.5 rounded-full">
                                        {{ $technology }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        @if($project->project_url)
                            <a href="{{ $project->project_url }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 text-sky-400 mt-6 hover:text-sky-300 font-medium">
                                Lihat Proyek
                                <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                </article>
            @empty
                <p class="text-gray-500 text-center col-span-full">Belum ada proyek yang ditampilkan.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- CERTIFICATES -->
<section id="certificates" class="section">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="section-label mb-4">Pencapaian</p>
            <h2 class="text-3xl md:text-4xl font-bold">Sertifikat</h2>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            @forelse($certificates->where('is_visible', true) as $certificate)
                <div class="glass rounded-2xl p-6 card-hover">
                    <div class="w-12 h-12 rounded-xl bg-amber-400/10 flex items-center justify-center mb-5">
                        <i data-lucide="award" class="text-amber-400 w-7 h-7"></i>
                    </div>

                    <h3 class="font-bold text-lg text-white">{{ $certificate->title }}</h3>
                    <p class="text-gray-400 mt-2">{{ $certificate->issuer }}</p>
                    <p class="text-gray-500 text-sm mt-2">
                        {{ $certificate->issue_date?->format('d M Y') ?? '-' }}
                    </p>

                    @if($certificate->credential_url)
                        <a href="{{ $certificate->credential_url }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 text-sky-400 mt-5 hover:text-sky-300">
                            Verifikasi Sertifikat
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 text-center col-span-full">Belum ada sertifikat.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="section bg-white/[0.02]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-12">
            <p class="section-label mb-4">Hubungi Saya</p>
            <h2 class="text-3xl md:text-4xl font-bold">Mari Terhubung</h2>
            <p class="text-gray-500 mt-4">Punya pertanyaan atau ingin bekerja sama? Silakan kirim pesan.</p>
        </div>

        @if(session('contact_success'))
            <div class="bg-green-500/10 border border-green-500/30 text-green-300 rounded-xl p-4 mb-6">
                {{ session('contact_success') }}
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST"
              class="glass rounded-3xl p-6 md:p-9 space-y-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl p-4 outline-none focus:border-sky-400 transition">
                    @error('name')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl p-4 outline-none focus:border-sky-400 transition">
                    @error('email')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Subjek</label>
                <input type="text" name="subject" value="{{ old('subject') }}"
                       class="w-full bg-white/5 border border-white/10 rounded-xl p-4 outline-none focus:border-sky-400 transition">
                @error('subject')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Pesan</label>
                <textarea name="message" rows="5" required
                          class="w-full bg-white/5 border border-white/10 rounded-xl p-4 outline-none focus:border-sky-400 transition">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="admin-button w-full rounded-xl py-4 font-semibold text-white flex items-center justify-center gap-2">
                <i data-lucide="send" class="w-5 h-5"></i>
                Kirim Pesan
            </button>
        </form>
    </div>
</section>

<!-- FOOTER -->
<footer class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5">
            <div>
                <a href="#home" class="text-xl font-black gradient-text">MY PORTFOLIO.</a>
                <p class="text-gray-500 text-sm mt-2">
                    {{ $profile?->full_name ?? 'CV Digital' }} — Personal Digital Portfolio
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-5 text-sm text-gray-500">
                <a href="#about" class="hover:text-sky-400">Tentang</a>
                <a href="#projects" class="hover:text-sky-400">Proyek</a>
                <a href="#contact" class="hover:text-sky-400">Kontak</a>
                <a href="{{ url('/admin/login') }}" class="hover:text-sky-400">Login Admin</a>
            </div>
        </div>

        <div class="border-t border-white/10 mt-8 pt-6 text-center text-gray-600 text-sm">
            {{ date('Y') }} {{ $profile?->full_name ?? 'CV Digital' }}.
            Seluruh hak cipta dilindungi.
        </div>
    </div>
</footer>

<script>
    lucide.createIcons();

    const menuButton = document.getElementById('menuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    menuButton.addEventListener('click', () => {
        const isHidden = mobileMenu.classList.toggle('hidden');
        menuButton.setAttribute('aria-expanded', String(!isHidden));

        menuButton.innerHTML = isHidden
            ? '<i data-lucide="menu" class="w-6 h-6"></i>'
            : '<i data-lucide="x" class="w-6 h-6"></i>';

        lucide.createIcons();
    });

    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            menuButton.setAttribute('aria-expanded', 'false');
            menuButton.innerHTML = '<i data-lucide="menu" class="w-6 h-6"></i>';
            lucide.createIcons();
        });
    });
</script>

</body>
</html>
