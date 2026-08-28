@extends('template::layouts.master')

@section('title', 'Pembahasan & Diskusi Berkas — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<x-page-header
    badge="PEMBAHASAN BERKAS"
    :title="$data->label"
    :back="route('indikator.data.index', $parent->uuid)"
    backLabel="Kembali ke Data Dukung"
>
    @if($data->url)
        <a href="{{ file_url($data->url) }}" target="_blank" rel="noopener" class="jp-btn jp-btn--accent">
            <x-icon name="link" size="16" />
            Buka Tautan Berkas
        </a>
    @elseif($data->file)
        <a href="{{ file_url($data->file) }}" target="_blank" rel="noopener" class="jp-btn jp-btn--accent">
            <x-icon name="download" size="16" />
            Unduh Berkas
        </a>
    @endif
</x-page-header>

<div class="jp-subhead">
    <div class="l-container jp-subhead__inner">
        <span class="jp-badge {{ $data->status == 1 ? 'jp-badge--success' : 'jp-badge--amber' }}">
            {{ $data->status == 1 ? 'TERVALIDASI' : 'TELAH DIUNGGAH' }}
        </span>
        <span class="jp-subhead__meta">
            <x-icon name="clipboard" size="14" />
            Indikator: <strong>{{ $parent->label_indikator ?? $parent->label }}</strong>
        </span>
        <span class="jp-subhead__meta">
            <x-icon name="file" size="14" />
            @if(filled($data->nomor_surat))
                No. Surat: {{ $data->nomor_surat }}
            @else
                <span class="jp-value-empty"></span>
            @endif
        </span>
        <span class="jp-subhead__meta font-mono">
            <x-icon name="calendar" size="14" />
            {{ $data->created_at ? $data->created_at->format('d M Y') : 'Tanggal tidak tersedia' }}
        </span>
    </div>
</div>

<div class="jp-section jp-section--sm">
    <div class="l-container l-container--narrow">

        <div class="jp-card u-p-0" style="overflow: hidden;">
            <header class="jp-modal__head">
                <div class="u-flex u-align-center u-gap-sm">
                    <span class="jp-modal__icon"><x-icon name="chat" size="20" /></span>
                    <div>
                        <h2 class="jp-modal__title">Catatan &amp; Diskusi Berkas</h2>
                        <span class="jp-modal__eyebrow">Riwayat pembahasan antara pemohon dan tim verifikator</span>
                    </div>
                </div>
            </header>

            <div id="chat-view" class="jp-chat-feed" style="max-height: 480px;">
                {{-- Dimuat ulang lewat AJAX setelah kirim pesan --}}
                @include('template::permohonan.pembahasan.chat')
            </div>

            {!! Form::open(['route' => ['indikator.data.pembahasan.store', $parent->uuid, $data->uuid], 'autocomplete' => 'off', 'id' => 'form-chat', 'class' => 'jp-chat-compose']) !!}
                <div class="jp-searchbar">
                    <label for="input-chat" class="u-sr-only">Tulis komentar</label>
                    <input type="text" name="komentar" id="input-chat" class="jp-input" required placeholder="Tulis komentar atau catatan penjelasan berkas…">
                    <button type="submit" class="jp-btn jp-btn--accent">Kirim</button>
                </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var chatView = document.getElementById('chat-view');

    function scrollToBottom() {
        if (chatView) {
            chatView.scrollTop = chatView.scrollHeight;
        }
    }

    scrollToBottom();

    var formChat = document.getElementById('form-chat');
    if (formChat) {
        formChat.addEventListener('submit', function (e) {
            e.preventDefault();
            var inputChat = document.getElementById('input-chat');
            var val = inputChat ? inputChat.value.trim() : '';

            if (val !== '') {
                var formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(function(res) { return res.text(); })
                .then(function(html) {
                    if (inputChat) inputChat.value = '';
                    // Muat ulang umpan percakapan
                    fetch('?ajax=true', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function(r) { return r.text(); })
                    .then(function(feedHtml) {
                        if (chatView) {
                            chatView.innerHTML = feedHtml;
                            scrollToBottom();
                        }
                    });
                })
                .catch(function(err) {
                    console.error('Chat error:', err);
                });
            }
        });
    }
});
</script>
@endsection
