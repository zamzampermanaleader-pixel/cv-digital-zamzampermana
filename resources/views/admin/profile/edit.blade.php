
@extends('admin.layouts.app')

@section('title', 'Manajemen Profil')
@section('header', 'Manajemen Profil')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Profil Profesional</h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola informasi pribadi dan identitas profesional CV Digital Anda.
            </p>
        </div>

        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium
            {{ ($profile?->is_published ?? true) ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
            <span class="w-2 h-2 rounded-full
                {{ ($profile?->is_published ?? true) ? 'bg-green-500' : 'bg-gray-400' }}"></span>
            {{ ($profile?->is_published ?? true) ? 'Profil Dipublikasikan' : 'Profil Disembunyikan' }}
        </span>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- VALIDATION ERRORS --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">
            <div class="flex items-center gap-2 font-semibold mb-2">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                Periksa kembali data berikut:
            </div>

            <ul class="list-disc pl-6 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- MAIN PROFILE FORM --}}
    <form method="POST"
          action="{{ route('admin.profile.update') }}"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf
        @method('PUT')

        {{-- IDENTITAS PROFIL --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="font-bold text-gray-800">Identitas Profil</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Informasi utama yang ditampilkan pada CV Digital.
                </p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- FOTO --}}
                <div class="md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Foto Profil
                    </label>

                    <div class="flex flex-col items-center text-center border border-dashed border-gray-300 rounded-2xl p-5 bg-gray-50">

                        @if($profile?->photo)
                            <img id="photoPreview"
                                 src="{{ asset('storage/'.ltrim($profile->photo, '/')) }}"
                                 alt="Foto profil"
                                 class="w-36 h-36 rounded-full object-cover border-4 border-white shadow-md">
                        @else
                            <div id="photoPlaceholder"
                                 class="w-36 h-36 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i data-lucide="user-round" class="w-16 h-16"></i>
                            </div>

                            <img id="photoPreview"
                                 src=""
                                 alt="Preview foto"
                                 class="hidden w-36 h-36 rounded-full object-cover border-4 border-white shadow-md">
                        @endif

                        <label for="photo"
                               class="mt-5 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium cursor-pointer hover:bg-blue-700">
                            <i data-lucide="upload" class="w-4 h-4"></i>
                            Pilih Foto
                        </label>

                        <input type="file"
                               name="photo"
                               id="photo"
                               accept=".jpg,.jpeg,.png,.webp"
                               class="hidden">

                        <p class="text-xs text-gray-500 mt-3">
                            JPG, PNG atau WEBP. Maksimal 5 MB.
                        </p>
                    </div>
                </div>

                {{-- DATA PRIBADI --}}
                <div class="md:col-span-2 space-y-5">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                               name="full_name"
                               required
                               maxlength="255"
                               value="{{ old('full_name', $profile?->full_name) }}"
                               placeholder="Masukkan nama lengkap"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Profesi / Headline
                        </label>

                        <input type="text"
                               name="headline"
                               maxlength="255"
                               value="{{ old('headline', $profile?->headline) }}"
                               placeholder="Contoh: Web Developer | UI/UX Designer"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Ringkasan Profesional
                        </label>

                        <textarea name="summary"
                                  rows="5"
                                  placeholder="Ceritakan pengalaman, keahlian, dan tujuan profesional Anda..."
                                  class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('summary', $profile?->summary) }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        {{-- INFORMASI KONTAK --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="p-6 border-b border-gray-100">
                <h2 class="font-bold text-gray-800">Informasi Kontak</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Informasi yang dapat digunakan untuk menghubungi Anda.
                </p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email"
                           name="email"
                           maxlength="255"
                           value="{{ old('email', $profile?->email) }}"
                           placeholder="nama@email.com"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nomor Telepon / WhatsApp
                    </label>
                    <input type="text"
                           name="phone"
                           maxlength="30"
                           value="{{ old('phone', $profile?->phone) }}"
                           placeholder="08xxxxxxxxxx"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kota / Lokasi
                    </label>
                    <input type="text"
                           name="location"
                           maxlength="255"
                           value="{{ old('location', $profile?->location) }}"
                           placeholder="Contoh: Tasikmalaya, Indonesia"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Website / Portfolio
                    </label>
                    <input type="url"
                           name="website"
                           maxlength="255"
                           value="{{ old('website', $profile?->website) }}"
                           placeholder="https://website.com"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat Lengkap
                    </label>
                    <textarea name="address"
                              rows="2"
                              maxlength="255"
                              placeholder="Masukkan alamat lengkap"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $profile?->address) }}</textarea>
                </div>

            </div>
        </div>

        {{-- DOKUMEN CV --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="font-bold text-gray-800">Dokumen Curriculum Vitae</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Unggah dan kelola dokumen CV dalam format PDF.
                </p>
            </div>

            <div class="p-6">

                @if($resumeFileExists)
                    <div class="p-5 bg-blue-50 border border-blue-100 rounded-xl mb-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center">
                                    <i data-lucide="file-pdf" class="w-6 h-6"></i>
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-800">Dokumen CV tersedia</p>

                                    <p class="text-xs text-gray-500 mt-1">
                                        Format PDF · {{ $resumeSize }} MB
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        Terakhir diperbarui: {{ $resumeUpdatedAt }}
                                    </p>
                                </div>
                            </div>

                            <a href="{{ route('cv.download') }}"
                               class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-semibold text-blue-600 hover:bg-gray-50">
                                <i data-lucide="download" class="w-4 h-4"></i>
                                Unduh CV
                            </a>
                        </div>

                        <div class="mt-5 pt-4 border-t border-blue-200">
                            <button type="submit"
                                    form="deleteResumeForm"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                Hapus Dokumen CV
                            </button>
                        </div>
                    </div>
                @else
                    <div class="p-5 bg-gray-50 border border-dashed border-gray-300 rounded-xl mb-5">
                        <div class="flex items-center gap-3">
                            <i data-lucide="file-x" class="w-8 h-8 text-gray-400"></i>

                            <div>
                                <p class="font-semibold text-gray-700">
                                    Belum ada dokumen CV
                                </p>

                                <p class="text-sm text-gray-500">
                                    Silakan unggah dokumen CV PDF Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <label for="resume_file" class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ $resumeFileExists ? 'Ganti Dokumen CV' : 'Unggah Dokumen CV' }}
                </label>

                <input type="file"
                       name="resume_file"
                       id="resume_file"
                       accept=".pdf,application/pdf"
                       class="w-full border border-gray-200 rounded-xl p-3 text-sm">

                <p class="text-xs text-gray-500 mt-2">
                    Format PDF, maksimal 10 MB.
                    @if($resumeFileExists)
                        Kosongkan jika tidak ingin mengganti CV lama.
                    @endif
                </p>
            </div>
        </div>

        {{-- PUBLIKASI WEBSITE --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-bold text-gray-800 mb-2">
                Pengaturan Website Publik
            </h2>

            <p class="text-sm text-gray-500 mb-5">
                Tentukan apakah profil ini dapat dilihat oleh pengunjung website.
            </p>

            <input type="hidden" name="is_published" value="0">

            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox"
                       name="is_published"
                       value="1"
                       @checked(old('is_published', $profile?->is_published ?? true))
                       class="w-5 h-5 mt-0.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                <span>
                    <span class="block font-semibold text-gray-800">
                        Publikasikan profil
                    </span>

                    <span class="block text-sm text-gray-500 mt-1">
                        Profil dapat ditampilkan pada halaman utama CV Digital.
                    </span>
                </span>
            </label>
        </div>

        {{-- TOMBOL SIMPAN --}}
        <div class="flex flex-col sm:flex-row justify-end gap-3">
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-7 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-sm transition">
                <i data-lucide="save" class="w-5 h-5"></i>
                Simpan Perubahan Profil
            </button>
        </div>

    </form>

    {{-- FORM HAPUS CV: DILETAKKAN DI LUAR FORM UTAMA --}}
    @if($resumeFileExists)
        <form id="deleteResumeForm"
              method="POST"
              action="{{ route('admin.profile.resume.delete') }}"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen CV ini?')"
              class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif

</div>

{{-- PREVIEW FOTO --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('photo');
    const preview = document.getElementById('photoPreview');
    const placeholder = document.getElementById('photoPlaceholder');

    if (!input || !preview) {
        return;
    }

    input.addEventListener('change', function (event) {
        const file = event.target.files[0];

        if (!file) {
            return;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            alert('Format foto harus JPG, PNG, atau WEBP.');
            input.value = '';
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran foto maksimal 5 MB.');
            input.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');

            if (placeholder) {
                placeholder.classList.add('hidden');
            }
        };

        reader.readAsDataURL(file);
    });
});
</script>
@endsection
