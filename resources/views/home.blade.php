
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $seoTitle = data_get($settings, 'site_title.value')
            ?: ($profile?->full_name ?? 'CV Digital');

        $seoDescription = data_get($settings, 'site_description.value')
            ?: ($profile?->summary ?? 'CV Digital profesional');

        $seoAuthor = data_get($settings, 'site_author.value')
            ?: ($profile?->full_name ?? 'CV Digital');

        $socialTitle = data_get($settings, 'social_title.value') ?: $seoTitle;

        $socialDescription = data_get($settings, 'social_description.value')
            ?: $seoDescription;

        $seoImagePath = data_get($settings, 'og_image.value')
            ?: ($profile?->photo ?? null);

        $seoImage = $seoImagePath
            ? asset('storage/' . $seoImagePath)
            : null;

        $faviconPath = data_get($settings, 'site_favicon.value');

        $favicon = $faviconPath
            ? asset('storage/' . $faviconPath)
            : null;

        $siteLogo = data_get($settings, 'site_logo.value');

        $contactEmail = data_get($settings, 'contact_email.value')
            ?: ($profile?->email ?? null);

        $whatsappNumber = data_get($settings, 'whatsapp_number.value')
            ?: ($profile?->phone ?? '');

        $waNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);

        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }
    @endphp

    <title>{{ $seoTitle }}</title>

    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ data_get($settings, 'seo_keywords.value', '') }}">
    <meta name="author" content="{{ $seoAuthor }}">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#020617">

    <link rel="canonical" href="{{ request()->url() }}">

    @if($favicon)
        <link rel="icon" type="image/png" href="{{ $favicon }}">
    @endif

    <!-- OPEN GRAPH -->
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $seoTitle }}">
    <meta property="og:title" content="{{ $socialTitle }}">
    <meta property="og:description" content="{{ $socialDescription }}">
    <meta property="og:url" content="{{ request()->url() }}">

    @if($seoImage)
        <meta property="og:image" content="{{ $seoImage }}">
        <meta property="og:image:alt" content="{{ $socialTitle }}">
        <meta property="og:image:type" content="image/jpeg">
    @endif

    <!-- TWITTER CARD -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $socialTitle }}">
    <meta name="twitter:description" content="{{ $socialDescription }}">

    @if($seoImage)
        <meta name="twitter:image" content="{{ $seoImage }}">
        <meta name="twitter:image:alt" content="{{ $socialTitle }}">
    @endif

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            background: #020617;
            color: #f8fafc;
        }

        .reveal {
            opacity: 0;
            transform: translateY(25px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .gradient-text {
            background: linear-gradient(90deg, #22d3ee, #818cf8);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .glass {
            background: rgba(15, 23, 42, .75);
            backdrop-filter: blur(16px);
        }

        .section-title {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -.04em;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #22d3ee;
            box-shadow: 0 0 0 3px rgba(34, 211, 238, .12);
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal {
                opacity: 1;
                transform: none;
                transition: none;
            }

            html {
                scroll-behavior: auto;
            }
        }
    </style>
</head>

<body class="antialiased">

<!-- NAVBAR -->
<header class="sticky top-0 z-40 border-b border-slate-800/80 glass">
    <nav class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="h-20 flex items-center justify-between">

            <a href="#beranda" class="flex items-center gap-3 text-2xl font-black tracking-tight">
                @if($siteLogo)
                    <img src="{{ asset('storage/' . $siteLogo) }}"
                         alt="{{ $seoTitle }}"
                         class="max-h-12 max-w-40 object-contain">
                @else
                    <span>{{ $seoTitle }}</span>
                @endif
            </a>

            <div class="hidden lg:flex items-center gap-7 text-sm font-medium text-slate-300">
                <a href="#tentang" class="hover:text-cyan-400 transition">Tentang</a>
                <a href="#pengalaman" class="hover:text-cyan-400 transition">Pengalaman</a>
                <a href="#pendidikan" class="hover:text-cyan-400 transition">Pendidikan</a>
                <a href="#keahlian" class="hover:text-cyan-400 transition">Keahlian</a>
                <a href="#proyek" class="hover:text-cyan-400 transition">Proyek</a>
                <a href="#sertifikat" class="hover:text-cyan-400 transition">Sertifikat</a>
                <a href="#kontak" class="rounded-full bg-cyan-500 px-5 py-2.5 font-bold text-slate-950 hover:bg-cyan-400 transition">Hubungi Saya</a>
            </div>

            <button id="menuButton"
                    type="button"
                    aria-label="Buka menu navigasi"
                    aria-expanded="false"
                    class="lg:hidden rounded-xl border border-slate-700 p-2.5 text-slate-200">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-800 py-4">
            <div class="grid gap-1 text-sm text-slate-300">
                <a href="#tentang" class="rounded-lg px-4 py-3 hover:bg-slate-800">Tentang</a>
                <a href="#pengalaman" class="rounded-lg px-4 py-3 hover:bg-slate-800">Pengalaman</a>
                <a href="#pendidikan" class="rounded-lg px-4 py-3 hover:bg-slate-800">Pendidikan</a>
                <a href="#keahlian" class="rounded-lg px-4 py-3 hover:bg-slate-800">Keahlian</a>
                <a href="#proyek" class="rounded-lg px-4 py-3 hover:bg-slate-800">Proyek</a>
                <a href="#sertifikat" class="rounded-lg px-4 py-3 hover:bg-slate-800">Sertifikat</a>
                <a href="#kontak" class="rounded-lg px-4 py-3 text-cyan-400 hover:bg-slate-800">Kontak</a>
            </div>
        </div>
    </nav>
</header>

<main>

<!-- HERO -->
<section id="beranda" class="relative overflow-hidden">
    <div class="absolute -top-32 -left-32 h-96 w-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
    <div class="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-indigo-500/10 blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8 py-24 lg:py-32 grid lg:grid-cols-2 gap-16 items-center">

        <div class="reveal">
            <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/30 bg-cyan-500/10 px-4 py-2 text-sm text-cyan-300">
                <span class="h-2 w-2 rounded-full bg-green-400"></span>
                Selamat datang di CV Digital saya
            </div>

            <p class="mt-8 font-bold tracking-[.25em] text-cyan-400 text-sm">HALO, SAYA</p>

            <h1 class="mt-4 text-5xl md:text-6xl xl:text-7xl font-black leading-tight tracking-tight">
                {{ $profile?->full_name ?? 'Nama Anda' }}
            </h1>

            <h2 class="gradient-text mt-5 text-2xl md:text-3xl font-bold">
                {{ $profile?->headline ?? 'Profesional dan Kreator Digital' }}
            </h2>

            <p class="mt-7 max-w-xl text-base md:text-lg leading-8 text-slate-400">
                {{ $profile?->summary ?? 'Profil profesional akan ditampilkan di sini.' }}
            </p>

            <div class="mt-9 flex flex-wrap gap-4">
                <a href="#kontak" class="inline-flex items-center gap-2 rounded-xl bg-cyan-500 px-7 py-4 font-bold text-slate-950 shadow-lg shadow-cyan-500/20 hover:bg-cyan-400 transition">
                    Hubungi Saya
                    <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                </a>

                @if($profile?->resume_file)
                    <a href="{{ route('cv.download') }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 rounded-xl border border-slate-700 px-7 py-4 font-semibold text-white hover:border-cyan-400 hover:text-cyan-400 transition">
                        <i data-lucide="file-down" class="w-5 h-5"></i>
                        Lihat CV PDF
                    </a>
                @endif
            </div>

            <div class="mt-12 flex flex-wrap gap-5 text-sm text-slate-400">
                @if($profile?->location)
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-cyan-400"></i>
                        {{ $profile->location }}
                    </span>
                @endif

                @if($contactEmail)
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="mail" class="w-4 h-4 text-cyan-400"></i>
                        {{ $contactEmail }}
                    </span>
                @endif
            </div>
        </div>

        <div class="reveal flex justify-center">
            <div class="relative">
                <div class="absolute -inset-5 rounded-[2.5rem] bg-gradient-to-br from-cyan-500/30 to-indigo-500/30 blur-2xl"></div>

                @if($profile?->photo)
                    <img src="{{ asset('storage/' . $profile->photo) }}"
                         alt="Foto {{ $profile->full_name }}"
                         fetchpriority="high"
                         class="relative h-72 w-72 md:h-96 md:w-96 rounded-[2rem] border border-cyan-400/30 object-cover shadow-2xl">
                @else
                    <div class="relative flex h-72 w-72 md:h-96 md:w-96 items-center justify-center rounded-[2rem] border border-cyan-400/30 bg-slate-900 text-8xl font-black gradient-text shadow-2xl">
                        CV
                    </div>
                @endif

                <div class="absolute -bottom-5 -left-5 rounded-2xl border border-slate-700 bg-slate-900 p-4 shadow-xl">
                    <p class="text-xs text-slate-400">Personal Portfolio</p>
                    <p class="mt-1 font-bold text-cyan-400">CV Digital</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TENTANG -->
<section id="tentang" class="border-y border-slate-800 bg-slate-900/70 py-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="reveal max-w-3xl">
            <p class="mb-3 text-sm font-bold tracking-[.2em] text-cyan-400">PROFIL SAYA</p>
            <h2 class="section-title">Tentang Saya<span class="text-cyan-400">.</span></h2>
            <p class="mt-7 text-lg leading-9 text-slate-400">
                {{ $profile?->summary ?? 'Informasi tentang diri Anda dapat diatur melalui panel administrator.' }}
            </p>
        </div>

        <div class="reveal mt-12 grid gap-5 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                <i data-lucide="mail" class="h-7 w-7 text-cyan-400"></i>
                <p class="mt-5 text-sm text-slate-500">Email</p>
                <p class="mt-2 break-all font-semibold">{{ $contactEmail ?? '-' }}</p>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                <i data-lucide="phone" class="h-7 w-7 text-cyan-400"></i>
                <p class="mt-5 text-sm text-slate-500">Telepon</p>
                <p class="mt-2 font-semibold">{{ $whatsappNumber ?: '-' }}</p>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                <i data-lucide="map-pin" class="h-7 w-7 text-cyan-400"></i>
                <p class="mt-5 text-sm text-slate-500">Lokasi</p>
                <p class="mt-2 font-semibold">{{ $profile?->location ?? '-' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- PENGALAMAN -->
<section id="pengalaman" class="py-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="reveal mb-12">
            <p class="mb-3 text-sm font-bold tracking-[.2em] text-cyan-400">PERJALANAN KARIER</p>
            <h2 class="section-title">Pengalaman Kerja<span class="text-cyan-400">.</span></h2>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            @forelse($experiences as $experience)
                <article class="reveal rounded-2xl border border-slate-800 bg-slate-900 p-7 transition hover:-translate-y-1 hover:border-cyan-500/50">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold">{{ $experience->position }}</h3>
                            <p class="mt-2 font-semibold text-cyan-400">{{ $experience->company }}</p>
                        </div>
                        <i data-lucide="briefcase-business" class="h-7 w-7 shrink-0 text-cyan-400"></i>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-3 text-xs text-slate-500">
                        @if($experience->location)
                            <span>{{ $experience->location }}</span>
                        @endif
                        @if($experience->employment_type)
                            <span>{{ $experience->employment_type }}</span>
                        @endif
                    </div>

                    <p class="mt-3 text-sm text-slate-400">
                        {{ $experience->start_date?->format('M Y') }} –
                        {{ $experience->is_current ? 'Sekarang' : ($experience->end_date?->format('M Y') ?? '-') }}
                    </p>

                    <p class="mt-5 whitespace-pre-line leading-7 text-slate-300">{{ $experience->description }}</p>
                </article>
            @empty
                <p class="text-slate-500">Data pengalaman belum ditambahkan.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- PENDIDIKAN -->
<section id="pendidikan" class="border-y border-slate-800 bg-slate-900/70 py-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="reveal mb-12">
            <p class="mb-3 text-sm font-bold tracking-[.2em] text-cyan-400">RIWAYAT AKADEMIK</p>
            <h2 class="section-title">Pendidikan<span class="text-cyan-400">.</span></h2>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            @forelse($educations as $education)
                <article class="reveal rounded-2xl border border-slate-800 bg-slate-950 p-7 transition hover:border-cyan-500/50">
                    <i data-lucide="graduation-cap" class="h-8 w-8 text-cyan-400"></i>

                    <h3 class="mt-5 text-xl font-bold">{{ $education->institution }}</h3>

                    <p class="mt-2 font-semibold text-cyan-400">
                        {{ $education->degree }}
                        {{ $education->field_of_study }}
                    </p>

                    <p class="mt-3 text-sm text-slate-500">{{ $education->location }}</p>

                    <p class="mt-2 text-sm text-slate-400">
                        {{ $education->start_date?->format('Y') }} –
                        {{ $education->is_current ? 'Sekarang' : ($education->end_date?->format('Y') ?? '-') }}
                    </p>

                    <p class="mt-5 whitespace-pre-line leading-7 text-slate-300">{{ $education->description }}</p>
                </article>
            @empty
                <p class="text-slate-500">Data pendidikan belum ditambahkan.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- KEAHLIAN -->
<section id="keahlian" class="py-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="reveal mb-12">
            <p class="mb-3 text-sm font-bold tracking-[.2em] text-cyan-400">KEMAMPUAN PROFESIONAL</p>
            <h2 class="section-title">Keahlian Saya<span class="text-cyan-400">.</span></h2>
        </div>

        <div class="grid gap-x-12 gap-y-8 md:grid-cols-2">
            @forelse($skills as $skill)
                <div class="reveal">
                    @php
                        $proficiency = min(100, max(0, (int) ($skill->proficiency ?? 0)));
                    @endphp

                    <div class="mb-3 flex items-center justify-between gap-3">
                        <div>
                            <h3 class="font-semibold">{{ $skill->name }}</h3>
                            @if($skill->category)
                                <p class="mt-1 text-xs text-slate-500">{{ $skill->category }}</p>
                            @endif
                        </div>
                        <span class="font-bold text-cyan-400">{{ $proficiency }}%</span>
                    </div>

                    <div class="h-2 overflow-hidden rounded-full bg-slate-800">
                        <div class="h-full rounded-full bg-gradient-to-r from-cyan-500 to-indigo-500"
                             style="width: {{ $proficiency }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-slate-500">Data keahlian belum ditambahkan.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- PROYEK -->
<section id="proyek" class="border-y border-slate-800 bg-slate-900/70 py-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="reveal mb-12">
            <p class="mb-3 text-sm font-bold tracking-[.2em] text-cyan-400">HASIL KARYA</p>
            <h2 class="section-title">Proyek & Portofolio<span class="text-cyan-400">.</span></h2>
        </div>

        <div class="grid gap-7 md:grid-cols-2 lg:grid-cols-3">
            @forelse($projects as $project)
                <article class="reveal group overflow-hidden rounded-2xl border border-slate-800 bg-slate-950 transition hover:-translate-y-1 hover:border-cyan-500/50">
                    @if($project->image_path)
                        <div class="overflow-hidden">
                            <img src="{{ asset('storage/' . $project->image_path) }}"
                                 alt="{{ $project->title }}"
                                 loading="lazy"
                                 class="h-52 w-full object-cover transition duration-500 group-hover:scale-105">
                        </div>
                    @else
                        <div class="flex h-40 items-center justify-center bg-slate-900">
                            <i data-lucide="folder-code" class="h-14 w-14 text-cyan-400/50"></i>
                        </div>
                    @endif

                    <div class="p-6">
                        @if($project->is_featured)
                            <span class="rounded-full bg-cyan-500/10 px-3 py-1 text-xs font-bold text-cyan-400">PROYEK UNGGULAN</span>
                        @endif

                        <h3 class="mt-3 text-xl font-bold">{{ $project->title }}</h3>

                        @if($project->role)
                            <p class="mt-2 text-sm text-cyan-400">{{ $project->role }}</p>
                        @endif

                        <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-400">{{ $project->description }}</p>

                        @if($project->technologies)
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach((array) $project->technologies as $technology)
                                    <span class="rounded-lg bg-slate-800 px-3 py-1 text-xs text-cyan-300">{{ $technology }}</span>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-6 flex flex-wrap gap-4">
                            @if($project->project_url)
                                <a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-cyan-400 hover:text-cyan-300">
                                    Lihat Proyek <i data-lucide="external-link" class="h-4 w-4"></i>
                                </a>
                            @endif

                            @if($project->repository_url)
                                <a href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-300 hover:text-white">
                                    Source Code <i data-lucide="github" class="h-4 w-4"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-slate-500">Belum ada proyek yang dipublikasikan.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- SERTIFIKAT -->
<section id="sertifikat" class="py-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="reveal mb-12">
            <p class="mb-3 text-sm font-bold tracking-[.2em] text-cyan-400">PENCAPAIAN DAN KUALIFIKASI</p>
            <h2 class="section-title">Sertifikat<span class="text-cyan-400">.</span></h2>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            @forelse($certificates as $certificate)
                <article class="reveal flex gap-5 rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:border-cyan-500/50">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-cyan-500/10">
                        <i data-lucide="award" class="h-7 w-7 text-cyan-400"></i>
                    </div>

                    <div class="min-w-0">
                        <h3 class="text-lg font-bold">{{ $certificate->title }}</h3>
                        <p class="mt-2 text-cyan-400">{{ $certificate->issuer }}</p>
                        <p class="mt-2 text-sm text-slate-500">
                            Terbit: {{ $certificate->issue_date?->format('d M Y') ?? '-' }}
                        </p>

                        @if($certificate->credential_id)
                            <p class="mt-1 text-xs text-slate-500">ID: {{ $certificate->credential_id }}</p>
                        @endif

                        @if($certificate->credential_url)
                            <a href="{{ $certificate->credential_url }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-cyan-400">
                                Verifikasi Sertifikat <i data-lucide="external-link" class="h-4 w-4"></i>
                            </a>
                        @elseif($certificate->file_path)
                            <a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-cyan-400">
                                Lihat Sertifikat <i data-lucide="file-text" class="h-4 w-4"></i>
                            </a>
                        @endif
                    </div>
                </article>
            @empty
                <p class="text-slate-500">Belum ada sertifikat.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- KONTAK -->
<section id="kontak" class="border-y border-slate-800 bg-slate-900/70 py-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="grid gap-14 lg:grid-cols-2">

            <div class="reveal">
                <p class="mb-3 text-sm font-bold tracking-[.2em] text-cyan-400">MARI TERHUBUNG</p>
                <h2 class="section-title">Punya Pertanyaan atau Proyek?</h2>

                <p class="mt-6 leading-8 text-slate-400">
                    Silakan hubungi saya melalui formulir atau media sosial. Saya terbuka untuk berdiskusi dan menjalin kolaborasi.
                </p>

                <div class="mt-9 space-y-5">
                    @if($contactEmail)
                        <div class="flex items-center gap-4">
                            <div class="rounded-xl bg-slate-800 p-3"><i data-lucide="mail" class="h-5 w-5 text-cyan-400"></i></div>
                            <div>
                                <p class="text-xs text-slate-500">Email</p>
                                <p class="mt-1 break-all font-medium">{{ $contactEmail }}</p>
                            </div>
                        </div>
                    @endif

                    @if($whatsappNumber)
                        <div class="flex items-center gap-4">
                            <div class="rounded-xl bg-slate-800 p-3"><i data-lucide="phone" class="h-5 w-5 text-cyan-400"></i></div>
                            <div>
                                <p class="text-xs text-slate-500">Telepon</p>
                                <p class="mt-1 font-medium">{{ $whatsappNumber }}</p>
                            </div>
                        </div>
                    @endif

                    @if($profile?->location)
                        <div class="flex items-center gap-4">
                            <div class="rounded-xl bg-slate-800 p-3"><i data-lucide="map-pin" class="h-5 w-5 text-cyan-400"></i></div>
                            <div>
                                <p class="text-xs text-slate-500">Lokasi</p>
                                <p class="mt-1 font-medium">{{ $profile->location }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                @if($socialLinks->count())
                    <div class="mt-10">
                        <h3 class="mb-4 font-bold">Temukan Saya di Media Sosial</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($socialLinks as $link)
                                <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 rounded-xl border border-slate-700 px-4 py-3 text-sm text-slate-300 transition hover:border-cyan-400 hover:text-cyan-400">
                                    @if($link->icon)
                                        <i data-lucide="{{ $link->icon }}" class="h-4 w-4"></i>
                                    @else
                                        <i data-lucide="link" class="h-4 w-4"></i>
                                    @endif
                                    {{ $link->label ?: $link->platform }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="reveal">
                <div class="rounded-3xl border border-slate-800 bg-slate-950 p-7 md:p-9">
                    <h3 class="text-2xl font-bold">Kirim Pesan</h3>
                    <p class="mt-2 text-sm text-slate-500">Lengkapi formulir berikut untuk mengirim pesan.</p>

                    @if(session('contact_success'))
                        <div class="mt-6 rounded-xl border border-green-500/30 bg-green-500/10 p-4 text-sm text-green-300">
                            {{ session('contact_success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mt-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300">
                            <p class="mb-2 font-semibold">Periksa kembali formulir:</p>
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}" class="mt-7 space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="mb-2 block text-sm font-medium text-slate-300">Nama Lengkap</label>
                            <input id="name" name="name" type="text" required maxlength="255"
                                   value="{{ old('name') }}"
                                   placeholder="Masukkan nama Anda"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-4 text-white placeholder:text-slate-600">
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-slate-300">Alamat Email</label>
                            <input id="email" name="email" type="email" required maxlength="255"
                                   value="{{ old('email') }}"
                                   placeholder="nama@email.com"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-4 text-white placeholder:text-slate-600">
                        </div>

                        <div>
                            <label for="subject" class="mb-2 block text-sm font-medium text-slate-300">Subjek</label>
                            <input id="subject" name="subject" type="text" maxlength="255"
                                   value="{{ old('subject') }}"
                                   placeholder="Subjek pesan"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-4 text-white placeholder:text-slate-600">
                        </div>

                        <div>
                            <label for="message" class="mb-2 block text-sm font-medium text-slate-300">Pesan</label>
                            <textarea id="message" name="message" rows="5" required maxlength="5000"
                                      placeholder="Tuliskan pesan Anda..."
                                      class="w-full resize-y rounded-xl border border-slate-700 bg-slate-900 px-4 py-4 text-white placeholder:text-slate-600">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-cyan-500 px-6 py-4 font-bold text-slate-950 transition hover:bg-cyan-400">
                            <i data-lucide="send" class="h-5 w-5"></i>
                            Kirim Pesan
                        </button>

                        <p class="text-center text-xs text-slate-600">Informasi Anda digunakan untuk keperluan komunikasi.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<!-- FOOTER -->
<footer class="bg-slate-950 border-t border-slate-800 py-10">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">

            <div class="text-center md:text-left">
                <a href="#beranda" class="inline-flex items-center justify-center md:justify-start gap-3">
                    @if($siteLogo)
                        <img
                            src="{{ asset('storage/' . $siteLogo) }}"
                            alt="{{ $seoTitle }}"
                            class="max-h-12 max-w-36 object-contain">
                    @endif

                    <span class="text-xl font-black text-white">
                        {{ $seoTitle }}
                    </span>
                </a>

                <p class="mt-3 text-sm text-slate-400">
                    {{ $seoDescription }}
                </p>
            </div>

            <div class="text-center">
                <p class="text-sm text-slate-500">
                    {{ data_get($settings, 'footer_text.value') ?: ('© ' . date('Y') . ' ' . ($profile?->full_name ?? 'CV Digital') . '. Semua hak dilindungi.') }}
                </p>
                <p class="mt-2 text-xs text-slate-600">
                    Dibangun dengan Laravel dan teknologi web modern.
                </p>
            </div>

            <div class="text-center md:text-right">
                <a href="#beranda"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-cyan-400 hover:text-cyan-300">
                    Kembali ke atas
                    <i data-lucide="arrow-up" class="w-4 h-4"></i>
                </a>
            </div>

        </div>

        <div class="mt-8 border-t border-slate-800 pt-5 text-center text-xs text-slate-600">
            © {{ date('Y') }} {{ $seoTitle }}. All rights reserved.
        </div>

    </div>
</footer>

<!-- WHATSAPP -->
@if($waNumber)
    <a href="https://wa.me/{{ $waNumber }}"
       target="_blank"
       rel="noopener noreferrer"
       aria-label="Hubungi melalui WhatsApp"
       class="fixed bottom-6 right-6 z-40 flex items-center gap-2 rounded-full bg-green-500 px-5 py-4 font-bold text-white shadow-xl shadow-green-900/30 transition hover:scale-105 hover:bg-green-400">
        <i data-lucide="message-circle" class="h-5 w-5"></i>
        <span class="hidden sm:inline">WhatsApp</span>
    </a>
@endif

<!-- BACK TO TOP -->
<button id="backToTop"
        type="button"
        aria-label="Kembali ke atas"
        class="fixed bottom-24 right-6 z-40 hidden rounded-full border border-slate-700 bg-slate-900 p-3 text-cyan-400 shadow-xl transition hover:bg-slate-800">
    <i data-lucide="arrow-up" class="h-5 w-5"></i>
</button>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) {
        lucide.createIcons();
    }

    const menuButton = document.getElementById('menuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    menuButton?.addEventListener('click', function () {
        const isHidden = mobileMenu.classList.toggle('hidden');

        menuButton.setAttribute('aria-expanded', String(!isHidden));

        menuButton.innerHTML = isHidden
            ? '<i data-lucide="menu" class="w-6 h-6"></i>'
            : '<i data-lucide="x" class="w-6 h-6"></i>';

        if (window.lucide) {
            lucide.createIcons();
        }
    });

    mobileMenu?.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            mobileMenu.classList.add('hidden');
            menuButton?.setAttribute('aria-expanded', 'false');

            if (menuButton) {
                menuButton.innerHTML = '<i data-lucide="menu" class="w-6 h-6"></i>';
            }

            if (window.lucide) {
                lucide.createIcons();
            }
        });
    });

    const backToTop = document.getElementById('backToTop');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 500) {
            backToTop?.classList.remove('hidden');
        } else {
            backToTop?.classList.add('hidden');
        }
    }, { passive: true });

    backToTop?.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    const revealElements = document.querySelectorAll('.reveal');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        revealElements.forEach(function (element) {
            observer.observe(element);
        });
    } else {
        revealElements.forEach(function (element) {
            element.classList.add('visible');
        });
    }
});
</script>

</body>
</html>
