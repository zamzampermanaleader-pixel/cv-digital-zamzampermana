<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f172a">

    @php
        $siteTitle = \App\Models\Setting::where('key', 'site_title')->value('value') ?: 'CV Digital Zamzam';
        $siteLogo = \App\Models\Setting::where('key', 'site_logo')->value('value');
    @endphp

    <title>Login Administrator | {{ $siteTitle }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
        }

        .login-bg {
            background:
                radial-gradient(circle at 15% 20%, rgba(37, 99, 235, .25), transparent 35%),
                radial-gradient(circle at 85% 80%, rgba(79, 70, 229, .2), transparent 35%),
                #020617;
        }
    </style>
</head>

<body class="min-h-screen login-bg flex items-center justify-center p-5">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">

            <div class="text-center mb-8">

                @if($siteLogo)
                    <div class="mb-5 flex justify-center">
                        <img
                            src="{{ asset('storage/' . $siteLogo) }}"
                            alt="{{ $siteTitle }}"
                            class="max-h-16 max-w-48 object-contain"
                        >
                    </div>
                @else
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-blue-500/30">
                        <span class="text-white text-3xl font-bold">Z</span>
                    </div>
                @endif

                <h1 class="text-2xl font-bold text-slate-900">
                    Administrator Login
                </h1>

                <p class="text-slate-500 mt-2 text-sm">
                    Selamat datang di panel administrasi
                </p>

                <p class="text-blue-600 font-semibold text-sm mt-1">
                    {{ $siteTitle }}
                </p>

            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 mb-6 text-sm">
                    <div class="font-semibold mb-1">Login gagal</div>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.process') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold mb-2 text-slate-700">
                        Email Administrator
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="admin@cvdigital.com"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3.5 text-slate-800 outline-none transition focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                    >

                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-semibold mb-2 text-slate-700">
                        Password
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password"
                            class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3.5 pr-20 text-slate-800 outline-none transition focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                        >

                        <button
                            type="button"
                            id="togglePasswordButton"
                            onclick="togglePassword()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-medium text-blue-600 hover:text-blue-800"
                            aria-label="Tampilkan password"
                        >
                            Lihat
                        </button>
                    </div>

                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600 mb-7 cursor-pointer">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                    >
                    Ingat saya
                </label>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-semibold py-3.5 rounded-xl shadow-lg shadow-blue-600/20 transition duration-300"
                >
                    <span class="inline-flex items-center justify-center gap-2">
                        <i data-lucide="log-in" class="w-5 h-5"></i>
                        Masuk Dashboard
                    </span>
                </button>

            </form>

            <div class="text-center mt-8 pt-6 border-t border-slate-100">
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-600 transition"
                >
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke website utama
                </a>
            </div>

        </div>

        <p class="text-center text-xs text-slate-500 mt-6">
            &copy; {{ date('Y') }} {{ $siteTitle }}. All Rights Reserved.
        </p>

    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const button = document.getElementById('togglePasswordButton');

            if (password.type === 'password') {
                password.type = 'text';
                button.textContent = 'Sembunyikan';
                button.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                password.type = 'password';
                button.textContent = 'Lihat';
                button.setAttribute('aria-label', 'Tampilkan password');
            }
        }

        lucide.createIcons();
    </script>

</body>
</html>
