@extends('admin.layouts.app')

@section('title', 'Form Pendidikan')
@section('header', 'Form Pendidikan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div>
        <a href="{{ route('admin.content.index', 'educations') }}"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Pendidikan
        </a>

        <h1 class="text-2xl font-bold text-gray-800">
            {{ $item->exists ? 'Edit Pendidikan' : 'Tambah Pendidikan' }}
        </h1>
        <p class="text-sm text-gray-500 mt-1">Lengkapi informasi riwayat pendidikan Anda.</p>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700">
            <p class="font-semibold mb-2">Periksa kembali formulir:</p>
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ $item->exists
                ? route('admin.content.update', ['educations', $item->id])
                : route('admin.content.store', 'educations') }}"
          class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 space-y-6">

        @csrf
        @if($item->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Institusi / Sekolah / Universitas *</label>
            <input type="text" name="institution"
                   value="{{ old('institution', $item->institution) }}"
                   required maxlength="255"
                   placeholder="Contoh: Universitas Indonesia"
                   class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenjang / Gelar</label>
                <input type="text" name="degree"
                       value="{{ old('degree', $item->degree) }}"
                       placeholder="Contoh: S1, S2, SMA"
                       class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Bidang Studi / Jurusan</label>
                <input type="text" name="field_of_study"
                       value="{{ old('field_of_study', $item->field_of_study) }}"
                       placeholder="Contoh: Teknik Informatika"
                       class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi</label>
            <input type="text" name="location"
                   value="{{ old('location', $item->location) }}"
                   placeholder="Contoh: Bandung, Indonesia"
                   class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" name="start_date"
                       value="{{ old('start_date', $item->start_date?->format('Y-m-d')) }}"
                       class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai</label>
                <input type="date" name="end_date"
                       value="{{ old('end_date', $item->end_date?->format('Y-m-d')) }}"
                       class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <div class="space-y-3">
            <label class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl cursor-pointer">
                <input type="checkbox" name="is_current" value="1"
                       @checked(old('is_current', $item->is_current))
                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="text-sm font-medium text-gray-700">Saya masih menempuh pendidikan ini</span>
            </label>

            <label class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl cursor-pointer">
                <input type="checkbox" name="is_visible" value="1"
                       @checked(old('is_visible', $item->exists ? $item->is_visible : true))
                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="text-sm font-medium text-gray-700">Tampilkan pendidikan pada website CV</span>
            </label>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
            <textarea name="description" rows="5"
                      placeholder="Tuliskan informasi tambahan, prestasi, atau kegiatan selama pendidikan..."
                      class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('description', $item->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan Tampilan</label>
            <input type="number" name="sort_order" min="0"
                   value="{{ old('sort_order', $item->exists ? $item->sort_order : 0) }}"
                   class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <p class="text-xs text-gray-500 mt-1">Angka lebih kecil ditampilkan lebih dahulu.</p>
        </div>

        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-5 border-t">
            <a href="{{ route('admin.content.index', 'educations') }}"
               class="px-5 py-3 rounded-xl border border-gray-300 text-gray-700 text-center font-semibold hover:bg-gray-50">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                <i data-lucide="save" class="w-5 h-5"></i>
                {{ $item->exists ? 'Simpan Perubahan' : 'Simpan Pendidikan' }}
            </button>
        </div>
    </form>
</div>
@endsection