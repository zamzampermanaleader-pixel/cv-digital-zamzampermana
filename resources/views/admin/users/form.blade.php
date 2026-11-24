@extends('admin.layouts.app')

@section('title', isset($user->id) ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('header', 'Form Pengguna')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">

    <div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-600">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali ke daftar pengguna
        </a>
        <h2 class="mt-4 text-xl font-bold text-slate-800">
            {{ isset($user->id) ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
        </h2>
        <p class="mt-1 text-sm text-slate-500">Lengkapi informasi akun dan tentukan hak aksesnya.</p>
    </div>

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="mb-2 font-semibold">Periksa kembali data berikut:</p>
            <ul class="list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ isset($user->id) ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
        method="POST"
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >
        @csrf
        @if(isset($user->id))
            @method('PUT')
        @endif

        <div class="border-b border-slate-100 px-6 py-5">
            <h3 class="font-bold text-slate-800">Informasi Akun</h3>
            <p class="mt-1 text-sm text-slate-500">Informasi dasar pengguna untuk masuk ke dashboard.</p>
        </div>

        <div class="grid gap-5 p-6 md:grid-cols-2">

            <div class="md:col-span-2">
                <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    placeholder="Masukkan nama lengkap"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="mb-2 block text-sm font-semibold text-slate-700">Alamat Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    placeholder="contoh@email.com"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Password
                    @if(isset($user->id))
                        <span class="font-normal text-slate-400">(Opsional)</span>
                    @endif
                </label>
                <input
                    type="password"
                    name="password"
                    {{ isset($user->id) ? '' : 'required' }}
                    minlength="10"
                    autocomplete="new-password"
                    placeholder="{{ isset($user->id) ? 'Kosongkan jika tidak diubah' : 'Minimal 10 karakter' }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    {{ isset($user->id) ? '' : 'required' }}
                    minlength="10"
                    autocomplete="new-password"
                    placeholder="Ulangi password"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
            </div>
        </div>

        <div class="border-t border-slate-100 px-6 py-5">
            <h3 class="font-bold text-slate-800">Hak Akses</h3>
            <p class="mt-1 text-sm text-slate-500">Tentukan tingkat akses pengguna di dalam aplikasi.</p>
        </div>

        <div class="px-6 pb-6">
            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-4 transition hover:border-blue-300 hover:bg-blue-50/50">
                <input
                    type="checkbox"
                    name="is_admin"
                    value="1"
                    {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                    class="mt-1 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                >
                <span>
                    <span class="block text-sm font-semibold text-slate-800">Administrator</span>
                    <span class="mt-1 block text-xs leading-relaxed text-slate-500">
                        Berikan akses untuk masuk ke dashboard admin dan mengelola konten CV Digital.
                    </span>
                </span>
            </label>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-6 py-5 sm:flex-row sm:justify-end">
            <a
                href="{{ route('admin.users.index') }}"
                class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-100"
            >
                Batal
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
            >
                <i data-lucide="save" class="h-4 w-4"></i>
                {{ isset($user->id) ? 'Simpan Perubahan' : 'Buat Pengguna' }}
            </button>
        </div>
    </form>
</div>
@endsection

