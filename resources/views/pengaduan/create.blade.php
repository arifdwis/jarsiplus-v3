@extends('template::layouts.master')
@section('title','Layanan Pengaduan')
@section('content')
<div class="jp-section"><div class="l-container"><div class="jp-card" style="max-width:760px;margin:auto"><h1>Layanan Pengaduan JARSIPLUS</h1><p>Sampaikan kendala, masukan, atau laporan terkait layanan JARSIPLUS.</p>@if(session('success'))<div class="jp-notice jp-notice--success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="jp-notice jp-notice--danger">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('pengaduan.store') }}">@csrf<input class="jp-input u-mb-sm" name="nama" required placeholder="Nama lengkap" value="{{ old('nama') }}"><input class="jp-input u-mb-sm" name="email" type="email" placeholder="Email"><input class="jp-input u-mb-sm" name="telepon" placeholder="Nomor WhatsApp"><select class="jp-input u-mb-sm" name="kategori" required><option value="">Pilih kategori</option><option>Gangguan Sistem</option><option>Pengajuan Inovasi</option><option>Verifikasi</option><option>Lainnya</option></select><input class="jp-input u-mb-sm" name="judul" required placeholder="Judul pengaduan"><textarea class="jp-input u-mb-md" name="isi" rows="7" required placeholder="Jelaskan pengaduan Anda">{{ old('isi') }}</textarea><div class="cf-turnstile u-mb-md" data-sitekey="{{ config('services.cloudflare.turnstile.site_key') }}"></div><button class="jp-btn jp-btn--accent">Kirim Pengaduan</button></form></div></div></div>
@endsection
@section('js')<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>@endsection
