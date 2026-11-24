
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $nama = $profile?->full_name ?: 'Zamzam Permana';
        $headline = $profile?->headline ?: 'Mahasiswa Sistem Informasi';

        $ringkasan = $profile?->summary
            ?: 'Saya adalah pribadi yang bertanggung jawab, kreatif, teliti, dan mampu bekerja secara individu maupun dalam tim. Saya memiliki minat dalam desain grafis, desain UI/UX, pengembangan website, dan analisis data.';

        $fotoDefault = 'image/foto-zamzam.jpg';

        $photo = $profile?->photo
            ? asset('storage/' . ltrim($profile->photo, '/'))
            : (file_exists(public_path($fotoDefault))
                ? asset($fotoDefault)
                : null);

        /*
         * Pengaturan CV dari database.
         * Controller perlu mengirim $settings sebagai collection
         * yang sudah di-keyBy('key').
         */
        $settingValue = function ($key, $default = []) use ($settings) {
            $value = $settings->get($key)?->value;

            if (blank($value)) {
                return $default;
            }

            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : $default;
        };

        $organisasi = $settingValue('organizations');
        $hobi = $settingValue('hobbies');
        $bahasa = $settingValue('languages');

        /*
         * Pastikan seluruh variabel koleksi tersedia.
         */
        $educations = $educations ?? collect();
        $experiences = $experiences ?? collect();
        $skills = $skills ?? collect();
        $projects = $projects ?? collect();
        $certificates = $certificates ?? collect();
        $socialLinks = $socialLinks ?? collect();

        /*
         * Hanya tampilkan data yang diizinkan tampil di publik.
         */
        $educations = $educations->where('is_visible', true);
        $experiences = $experiences->where('is_visible', true);
        $skills = $skills->where('is_visible', true);
        $projects = $projects->where('is_visible', true);
        $certificates = $certificates->where('is_visible', true);

        $email = $profile?->email;
        $phone = $profile?->phone;
        $location = $profile?->location;

        $whatsapp = $settings->get('whatsapp_number')?->value;
        $contactEmail = $settings->get('contact_email')?->value ?: $email;

        $siteTitle = $settings->get('site_title')?->value ?: ($nama . ' | Curriculum Vitae');
        $siteDescription = $settings->get('site_description')?->value ?: $ringkasan;
        $footerText = $settings->get('footer_text')?->value;

        $profileSocialLinks = $socialLinks->where('is_visible', true);
    @endphp

    <title>{{ $siteTitle }}</title>
    <meta name="description" content="{{ $siteDescription }}">
    <meta name="author" content="{{ $nama }}">
    <meta name="theme-color" content="#081426">

    <meta property="og:title" content="{{ $settings->get('social_title')?->value ?: $siteTitle }}">
    <meta property="og:description" content="{{ $settings->get('social_description')?->value ?: $siteDescription }}">
    <meta property="og:type" content="website">

    @if($settings->get('og_image')?->value)
        <meta property="og:image" content="{{ asset('storage/' . $settings->get('og_image')->value) }}">
    @elseif($photo)
        <meta property="og:image" content="{{ $photo }}">
    @endif

    @if($settings->get('site_favicon')?->value)
        <link rel="icon" href="{{ asset('storage/' . $settings->get('site_favicon')->value) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 90px;
        }

        body {
            background: #081426;
            color: #e5edf7;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
        }

        .gradient-text {
            background: linear-gradient(110deg, #38bdf8, #60a5fa, #a5b4fc);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .glass {
            background: rgba(255,255,255,.045);
            border: 1px solid rgba(255,255,255,.09);
            backdrop-filter: blur(16px);
        }

        .section {
            padding: 90px 0;
        }

        .hero-bg {
            background:
                radial-gradient(circle at 15% 25%, rgba(14,165,233,.17), transparent 35%),
                radial-gradient(circle at 85% 75%, rgba(59,130,246,.12), transparent 35%);
        }

        .card-hover {
            transition: .3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            border-color: rgba(56,189,248,.4);
            background: rgba(255,255,255,.075);
        }

        .primary-button {
            background: linear-gradient(110deg, #0284c7, #2563eb);
            transition: .25s ease;
        }

        .primary-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(14,165,233,.22);
        }

        .section-label {
            color: #38bdf8;
            letter-spacing: .16em;
            font-size: .75rem;
            font-weight: 700;
        }

        .profile-ring {
            background: linear-gradient(135deg, #38bdf8, #2563eb, #818cf8);
        }

        input, textarea {
            color-scheme: dark;
        }

        @media(max-width: 640px) {
            .section {
                padding: 65px 0;
            }
        }
    </style>
</head>

<body class="antialiased">

<!-- NAVIGASI -->
<nav class="fixed top-0 left-0 right-0 z-50 border-b border-white/10 bg-[#081426]/95 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <a href="#beranda" class="text-xl font-black gradient-text">
            {{ strtoupper($nama) }}<span class="text-sky-400">.</span>
        </a>

        <div class="hidden lg:flex items-center gap-6 text-sm text-gray-300">
            <a href="#beranda" class="hover:text-sky-400">Beranda</a>
            <a href="#tentang" class="hover:text-sky-400">Tentang Saya</a>
            <a href="#pendidikan" class="hover:text-sky-400">Pendidikan</a>
            <a href="#pengalaman" class="hover:text-sky-400">Pengalaman</a>
            <a href="#keahlian" class="hover:text-sky-400">Keahlian</a>
            <a href="#organisasi" class="hover:text-sky-400">Organisasi</a>
            <a href="#portofolio" class="hover:text-sky-400">Portofolio</a>
            <a href="#kontak" class="hover:text-sky-400">Kontak</a>
        </div>

        <a href="{{ url('/admin/login') }}"
           class="hidden lg:inline-flex primary-button px-5 py-2.5 rounded-xl text-sm font-semibold text-white items-center gap-2">
            <i data-lucide="lock-keyhole" class="w-4 h-4"></i>
            Admin
        </a>

        <button id="menuButton"
                class="lg:hidden p-2 rounded-lg hover:bg-white/10"
                aria-label="Buka menu"
                aria-expanded="false">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </div>

    <div id="mobileMenu" class="hidden lg:hidden border-t border-white/10 bg-[#081426]">
        <div class="px-6 py-5 space-y-4">
            <a href="#beranda" class="block">Beranda</a>
            <a href="#tentang" class="block">Tentang Saya</a>
            <a href="#pendidikan" class="block">Pendidikan</a>
            <a href="#pengalaman" class="block">Pengalaman</a>
            <a href="#keahlian" class="block">Keahlian</a>
            <a href="#organisasi" class="block">Organisasi</a>
            <a href="#portofolio" class="block">Portofolio</a>
            <a href="#kontak" class="block">Kontak</a>
            <a href="{{ url('/admin/login') }}" class="block text-sky-400">Masuk Admin</a>
        </div>
    </div>
</nav>

<!-- BERANDA -->
<section id="beranda" class="relative min-h-screen flex items-center pt-28 pb-20 hero-bg overflow-hidden">
    <div class="absolute top-32 right-0 w-72 h-72 bg-sky-500/10 blur-[120px] rounded-full"></div>

    <div class="relative max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-14 items-center">

        <div>
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass text-sm text-sky-300 mb-8">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                Selamat datang di CV digital saya
            </div>

            <p class="section-label mb-4">CURRICULUM VITAE DIGITAL</p>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6">
                Halo, Saya
                <span class="block gradient-text mt-2">{{ $nama }}</span>
            </h1>

            <h2 class="text-xl md:text-2xl text-gray-300 font-medium mb-6">
                {{ $headline }}
            </h2>

            <p class="text-gray-400 leading-8 text-base md:text-lg max-w-2xl mb-9">
                {{ $ringkasan }}
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="#portofolio"
                   class="primary-button inline-flex items-center gap-2 px-7 py-3.5 rounded-xl text-white font-semibold">
                    Lihat Portofolio
                    <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('cv.download') }}"
                   class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl border border-white/20 hover:bg-white/10 font-semibold">
                    <i data-lucide="download" class="w-5 h-5"></i>
                    Unduh CV
                </a>
            </div>

            <div class="flex flex-wrap gap-5 mt-9 text-sm text-gray-400">
                @if($phone)
                    <span class="flex items-center gap-2">
                        <i data-lucide="phone" class="w-4 h-4 text-sky-400"></i>
                        {{ $phone }}
                    </span>
                @endif

                @if($location)
                    <span class="flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-sky-400"></i>
                        {{ $location }}
                    </span>
                @endif
            </div>
        </div>

        <div class="flex justify-center">
            <div class="relative">
                <div class="absolute inset-0 rounded-full bg-sky-500/20 blur-3xl"></div>

                <div class="relative w-72 h-72 sm:w-96 sm:h-96 rounded-full p-[5px] profile-ring shadow-2xl">
                    <div class="w-full h-full rounded-full bg-[#101827] p-2">
                        @if($photo)
                            <img src="{{ $photo }}"
                                 alt="Foto profil {{ $nama }}"
                                 class="w-full h-full object-cover rounded-full"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                            <div class="hidden w-full h-full rounded-full bg-slate-800 items-center justify-center">
                                <i data-lucide="user-round" class="w-32 h-32 text-sky-400"></i>
                            </div>
                        @else
                            <div class="w-full h-full rounded-full bg-slate-800 flex items-center justify-center">
                                <i data-lucide="user-round" class="w-32 h-32 text-sky-400"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="absolute -bottom-3 -left-7 glass rounded-2xl px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-500/15 flex items-center justify-center">
                            <i data-lucide="graduation-cap" class="text-sky-400"></i>
                        </div>
                        <div>
                            <p class="text-white font-bold text-sm">Mahasiswa</p>
                            <p class="text-gray-400 text-xs">Sistem Informasi</p>
                        </div>
                    </div>
                </div>

                <div class="absolute -top-3 -right-4 glass rounded-2xl p-4">
                    <i data-lucide="sparkles" class="text-yellow-400 w-6 h-6"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TENTANG SAYA -->
