@extends('admin.layouts.app')

@section('title', 'Detail Pesan')
@section('header', 'Detail Pesan Pengunjung')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Detail Pesan</h1>
            <p class="text-sm text-slate-500 mt-1">Pesan yang dikirim melalui formulir website.</p>
        </div>

        <span class="rounded-full px-3 py-1.5 text-xs font-semibold
            {{ $message->is_read ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
            {{ $message->is_read ? 'Sudah dibaca' : 'Belum dibaca' }}
        </span>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <p class="text-sm text-slate-500">Pengirim</p>
            <h2 class="text-xl font-bold text-slate-900 mt-1">{{ $message->name }}</h2>
            <a href="mailto:{{ $message->email }}" class="text-sm text-blue-600 hover:underline">
                {{ $message->email }}
            </a>
            <p class="text-xs text-slate-400 mt-3">
                Diterima {{ $message->created_at?->format('d M Y, H:i') }}
            </p>
        </div>

        <div class="p-6 space-y-5">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Subjek</p>
                <p class="font-semibold text-slate-800">{{ $message->subject ?: 'Tanpa subjek' }}</p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Isi Pesan</p>
                <div class="rounded-xl bg-slate-50 border border-slate-100 p-5 text-slate-700 whitespace-pre-line leading-relaxed">{{ $message->message }}</div>
            </div>

            <div>
                <label for="replyMessage" class="block text-sm font-semibold text-slate-700 mb-2">
                    Tulis Balasan
                </label>
                <textarea id="replyMessage" rows="6"
                    class="w-full rounded-xl border border-slate-300 p-4 outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Tuliskan balasan untuk pengirim pesan..."></textarea>
                <p class="text-xs text-slate-400 mt-2">
                    Tombol balas akan membuka aplikasi email yang terpasang pada perangkat Anda.
                </p>
            </div>
        </div>

        <div class="p-6 border-t border-slate-100 flex flex-wrap gap-3">
            <a href="{{ route('admin.messages.index') }}"
               class="rounded-xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">
                Kembali
            </a>

            <button type="button" onclick="sendReply()"
               class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                Balas melalui Email
            </button>
        </div>
    </div>
</div>

<script>
function sendReply() {
    const reply = document.getElementById('replyMessage').value.trim();

    if (!reply) {
        alert('Silakan tulis isi balasan terlebih dahulu.');
        return;
    }

    const recipient = @json($message->email);
    const subject = @json('Re: ' . ($message->subject ?: 'Pesan dari website CV Digital'));
    const body = encodeURIComponent(reply);

    window.location.href =
        'mailto:' + encodeURIComponent(recipient) +
        '?subject=' + encodeURIComponent(subject) +
        '&body=' + body;
}
</script>
@endsection
