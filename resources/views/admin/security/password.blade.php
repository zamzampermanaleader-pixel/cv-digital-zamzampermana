@extends('admin.layouts.app')

@section('title', 'Keamanan Akun')
@section('header', 'Keamanan Administrator')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                <i data-lucide="shield-check" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="font-bold text-lg text-slate-900">Ganti Password</h2>
                <p class="text-sm text-slate-500">Perbarui kata sandi akun administrator.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 rounded-xl bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 p-4 text-red-700">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.security.password.update') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold mb-2">Password Lama</label>
                <input type="password" name="current_password" required autocomplete="current-password"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Password Baru</label>
                <input type="password" name="password" required autocomplete="new-password"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                <p class="text-xs text-slate-500 mt-2">Minimal 8 karakter.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <button type="submit" class="rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700">
                Simpan Password Baru
            </button>
        </form>
    </div>
</div>
@endsection