<section id="tentang" class="section bg-white/[0.02]">
    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="section-label mb-4">PROFIL PRIBADI</p>
            <h2 class="text-3xl md:text-4xl font-bold">Tentang Saya</h2>
            <p class="text-gray-500 mt-4">Mengenal latar belakang dan minat saya.</p>
        </div>

        <div class="glass rounded-3xl p-7 md:p-10">
            <p class="text-gray-300 leading-9 text-lg">{{ $ringkasan }}</p>

            <div class="grid sm:grid-cols-2 gap-6 mt-9">

                @if($contactEmail)
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-xl bg-sky-400/10 flex items-center justify-center">
                            <i data-lucide="mail" class="text-sky-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Alamat Email</p>
                            <p class="text-gray-200 break-all">{{ $contactEmail }}</p>
                        </div>
                    </div>
                @endif

                @if($phone)
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-xl bg-sky-400/10 flex items-center justify-center">
                            <i data-lucide="phone" class="text-sky-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Nomor Telepon</p>
                            <p class="text-gray-200">{{ $phone }}</p>
                        </div>
                    </div>
                @endif

                @if($location)
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-xl bg-sky-400/10 flex items-center justify-center">
                            <i data-lucide="map-pin" class="text-sky-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Lokasi</p>
                            <p class="text-gray-200">{{ $location }}</p>
                        </div>
                    </div>
                @endif

                @foreach($profileSocialLinks as $social)
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-xl bg-sky-400/10 flex items-center justify-center">
                            <i data-lucide="at-sign" class="text-sky-400"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500">{{ $social->platform }}</p>
                            <a href="{{ $social->url }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="text-gray-200 hover:text-sky-400 break-all">
                                {{ $social->label ?: $social->platform }}
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>

