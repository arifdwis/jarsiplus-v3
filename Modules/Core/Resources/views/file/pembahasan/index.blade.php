@extends('layouts.app')

@section('title', 'Pembahasan Berkas — ' . ($kategori->label ?? 'Diskusi'))

@section('content')
<div class="content container-fluid">

    @include('nue::partials.breadcrumb', [
        'title' => 'Pembahasan Berkas',
        'lists' => [
            'Dashboard' => '/',
            'File Data Dukung' => (isset($kategori) && isset($kategori->permohonan)) ? route('epanel.permohonan.file.index', $kategori->permohonan->uuid ?? $kategori->id_permohonan) : 'javascript:;',
            'Pembahasan Berkas' => 'active'
        ]
    ])

    {{-- Header File Card --}}
    <div class="card card-bordered shadow-none rounded-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-soft-primary text-primary" style="font-size: 11px; font-weight: 700;">PEMBAHASAN BERKAS</span>
                        <span class="badge bg-soft-{{ $kategori->status == 1 ? 'success' : 'warning' }} text-{{ $kategori->status == 1 ? 'success' : 'warning' }}" style="font-size: 11px;">
                            {{ $kategori->status == 1 ? 'TERVALIDASI / DISETUJUI' : 'TELAH DIUNGGAH' }}
                        </span>
                    </div>
                    <h3 class="card-title mb-1" style="font-weight: 700; color: #1e293b;">{{ $kategori->label }}</h3>
                    <p class="text-muted small mb-0">
                        @if($kategori->nomor_surat)
                            No. Surat: <strong>{{ $kategori->nomor_surat }}</strong> &middot; 
                        @endif
                        Tanggal Upload: <strong>{{ $kategori->created_at ? $kategori->created_at->format('d M Y, H:i') : '-' }}</strong>
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    @if($kategori->url)
                        <a href="{{ $kategori->url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <span class="iconify me-1" data-icon="solar:link-bold"></span> Buka Link URL &rarr;
                        </a>
                    @elseif($kategori->file)
                        <a href="{{ asset($kategori->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <span class="iconify me-1" data-icon="solar:download-bold"></span> Unduh Berkas &rarr;
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Chat Messages Box --}}
    <div class="card card-bordered shadow-none rounded-0 mb-4">
        <div class="card-header border-bottom bg-white py-3">
            <h5 class="card-title mb-0 fw-bold">
                <span class="iconify text-primary me-2" data-icon="solar:chat-dots-bold"></span> Catatan &amp; Diskusi Berkas
            </h5>
        </div>
        <div class="card-body p-4">
            @if($data->count())
                <div class="chat-thread mb-4" style="max-height: 480px; overflow-y: auto; padding-right: 8px;">
                    @foreach ($data as $value)
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-sm avatar-circle bg-soft-primary text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; font-size: 14px;">
                                    {{ strtoupper(substr(optional($value->operator)->name ?? 'User', 0, 2)) }}
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="bg-light p-3 rounded" style="border: 1px solid #e2e8f0;">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0 fw-bold text-dark">{{ optional($value->operator)->name ?? 'Verifikator / Operator' }}</h6>
                                        <small class="text-muted">{{ $value->created_at ? $value->created_at->diffForHumans() : '-' }}</small>
                                    </div>
                                    <p class="mb-0 text-secondary" style="font-size: 13.5px; white-space: pre-line;">{{ $value->komentar ?? $value->slug }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 my-2">
                    <span class="iconify display-4 text-muted d-block mb-3" data-icon="solar:chat-square-quote-bold"></span>
                    <h5 class="fw-bold text-dark mb-1">Belum Ada Catatan Pembahasan</h5>
                    <p class="text-muted small mb-0">Mari membuat catatan pertama untuk memberikan masukan/pembahasan pada berkas ini.</p>
                </div>
            @endif

            {{-- Form Input Catatan Pembahasan --}}
            <div class="border-top pt-4">
                <form action="{{ route($prefix . '.store', $kategori->uuid) }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="komentar" class="form-label fw-bold text-dark">Tulis Catatan Pembahasan / Tanggapan Baru:</label>
                        <textarea name="komentar" id="komentar" class="form-control" rows="3" required placeholder="Tuliskan catatan perbaikan atau penjelasan berkas di sini..."></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <span class="iconify me-1" data-icon="solar:send-bold"></span> Kirim Catatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection