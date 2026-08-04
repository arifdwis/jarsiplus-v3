@extends('template::layouts.master')

@section('title', 'Kecamatan ' . ($parent->nama ?? '') . ' — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<section class="jp-section">
    <div class="l-container">
        <div class="u-max-w-600 u-mx-auto u-text-center">
            <p class="jp-section__eyebrow u-justify-center">
                <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
                PROFIL KECAMATAN
            </p>
            <h1 class="jp-section__title">{{ $parent->nama ?? 'Kecamatan' }}</h1>
            <div class="u-flex u-flex-col u-align-center u-mt-lg">
                <img src="{{ $parent->kecamatan->foto_camat ?? '' }}" alt="Camat {{ $parent->nama ?? '' }}"
                     style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid var(--c-accent);margin-bottom:12px">
                <h2>{{ $parent->kecamatan->camat ?? 'Camat' }}</h2>
                <p style="color:var(--c-text-muted)">Camat {{ $parent->nama ?? '' }}</p>
            </div>
        </div>
    </div>
</section>

<section class="jp-section" style="padding-top:0">
    <div class="l-container">
        <p class="jp-section__eyebrow">
            <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
            GALERI FOTO
        </p>
        <h2 class="jp-section__title">Dokumentasi Kegiatan</h2>
        <div class="l-grid l-grid--3 u-mt-lg" id="news">
            <p style="color:var(--c-text-muted)">Memuat data...</p>
        </div>
    </div>
</section>
@endsection

@section('js')
<script defer>
document.addEventListener('DOMContentLoaded', function() {
    fetch('?news=true')
        .then(function(r) { return r.json(); })
        .then(function(res) {
            var data = res.data || [];
            var html = '';
            data.forEach(function(item) {
                html += '<div class="jp-card u-text-center">';
                html += '<a href="' + (item.url || '#') + '" target="_blank">';
                html += '<img src="' + (item.thumbnail_m || '') + '" alt="Foto" style="width:100%;border-radius:6px;">';
                html += '</a></div>';
            });
            document.getElementById('news').innerHTML = html || '<p style="color:var(--c-text-muted)">Belum ada dokumentasi.</p>';
        })
        .catch(function() {
            document.getElementById('news').innerHTML = '<p style="color:var(--c-text-muted)">Gagal memuat data.</p>';
        });
});
</script>
@endsection
