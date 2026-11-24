@extends('admin.layouts.app')

@section('title', ($item->exists ? 'Edit ' : 'Tambah ').$config['title'])
@section('header', $config['title'])

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div>
        <a href="{{ route('admin.content.index', $module) }}"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke {{ $config['title'] }}
        </a>

        <h1 class="text-2xl font-bold text-gray-800">
            {{ $item->exists ? 'Edit' : 'Tambah' }} {{ $config['title'] }}
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Lengkapi informasi berikut untuk memperbarui CV Digital Anda.
        </p>
    </div>

    {{-- ERRORS --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-5">
            <div class="flex items-center gap-2 font-semibold mb-2">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                Terdapat kesalahan pada formulir.
            </div>
            <ul class="list-disc pl-6 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ $item->exists
              ? route('admin.content.update', [$module, $item->id])
              : route('admin.content.store', $module) }}"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf

        @if($item->exists)
            @method('PUT')
        @endif

        {{-- FORM FIELDS --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="p-6 border-b border-gray-100">
                <h2 class="font-bold text-gray-800">Informasi {{ $config['title'] }}</h2>
                <p class="text-sm text-gray-500 mt-1">Masukkan informasi secara lengkap dan benar.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                @foreach($config['fields'] as $name => $field)

                    @if($field['type'] === 'checkbox')

                        <div class="md:col-span-2">
                            <input type="hidden" name="{{ $name }}" value="0">

                            <label class="flex items-start gap-3 p-4 bg-gray-50 border border-gray-100 rounded-xl cursor-pointer hover:bg-blue-50 transition">
                                <input type="checkbox"
                                       name="{{ $name }}"
                                       value="1"
                                       @checked(old($name, $item->$name ?? false))
                                       class="w-5 h-5 mt-0.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                                <span>
                                    <span class="block text-sm font-semibold text-gray-800">
                                        {{ $field['label'] }}
                                    </span>
                                    <span class="block text-xs text-gray-500 mt-1">
                                        Aktifkan pilihan ini jika ingin menggunakan pengaturan tersebut.
                                    </span>
                                </span>
                            </label>
                        </div>

                    @else

                        <div class="{{ $field['type'] === 'textarea' ? 'md:col-span-2' : '' }}">

                            <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ $field['label'] }}

                                @if($field['required'] ?? false)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>

                            @if($field['type'] === 'textarea')

                                <textarea id="{{ $name }}"
                                          name="{{ $name }}"
                                          rows="5"
                                          @required($field['required'] ?? false)
                                          placeholder="Masukkan {{ strtolower($field['label']) }}"
                                          class="w-full border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old($name, $item->$name) }}</textarea>

                            @elseif(in_array($field['type'], ['image', 'file']))

                                <div class="space-y-3">

                                    @if($item->$name)
                                        <div class="flex items-center gap-3 p-3 bg-blue-50 border border-blue-100 rounded-xl">

                                            @if($field['type'] === 'image')
                                                <img src="{{ asset('storage/'.$item->$name) }}"
                                                     alt="File saat ini"
                                                     class="w-16 h-16 rounded-lg object-cover">
                                            @else
                                                <div class="w-12 h-12 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                                                    <i data-lucide="file-pdf" class="w-6 h-6"></i>
                                                </div>
                                            @endif

                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-semibold text-gray-800">File saat ini tersedia</p>
                                                <p class="text-xs text-gray-500 truncate">{{ basename($item->$name) }}</p>
                                            </div>

                                            <a href="{{ asset('storage/'.$item->$name) }}"
                                               target="_blank"
                                               class="text-sm text-blue-600 font-semibold hover:underline">
                                                Lihat
                                            </a>
                                        </div>
                                    @endif

                                    <input type="file"
                                           id="{{ $name }}"
                                           name="{{ $name }}"
                                           accept="{{ $field['type'] === 'image' ? '.jpg,.jpeg,.png,.webp' : '.pdf' }}"
                                           class="w-full border border-gray-200 rounded-xl p-3 text-sm bg-white">

                                    <p class="text-xs text-gray-500">
                                        @if($field['type'] === 'image')
                                            Format JPG, PNG atau WEBP. Maksimal 5 MB.
                                        @else
                                            Format PDF. Maksimal 10 MB.
                                        @endif
                                        Kosongkan jika tidak ingin mengganti file lama.
                                    </p>
                                </div>

                            @else

                                @php
                                    $value = old($name, $item->$name);

                                    if ($name === 'technologies' && is_array($value)) {
                                        $value = implode(', ', $value);
                                    }

                                    if ($value instanceof \Carbon\CarbonInterface) {
                                        $value = $value->format('Y-m-d');
                                    }
                                @endphp

                                <input type="{{ $field['type'] }}"
                                       id="{{ $name }}"
                                       name="{{ $name }}"
                                       value="{{ $value }}"
                                       @required($field['required'] ?? false)
                                       @if($field['type'] === 'number')
                                           min="0"
                                           @if($name === 'proficiency') max="100" @endif
                                       @endif
                                       placeholder="Masukkan {{ strtolower($field['label']) }}"
                                       class="w-full border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                            @endif
                        </div>

                    @endif

                @endforeach

            </div>
        </div>

        {{-- ACTION --}}
        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

            <a href="{{ route('admin.content.index', $module) }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200">
                Batal
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-7 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 shadow-sm">
                <i data-lucide="save" class="w-5 h-5"></i>
                {{ $item->exists ? 'Simpan Perubahan' : 'Simpan Data' }}
            </button>

        </div>

    </form>
</div>
@endsection