<!-- PENDIDIKAN -->
<section id="pendidikan" class="section">
    <div class="max-w-5xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="section-label mb-4">RIWAYAT AKADEMIK</p>
            <h2 class="text-3xl md:text-4xl font-bold">Pendidikan</h2>
        </div>

        <div class="space-y-5">
            @forelse($educations as $education)
                <div class="glass rounded-2xl p-6 md:p-8 card-hover">
                    <div class="flex gap-5">
                        <div class="w-12 h-12 shrink-0 rounded-xl bg-sky-500/10 flex items-center justify-center">
                            <i data-lucide="graduation-cap" class="text-sky-400 w-6 h-6"></i>
                        </div>

                        <div class="min-w-0">
                            <h3 class="text-xl font-bold text-white">
                                {{ $education->institution }}
                            </h3>

                            @if($education->degree || $education->field_of_study)
                                <p class="text-sky-400 mt-2">
                                    {{ $education->degree }}
                                    {{ $education->field_of_study ? ' - ' . $education->field_of_study : '' }}
                                </p>
                            @endif

                            @if($education->start_date || $education->end_date)
                                <p class="text-gray-500 text-sm mt-2">
                                    {{ $education->start_date?->format('Y') ?? '-' }}
                                    -
                                    {{ $education->end_date?->format('Y') ?? 'Sekarang' }}
                                </p>
                            @endif

                            @if($education->description)
                                <p class="text-gray-400 mt-3 leading-7">
                                    {{ $education->description }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="glass rounded-2xl p-8 text-center text-gray-400">
                    Belum ada data pendidikan yang ditampilkan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- PENGALAMAN -->
<section id="pengalaman" class="section bg-white/[0.02]">
    <div class="max-w-5xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="section-label mb-4">PENGALAMAN PROFESIONAL</p>
            <h2 class="text-3xl md:text-4xl font-bold">Pengalaman</h2>
        </div>

        <div class="space-y-5">
            @forelse($experiences as $experience)
                <div class="glass rounded-2xl p-6 md:p-8 card-hover">
                    <div class="flex gap-5">
                        <div class="w-12 h-12 shrink-0 rounded-xl bg-sky-500/10 flex items-center justify-center">
                            <i data-lucide="briefcase-business" class="text-sky-400 w-6 h-6"></i>
                        </div>

                        <div class="min-w-0">
                            <h3 class="text-xl font-bold text-white">
                                {{ $experience->position }}
                            </h3>

                            <p class="text-sky-400 mt-2">
                                {{ $experience->company }}
                            </p>

                            @if($experience->employment_type)
                                <p class="text-gray-500 text-sm mt-2">
                                    {{ $experience->employment_type }}
                                </p>
                            @endif

                            @if($experience->start_date || $experience->end_date || $experience->is_current)
                                <p class="text-gray-500 text-sm mt-2">
                                    {{ $experience->start_date?->format('M Y') ?? '-' }}
                                    -
                                    {{ $experience->is_current ? 'Sekarang' : ($experience->end_date?->format('M Y') ?? '-') }}
                                </p>
                            @endif

                            @if($experience->location)
                                <p class="text-gray-500 text-sm mt-2">
                                    {{ $experience->location }}
                                </p>
                            @endif

                            @if($experience->description)
                                <p class="text-gray-400 mt-4 leading-7">
                                    {{ $experience->description }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="glass rounded-2xl p-8 text-center text-gray-400">
                    Belum ada pengalaman yang ditampilkan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- KEAHLIAN -->
<section id="keahlian" class="section">
    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="section-label mb-4">KOMPETENSI</p>
            <h2 class="text-3xl md:text-4xl font-bold">Keahlian Saya</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($skills as $skill)
                <div class="glass rounded-2xl p-6 card-hover">
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-xl bg-sky-500/10 flex items-center justify-center">
                            <i data-lucide="check-circle-2" class="text-sky-400"></i>
                        </div>

                        <div class="min-w-0">
                            <h3 class="font-semibold text-white">
                                {{ $skill->name }}
                            </h3>

                            @if($skill->category)
                                <p class="text-sky-400 text-sm mt-1">
                                    {{ $skill->category }}
                                </p>
                            @endif
                        </div>
                    </div>

                    @if(isset($skill->proficiency) && $skill->proficiency !== null)
                        <div class="mt-5">
                            <div class="flex justify-between text-xs text-gray-400 mb-2">
                                <span>Tingkat Penguasaan</span>
                                <span>{{ $skill->proficiency }}%</span>
                            </div>

                            <div class="w-full bg-white/10 rounded-full h-2">
                                <div class="bg-sky-400 h-2 rounded-full"
                                     style="width: {{ min(100, max(0, (int) $skill->proficiency)) }}%">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="glass rounded-2xl p-8 text-center text-gray-400 col-span-full">
                    Belum ada keahlian yang ditampilkan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ORGANISASI -->
<section id="organisasi" class="section bg-white/[0.02]">
    <div class="max-w-5xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="section-label mb-4">PENGALAMAN ORGANISASI</p>
            <h2 class="text-3xl md:text-4xl font-bold">Organisasi</h2>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            @forelse($organisasi as $item)
                @if(is_array($item))
                    <div class="glass rounded-2xl p-6 card-hover">
                        <div class="flex gap-4 items-center">
                            <div class="w-12 h-12 rounded-xl bg-sky-500/10 flex items-center justify-center">
                                <i data-lucide="users" class="text-sky-400"></i>
                            </div>

                            <div>
                                <p class="text-sky-400 text-sm">
                                    {{ $item['jabatan'] ?? 'Anggota' }}
                                </p>
                                <h3 class="text-white font-bold mt-1">
                                    {{ $item['nama'] ?? '' }}
                                </h3>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="glass rounded-2xl p-8 text-center text-gray-400 col-span-full">
                    Belum ada organisasi yang ditampilkan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- PORTOFOLIO -->
<section id="portofolio" class="section">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="section-label mb-4">HASIL KARYA</p>
            <h2 class="text-3xl md:text-4xl font-bold">Portofolio</h2>
            <p class="text-gray-500 mt-4">
                Beberapa karya dan proyek yang saya kerjakan.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
                <article class="glass rounded-2xl overflow-hidden card-hover">
                    @if($project->image_path)
                        <img src="{{ asset('storage/' . ltrim($project->image_path, '/')) }}"
                             alt="{{ $project->title }}"
                             loading="lazy"
                             class="w-full h-52 object-cover">
                    @else
                        <div class="w-full h-52 bg-slate-800 flex items-center justify-center">
                            <i data-lucide="monitor" class="w-16 h-16 text-sky-400"></i>
                        </div>
                    @endif

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white">
                            {{ $project->title }}
                        </h3>

                        @if($project->role)
                            <p class="text-sky-400 text-sm mt-2">
                                {{ $project->role }}
                            </p>
                        @endif

                        @if($project->description)
                            <p class="text-gray-400 mt-3 leading-7">
                                {{ $project->description }}
                            </p>
                        @endif

                        @if($project->technologies)
                            @php
                                $technologies = is_array($project->technologies)
                                    ? $project->technologies
                                    : (json_decode($project->technologies, true)
                                        ?: preg_split('/[,;]+/', $project->technologies));
                            @endphp

                            <div class="flex flex-wrap gap-2 mt-5">
                                @foreach($technologies as $technology)
                                    @if(is_string($technology) && trim($technology) !== '')
                                        <span class="text-xs bg-sky-400/10 text-sky-300 px-3 py-1.5 rounded-full">
                                            {{ trim($technology) }}
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        @if($project->project_url)
                            <a href="{{ $project->project_url }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 text-sky-400 mt-5">
                                Lihat Proyek
                                <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                </article>
            @empty
                <div class="glass rounded-2xl p-8 text-center text-gray-400 col-span-full">
                    Belum ada portofolio yang ditampilkan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- BAHASA DAN HOBI -->
<section class="section bg-white/[0.02]">
    <div class="max-w-5xl mx-auto px-6 grid md:grid-cols-2 gap-6">

        <div class="glass rounded-2xl p-7">
            <div class="flex items-center gap-3 mb-6">
                <i data-lucide="languages" class="text-sky-400 w-6 h-6"></i>
                <h2 class="text-xl font-bold">Bahasa</h2>
            </div>

            <div class="space-y-3">
                @forelse($bahasa as $item)
                    @if(is_string($item) && trim($item) !== '')
                        <div class="flex items-center gap-3 text-gray-300">
                            <i data-lucide="check-circle" class="text-sky-400 w-5 h-5"></i>
                            {{ $item }}
                        </div>
                    @endif
                @empty
                    <p class="text-gray-500 text-sm">Belum ada data bahasa.</p>
                @endforelse
            </div>
        </div>

        <div class="glass rounded-2xl p-7">
            <div class="flex items-center gap-3 mb-6">
                <i data-lucide="heart" class="text-sky-400 w-6 h-6"></i>
                <h2 class="text-xl font-bold">Hobi</h2>
            </div>

            <div class="flex flex-wrap gap-3">
                @forelse($hobi as $item)
                    @if(is_string($item) && trim($item) !== '')
                        <span class="px-4 py-2 rounded-full bg-sky-400/10 text-sky-300 text-sm">
                            {{ $item }}
                        </span>
                    @endif
                @empty
                    <p class="text-gray-500 text-sm">Belum ada data hobi.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- SERTIFIKAT -->
@if($certificates->isNotEmpty())
<section id="sertifikat" class="section">
    <div class="max-w-5xl mx-auto px-6">

        <div class="text-center mb-12">
            <p class="section-label mb-4">DOKUMEN PENDUKUNG</p>
            <h2 class="text-3xl md:text-4xl font-bold">Sertifikat</h2>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            @foreach($certificates as $certificate)
                <div class="glass rounded-2xl p-6 card-hover">
                    <i data-lucide="award" class="text-yellow-400 w-8 h-8 mb-4"></i>

                    <h3 class="font-bold text-lg">
                        {{ $certificate->title }}
                    </h3>

                    @if($certificate->issuer)
                        <p class="text-gray-400 mt-2">
                            {{ $certificate->issuer }}
                        </p>
                    @endif

                    @if($certificate->issue_date)
                        <p class="text-gray-500 text-sm mt-2">
                            {{ $certificate->issue_date->format('d M Y') }}
                        </p>
                    @endif

                    @if($certificate->credential_url)
                        <a href="{{ $certificate->credential_url }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex text-sky-400 mt-4">
                            Lihat Sertifikat
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- KONTAK -->
<section id="kontak" class="section bg-white/[0.02]">
    <div class="max-w-4xl mx-auto px-6">

        <div class="text-center mb-12">
            <p class="section-label mb-4">HUBUNGI SAYA</p>
            <h2 class="text-3xl md:text-4xl font-bold">Mari Terhubung</h2>
            <p class="text-gray-500 mt-4">
                Silakan kirim pesan untuk bertanya atau menjalin kerja sama.
            </p>
        </div>

        @if(session('contact_success'))
            <div class="bg-green-500/10 border border-green-500/30 text-green-300 rounded-xl p-4 mb-6">
                {{ session('contact_success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-300 rounded-xl p-4 mb-6">
                Mohon periksa kembali data formulir yang kamu masukkan.
            </div>
        @endif

        <form action="{{ route('contact.store') }}"
              method="POST"
              class="glass rounded-3xl p-6 md:p-9 space-y-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Nama Lengkap</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           maxlength="255"
                           class="w-full bg-white/5 border border-white/10 rounded-xl p-4 outline-none focus:border-sky-400">
                    @error('name')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Alamat Email</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           maxlength="255"
                           class="w-full bg-white/5 border border-white/10 rounded-xl p-4 outline-none focus:border-sky-400">
                    @error('email')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Subjek</label>
                <input type="text"
                       name="subject"
                       value="{{ old('subject') }}"
                       maxlength="255"
                       class="w-full bg-white/5 border border-white/10 rounded-xl p-4 outline-none focus:border-sky-400">
                @error('subject')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Pesan</label>
                <textarea name="message"
                          rows="5"
                          required
                          class="w-full bg-white/5 border border-white/10 rounded-xl p-4 outline-none focus:border-sky-400">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="primary-button w-full rounded-xl py-4 font-semibold text-white flex items-center justify-center gap-2">
                <i data-lucide="send" class="w-5 h-5"></i>
                Kirim Pesan
            </button>
        </form>

        @if($whatsapp)
            <div class="text-center mt-7">
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $whatsapp) }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 text-green-400 hover:text-green-300">
                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                    Hubungi melalui WhatsApp
                </a>
            </div>
        @endif
    </div>
</section>

<!-- FOOTER -->
<footer class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="flex flex-col md:flex-row justify-between items-center gap-5">
            <div>
                <a href="#beranda" class="text-xl font-black gradient-text">
                    {{ $nama }}.
                </a>

                <p class="text-gray-500 text-sm mt-2">
                    {{ $footerText ?: 'Curriculum Vitae dan Portofolio Digital' }}
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-5 text-sm text-gray-400">
                <a href="#tentang" class="hover:text-sky-400">Tentang</a>
                <a href="#pendidikan" class="hover:text-sky-400">Pendidikan</a>
                <a href="#portofolio" class="hover:text-sky-400">Portofolio</a>
                <a href="#kontak" class="hover:text-sky-400">Kontak</a>
                <a href="{{ url('/admin/login') }}" class="hover:text-sky-400">Admin</a>
            </div>
        </div>

        <div class="border-t border-white/10 mt-8 pt-6 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} {{ $nama }}.
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
