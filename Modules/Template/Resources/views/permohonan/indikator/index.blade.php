@extends('template::layouts.master')

@section('title', 'Indikator Inovasi — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
@php
    $totalFilesCount = 0;
    $approvedFilesCount = 0;
    foreach($data as $pItem) {
        if ($pItem->files) {
            $totalFilesCount += $pItem->files->count();
            $approvedFilesCount += $pItem->files->where('status', 1)->count();
        }
    }
    $pendingFilesCount = $totalFilesCount - $approvedFilesCount;
@endphp

<x-page-header
    badge="INDIKATOR INOVASI"
    :title="$parent->label"
    desc="Lengkapi berkas data dukung dan tentukan parameter untuk setiap indikator inovasi daerah."
    :back="route('permohonan.show', $parent->kode ?? $parent->uuid)"
    backLabel="Kembali ke Permohonan"
/>

<div class="jp-subhead">
    <div class="l-container jp-subhead__inner">
        <span class="jp-badge jp-badge--neutral font-mono">KODE: {{ $parent->kode }}</span>
        <span class="jp-subhead__meta">20 parameter indikator</span>
    </div>
</div>

<div class="jp-section jp-section--sm">
    <div class="l-container">

        {{-- Ringkasan berkas --}}
        <div class="l-grid l-grid--3 u-mb-lg">
            <x-stat-tile label="Total Berkas Data Dukung" :value="$totalFilesCount"    icon="folder"       accent="var(--c-accent)" />
            <x-stat-tile label="Berkas Disetujui"         :value="$approvedFilesCount" icon="check-circle" accent="var(--c-success)" />
            <x-stat-tile label="Belum Disetujui"          :value="$pendingFilesCount"  icon="clock"        accent="var(--c-amber)" />
        </div>

        {{-- Petunjuk --}}
        <div class="jp-notice jp-notice--accent u-mb-lg">
            <span class="jp-notice__icon"><x-icon name="info" size="20" /></span>
            <div class="jp-notice__body">
                <strong class="jp-notice__title">Petunjuk pengisian indikator</strong>
                <p class="jp-notice__text">
                    Unggah <strong>data dukung</strong> terlebih dahulu untuk setiap indikator sebelum memilih parameter.
                    Jika bukti dukung belum diunggah, bobot nilai indikator tidak dapat dihitung.
                </p>
            </div>
        </div>

        {{-- Daftar indikator --}}
        @if(count($data) > 0)
            <div class="l-grid l-grid--3">
                @foreach($data as $index => $temp)
                    @php
                        $pendaftaranDitutup = role_me() == 4 && pendaftaran_inovasi_ditutup();
                        $fileIds = $temp->files ? $temp->files->pluck('id')->filter()->toArray() : [];
                        $fTotal = $temp->files ? $temp->files->count() : 0;
                        $fApproved = $temp->files ? $temp->files->where('status', 1)->count() : 0;

                        $hasChat = \Modules\Core\Entities\Pembahasan::where('id_histori', $temp->id)
                                        ->orWhere(function($q) use ($fileIds) {
                                            if (!empty($fileIds)) {
                                                $q->whereIn('id_file', $fileIds);
                                            }
                                        })->exists();

                        // Indikator dianggap SUDAH DIBAHAS jika:
                        // 1. Seluruh berkas data dukungnya sudah disetujui (misal 1/1, 2/2)
                        // 2. Atau bobot nilainya sudah ditetapkan (bobot != null)
                        // 3. Atau terdapat berkas yang disetujui
                        // 4. Atau ada histori percakapan pembahasan
                        $isDiscussed = ($fTotal > 0 && $fApproved == $fTotal) || ($temp->bobot !== null) || $hasChat || ($fApproved > 0);

                        $parameterTerpilih = $temp->label_parameter ?? ($temp->parameters->label ?? null);
                        $filePercent = $fTotal > 0 ? round(($fApproved / $fTotal) * 100) : 0;
                    @endphp

                    <article class="jp-record-card {{ $isDiscussed ? 'jp-record-card--success' : 'jp-record-card--amber' }}">
                        <header class="jp-record-card__head">
                            <span class="jp-record-card__code">#{{ sprintf('%02d', $index + 1) }}</span>
                            @if($isDiscussed)
                                <span class="jp-badge jp-badge--success">
                                    <x-icon name="check-circle" size="12" /> SUDAH DIBAHAS
                                </span>
                            @else
                                <span class="jp-badge jp-badge--amber">
                                    <x-icon name="clock" size="12" /> BELUM DIBAHAS
                                </span>
                            @endif
                        </header>

                        <div class="jp-record-card__body">
                            <h3 class="jp-record-card__title">{{ $temp->label_indikator }}</h3>

                            @if($temp->parameter_id)
                                <div class="jp-mini-panel">
                                    <span class="jp-deflist__label">Parameter terpilih</span>
                                    <strong class="jp-deflist__value">{{ $parameterTerpilih ?? 'Tidak diketahui' }}</strong>
                                    @if($temp->bobot)
                                        <span class="font-mono" style="font-size: var(--t-xs); color: var(--c-success); font-weight: 700;">
                                            Bobot: {{ $temp->bobot }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <p class="jp-card__text jp-clamp-3">
                                    {{ $temp->indikators->deskripsi ?? 'Pilih parameter dan unggah data dukung untuk indikator ini.' }}
                                </p>
                            @endif

                            {{-- Progres berkas --}}
                            <div class="u-mt-auto">
                                <div class="u-flex u-justify-between u-align-center u-gap-sm u-mb-2xs">
                                    <span style="font-size: var(--t-xs); color: var(--c-ink-muted);">Berkas disetujui</span>
                                    @if($fTotal > 0)
                                        <strong class="font-mono" style="font-size: var(--t-xs); color: var(--c-ink);">
                                            {{ $fApproved }}/{{ $fTotal }}
                                        </strong>
                                    @else
                                        <span class="jp-badge jp-badge--neutral">Belum ada data</span>
                                    @endif
                                </div>
                                @if($fTotal > 0)
                                    <div class="jp-meter">
                                        <div class="jp-meter__fill {{ $fApproved == $fTotal ? 'jp-meter__fill--success' : '' }}" style="width: {{ $filePercent }}%;"></div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <footer class="jp-record-card__foot">
                            <a href="{{ route('indikator.data.index', [$temp->uuid]) }}" class="jp-btn jp-btn--ghost jp-btn--sm">
                                Data Dukung
                            </a>
                            <button type="button" class="jp-btn jp-btn--accent jp-btn--sm indikator-trigger" data-id="{{ $temp->id }}">
                                Parameter <span aria-hidden="true">&rarr;</span>
                            </button>
                        </footer>
                    </article>

                    {{-- Modal parameter --}}
                    <dialog class="indikator-modal jp-modal" id="modal-{{ $temp->id }}">
                        <div class="jp-modal__head">
                            <div style="min-width: 0;">
                                <span class="jp-badge jp-badge--accent u-mb-xs">INDIKATOR #{{ sprintf('%02d', $index + 1) }}</span>
                                <h3 class="jp-modal__title">{{ $temp->label_indikator }}</h3>
                            </div>
                            <button type="button" class="jp-modal__close md-close" data-close="{{ $temp->id }}" aria-label="Tutup">
                                <x-icon name="close" size="22" />
                            </button>
                        </div>

                        <div class="jp-modal__body">
                            @if(!empty($temp->indikators->deskripsi))
                                <p class="jp-card__text u-mb-md">{{ $temp->indikators->deskripsi }}</p>
                            @endif

                            <div class="jp-notice jp-notice--amber u-mb-md">
                                <span class="jp-notice__icon"><x-icon name="info" size="18" /></span>
                                <div class="jp-notice__body">
                                    <p class="jp-notice__text">
                                        Unggah <strong>data dukung</strong> terlebih dahulu sebelum memilih parameter.
                                        Bobot nilai tidak dihitung jika bukti dukung masih kosong.
                                    </p>
                                </div>
                            </div>

                            @if($temp->parameter_id)
                                <div class="jp-notice jp-notice--success u-mb-md">
                                    <span class="jp-notice__icon"><x-icon name="check-circle" size="18" /></span>
                                    <div class="jp-notice__body">
                                        <strong class="jp-notice__title">Parameter terpilih</strong>
                                        <p class="jp-notice__text">
                                            {{ $parameterTerpilih ?? 'Tidak diketahui' }}
                                            @if($temp->bobot)<br>Bobot nilai: <strong>{{ $temp->bobot }}</strong>@endif
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if($pendaftaranDitutup)
                                <div class="jp-notice jp-notice--danger">
                                    <span class="jp-notice__icon"><x-icon name="lock" size="18" /></span>
                                    <div class="jp-notice__body">
                                        <p class="jp-notice__text">{{ pendaftaran_inovasi_pesan_tutup() }}</p>
                                    </div>
                                </div>
                            @elseif(role_me() == 4)
                                {!! Form::model($temp, ['route' => ["$prefix.update", $parent->uuid, $temp->id], 'autocomplete' => 'off', 'files' => true, 'method' => 'PUT', 'id' => 'formParameter-'.$temp->id]) !!}
                                    <div class="jp-field">
                                        <label class="jp-field__label" for="parameter_id_{{ $temp->id }}">
                                            Pilih Parameter Indikator <span class="jp-label__required">*</span>
                                        </label>
                                        <select class="jp-select no-select2" id="parameter_id_{{ $temp->id }}" name="parameter_id" required>
                                            <option value="">-- Pilih Salah Satu Parameter --</option>
                                            @foreach(Modules\Formulir\Entities\Parameter::where('indikator_id', $temp->indikator_id)->orderBy('bobot', 'asc')->get() as $parameter)
                                                <option value="{{ $parameter->id }}" {{ $temp->parameter_id == $parameter->id ? 'selected' : '' }}>
                                                    {{ $parameter->label }} (Bobot: {{ $parameter->bobot }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                {!! Form::close() !!}
                            @else
                                <div class="jp-field">
                                    <label class="jp-field__label">Parameter Terpilih</label>
                                    <select class="jp-select no-select2" disabled>
                                        <option value="">-- Parameter Belum Dipilih --</option>
                                        @foreach(Modules\Formulir\Entities\Parameter::where('indikator_id', $temp->indikator_id)->orderBy('bobot', 'asc')->get() as $parameter)
                                            <option value="{{ $parameter->id }}" {{ $temp->parameter_id == $parameter->id ? 'selected' : '' }}>
                                                {{ $parameter->label }} (Bobot: {{ $parameter->bobot }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="jp-field__hint">Hanya pemohon yang dapat mengubah parameter.</p>
                                </div>
                            @endif
                        </div>

                        <div class="jp-modal__foot">
                            <a href="{{ route('indikator.data.index', [$temp->uuid]) }}" class="jp-btn jp-btn--ghost">
                                Kelola Data Dukung ({{ $fApproved }}/{{ $fTotal }})
                            </a>
                            @if(!$pendaftaranDitutup && role_me() == 4)
                                <button type="submit" form="formParameter-{{ $temp->id }}" class="jp-btn jp-btn--accent">
                                    Simpan Parameter
                                </button>
                            @else
                                <button type="button" class="jp-btn jp-btn--ghost md-close" data-close="{{ $temp->id }}">Tutup</button>
                            @endif
                        </div>
                    </dialog>
                @endforeach
            </div>
        @else
            <x-empty
                icon="clipboard"
                title="Belum ada indikator"
                desc="Daftar indikator untuk usulan ini belum tersedia. Hubungi tim verifikator bila kondisi ini bertahan."
            />
        @endif

    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.indikator-trigger').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                var modal = document.getElementById('modal-' + id);
                if (modal && typeof modal.showModal === 'function') {
                    modal.showModal();
                }
            });
        });

        document.querySelectorAll('.md-close').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.getAttribute('data-close');
                var modal = document.getElementById('modal-' + id);
                if (modal && typeof modal.close === 'function') {
                    modal.close();
                }
            });
        });
    });
</script>
@endsection
