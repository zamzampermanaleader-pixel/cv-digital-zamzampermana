@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')
@section('header', 'Pengaturan Website')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    @if(session('success'))
        <div class="p-4 rounded-xl bg-green-50 text-green-700 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 text-red-700 border border-red-200">
            <p class="font-semibold mb-2">Periksa kembali data berikut:</p>
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- IDENTITAS WEBSITE --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-2">Identitas Website</h2>
            <p class="text-sm text-slate-500 mb-6">Atur nama dan informasi utama website.</p>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Website</label>
                    <input type="text" name="site_title" required
                        value="{{ old('site_title', $settings['site_title']->value ?? 'CV Digital') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Website</label>
                    <textarea name="site_description" rows="4"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3">{{ old('site_description', $settings['site_description']->value ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Pemilik Website</label>
                    <input type="text" name="site_author"
                        value="{{ old('site_author', $settings['site_author']->value ?? '') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3">
                </div>
            </div>
        </section>

        {{-- LOGO DAN FAVICON --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-2">Logo dan Favicon</h2>
            <p class="text-sm text-slate-500 mb-6">Kelola identitas visual website.</p>

            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Logo Website</label>

                    @if(!empty($settings['site_logo']->value ?? null))
                        <div class="mb-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($settings['site_logo']->value) }}"
                                alt="Logo Website" class="max-h-24 max-w-full object-contain">
                            <p class="text-xs text-slate-500 mt-2">Logo saat ini</p>
                        </div>
                    @endif

                    <input type="file" name="site_logo" accept=".jpg,.jpeg,.png,.webp"
                        class="w-full text-sm border border-slate-300 rounded-xl p-3">
                    <p class="text-xs text-slate-500 mt-2">PNG, JPG, JPEG, WEBP. Maksimal 5 MB.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Favicon Website</label>

                    @if(!empty($settings['site_favicon']->value ?? null))
                        <div class="mb-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($settings['site_favicon']->value) }}"
                                alt="Favicon Website" class="w-16 h-16 object-contain">
                            <p class="text-xs text-slate-500 mt-2">Favicon saat ini</p>
                        </div>
                    @endif

                    <input type="file" name="site_favicon" accept=".png"
                        class="w-full text-sm border border-slate-300 rounded-xl p-3">
                    <p class="text-xs text-slate-500 mt-2">PNG. Maksimal 1 MB. Disarankan gambar persegi.</p>
                </div>
            </div>
        </section>

        {{-- SEO --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-2">Pengaturan SEO</h2>
            <p class="text-sm text-slate-500 mb-6">Atur informasi mesin pencari dan preview media sosial.</p>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Kunci SEO</label>
                    <textarea name="seo_keywords" rows="3"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3">{{ old('seo_keywords', $settings['seo_keywords']->value ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Media Sosial</label>
                    <input type="text" name="social_title"
                        value="{{ old('social_title', $settings['social_title']->value ?? '') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Media Sosial</label>
                    <textarea name="social_description" rows="3"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3">{{ old('social_description', $settings['social_description']->value ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Gambar Preview Media Sosial</label>

                    @if(!empty($settings['og_image']->value ?? null))
                        <div class="mb-4">
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($settings['og_image']->value) }}"
                                alt="Gambar Preview Media Sosial"
                                class="w-full max-w-md rounded-xl border border-slate-200">
                        </div>
                    @endif

                    <input type="file" name="og_image" accept=".jpg,.jpeg,.png,.webp"
                        class="w-full text-sm border border-slate-300 rounded-xl p-3">
                    <p class="text-xs text-slate-500 mt-2">PNG, JPG, JPEG, WEBP. Maksimal 5 MB. Disarankan rasio 1200 × 630 piksel.</p>
                </div>
            </div>
        </section>

        {{-- KONTAK --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-6">Informasi Kontak</h2>

            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email Kontak</label>
                    <input type="email" name="contact_email"
                        value="{{ old('contact_email', $settings['contact_email']->value ?? '') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp_number"
                        value="{{ old('whatsapp_number', $settings['whatsapp_number']->value ?? '') }}"
                        placeholder="628123456789"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    <p class="text-xs text-slate-500 mt-2">Gunakan kode negara, misalnya 628123456789.</p>
                </div>
            </div>
        </section>

        {{-- FOOTER --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-5">Footer Website</h2>
            <textarea name="footer_text" rows="3"
                class="w-full rounded-xl border border-slate-300 px-4 py-3"
                placeholder="Tulisan footer website...">{{ old('footer_text', $settings['footer_text']->value ?? '') }}</textarea>
        </section>

        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-cyan-600 px-6 py-3 font-semibold text-white hover:bg-cyan-700 transition">
                <i data-lucide="save" class="w-5 h-5"></i>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
