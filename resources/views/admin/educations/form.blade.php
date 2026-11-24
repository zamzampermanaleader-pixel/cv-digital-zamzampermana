
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Nama Institusi *
        </label>
        <input type="text"
            name="institution"
            value="{{ old('institution', $item->institution) }}"
            placeholder="Nama sekolah atau universitas"
            required
            maxlength="255"
            class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Jenjang / Gelar *
        </label>
        <input type="text"
            name="degree"
            value="{{ old('degree', $item->degree) }}"
            placeholder="S1, D3, SMA"
            required
            class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Jurusan / Bidang Studi
        </label>
        <input type="text"
            name="field_of_study"
            value="{{ old('field_of_study', $item->field_of_study) }}"
            placeholder="Teknik Informatika"
            class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Lokasi
        </label>
        <input type="text"
            name="location"
            value="{{ old('location', $item->location) }}"
            placeholder="Bandung, Indonesia"
            class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Tanggal Mulai
        </label>
        <input type="date"
            name="start_date"
            value="{{ old('start_date', $item->start_date?->format('Y-m-d')) }}"
            class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Tanggal Selesai
        </label>
        <input type="date"
            name="end_date"
            value="{{ old('end_date', $item->end_date?->format('Y-m-d')) }}"
            class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="md:col-span-2 space-y-4">

        <label class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl cursor-pointer">
            <input type="checkbox"
                name="is_current"
                value="1"
                @checked(old('is_current', $item->is_current))
                class="w-4 h-4 rounded text-blue-600">
            <span class="text-sm font-medium text-gray-700">
                Masih menempuh pendidikan
            </span>
        </label>

        <label class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl cursor-pointer">
            <input type="checkbox"
                name="is_visible"
                value="1"
                @checked(old('is_visible', $item->exists ? $item->is_visible : true))
                class="w-4 h-4 rounded text-blue-600">
            <span class="text-sm font-medium text-gray-700">
                Tampilkan di CV publik
            </span>
        </label>

    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Urutan Tampilan
        </label>
        <input type="number"
            name="sort_order"
            value="{{ old('sort_order', $item->sort_order ?? 0) }}"
            min="0"
            class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Deskripsi
        </label>
        <textarea name="description"
            rows="5"
            placeholder="Prestasi, kegiatan, atau informasi tambahan..."
            class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500">{{ old('description', $item->description) }}</textarea>
    </div>

</div>

<div class="flex flex-col sm:flex-row gap-3 mt-7 pt-5 border-t">

    <button type="submit"
        class="inline-flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">
        <i data-lucide="save" class="w-5 h-5"></i>
        {{ $item->exists ? 'Simpan Perubahan' : 'Simpan Pendidikan' }}
    </button>

    <a href="{{ route('admin.content.index', 'educations') }}"
        class="inline-flex justify-center items-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold">
        Batal
    </a>

</div>
