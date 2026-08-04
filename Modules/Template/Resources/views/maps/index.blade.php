@extends('template::layouts.master',['footer'=>false])

@section('content')
<div class="jp-section">
    <div class="l-container">
        <div class="jp-section__head u-flex u-justify-between u-align-center u-flex-wrap u-gap-md u-mb-xl">
            <div>
                <p class="jp-section__eyebrow">
                    <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
                    PEMETAAN
                </p>
                <h1 class="jp-section__title" style="margin-bottom:0">Peta Inovasi</h1>
            </div>
        </div>

        <div class="jp-card" style="min-height:500px">
            <div id="map" style="width:100%;height:500px;border-radius:var(--r-card);overflow:hidden;background:var(--c-bg)"></div>
        </div>

        <div class="l-grid l-grid--4 u-mt-xl">
            <div class="jp-stat-tile">
                <p class="jp-stat-tile__label">Total Inovasi</p>
                <h2 class="jp-stat-tile__value">{{ $total ?? 0 }}</h2>
            </div>
            <div class="jp-stat-tile">
                <p class="jp-stat-tile__label">Kecamatan</p>
                <h2 class="jp-stat-tile__value">{{ $kecamatan ?? 0 }}</h2>
            </div>
            <div class="jp-stat-tile">
                <p class="jp-stat-tile__label">Desa/Kelurahan</p>
                <h2 class="jp-stat-tile__value">{{ $desa ?? 0 }}</h2>
            </div>
            <div class="jp-stat-tile">
                <p class="jp-stat-tile__label">Instansi</p>
                <h2 class="jp-stat-tile__value">{{ $instansi ?? 0 }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var mapEl = document.getElementById('map');
    if (mapEl && typeof L !== 'undefined') {
        var map = L.map('map').setView([-3.3186, 114.5944], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        @if(isset($markers) && count($markers))
            @foreach($markers as $m)
                @if($m->lat && $m->lng)
                    L.marker([{{ $m->lat }}, {{ $m->lng }}]).addTo(map).bindPopup('{{ addslashes($m->title ?? $m->name ?? '') }}');
                @endif
            @endforeach
        @endif
    }
});
</script>
@endsection