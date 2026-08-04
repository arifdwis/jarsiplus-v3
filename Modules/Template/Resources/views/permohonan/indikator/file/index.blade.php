@extends('template::layouts.master')

@section('title', 'Data Dukung — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
@php
    $bisaUnggah = role_me() == 4 && $parent->status == 0 && !pendaftaran_inovasi_ditutup();
    $uploadDitutup = role_me() == 4 && $parent->status == 0 && pendaftaran_inovasi_ditutup();

    $berkas = $parent->files ?? collect();
    $berkasTotal = $berkas->count();
    $berkasDisetujui = $berkasTotal > 0 ? $berkas->where('status', 1)->count() : 0;
@endphp

<x-page-header
    badge="DATA DUKUNG INDIKATOR"
    :title="$parent->label_indikator"
    desc="Unggah dan kelola seluruh berkas bukti dukung indikator inovasi daerah Anda."
    :back="isset($permohonan) ? route('permohonan.indikator.index', $permohonan->uuid) : null"
    backLabel="Kembali ke Indikator"
>
    @if($bisaUnggah)
        <button type="button" class="jp-btn jp-btn--accent" onclick="document.getElementById('modalUploadFile').showModal()">
            <x-icon name="upload" size="16" />
            Tambah Data Dukung
        </button>
    @endif
</x-page-header>

<div class="jp-subhead">
    <div class="l-container jp-subhead__inner">
        <span class="jp-badge jp-badge--neutral font-mono">KODE: {{ $parent->kode }}</span>
        <span class="jp-subhead__meta">
            <x-icon name="folder" size="14" />
            {{ $berkasDisetujui }}/{{ $berkasTotal }} berkas disetujui
        </span>
    </div>
</div>

<div class="jp-section jp-section--sm">
    <div class="l-container">

        @if($uploadDitutup)
            <div class="jp-notice jp-notice--danger u-mb-lg">
                <span class="jp-notice__icon"><x-icon name="lock" size="20" /></span>
                <div class="jp-notice__body">
                    <strong class="jp-notice__title">Unggah berkas ditutup</strong>
                    <p class="jp-notice__text">{{ pendaftaran_inovasi_pesan_tutup() }}</p>
                </div>
            </div>
        @endif

        @if($berkasTotal > 0)
            <div class="l-grid l-grid--3">
                @foreach($berkas as $value)
                    @php
                        $disetujui = $value->status == 1;
                        $argsChat = "'".$parent->uuid."', '".$value->uuid."', '".e($value->label)."', '".$value->status."', '".$value->jenis."', '".e($value->url)."', '".e($value->nomor_surat)."'";
                    @endphp

                    <article class="jp-record-card {{ $disetujui ? 'jp-record-card--success' : 'jp-record-card--amber' }}">
                        <header class="jp-record-card__head">
                            <span class="u-flex u-align-center u-gap-xs" style="min-width: 0;">
                                <x-icon :name="$value->url ? 'link' : 'file'" size="16" style="color: var(--c-ink-subtle);" />
                                <span class="jp-badge {{ $disetujui ? 'jp-badge--success' : 'jp-badge--amber' }}">
                                    {{ $disetujui ? 'TERVALIDASI' : 'BELUM DISETUJUI' }}
                                </span>
                            </span>
                            <span class="font-mono" style="font-size: var(--t-2xs); color: var(--c-ink-subtle);">
                                {{ $value->created_at ? $value->created_at->format('d/m/Y') : '—' }}
                            </span>
                        </header>

                        <div class="jp-record-card__body">
                            <h3 class="jp-record-card__title jp-clamp-2">
                                <a href="javascript:;" onclick="openPembahasanModal({{ $argsChat }})">{{ $value->label }}</a>
                            </h3>

                            <div class="jp-record-card__meta">
                                <x-icon name="clipboard" size="14" style="color: var(--c-ink-subtle);" />
                                <span class="u-truncate">
                                    @if(filled($value->nomor_surat))
                                        No. Surat: {{ $value->nomor_surat }}
                                    @else
                                        <span class="jp-value-empty"></span>
                                    @endif
                                </span>
                            </div>

                            @if($value->url)
                                <a href="{{ $value->url }}" target="_blank" rel="noopener" class="jp-link-arrow" style="font-size: var(--t-xs); word-break: break-all;">
                                    <x-icon name="link" size="14" />
                                    Buka tautan berkas
                                </a>
                            @endif

                            @if(filled($value->deskripsi))
                                <p class="jp-card__text jp-clamp-2">{{ $value->deskripsi }}</p>
                            @endif
                        </div>

                        <footer class="jp-record-card__foot">
                            <button type="button" class="jp-btn jp-btn--ghost jp-btn--sm" onclick="openPembahasanModal({{ $argsChat }})">
                                <x-icon name="chat" size="14" />
                                Pembahasan
                            </button>

                            @if($bisaUnggah)
                                <span class="u-flex u-gap-2xs" style="flex: 0 0 auto;">
                                    <button type="button" class="jp-btn jp-btn--quiet jp-btn--xs" title="Edit berkas"
                                            onclick="document.getElementById('modalEditFile-{{ $value->uuid }}').showModal()">
                                        <x-icon name="edit" size="15" />
                                        <span class="u-sr-only">Edit berkas</span>
                                    </button>
                                    <button type="button" class="jp-btn jp-btn--quiet jp-btn--xs text-danger" title="Hapus berkas"
                                            onclick="confirmDeleteFile('{{ $value->uuid }}', '{{ e($value->label) }}')">
                                        <x-icon name="trash" size="15" />
                                        <span class="u-sr-only">Hapus berkas</span>
                                    </button>
                                    <form id="form-delete-{{ $value->uuid }}" action="{{ route('indikator.data.destroy', [$parent->uuid, $value->uuid]) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </span>
                            @endif
                        </footer>
                    </article>

                    {{-- Modal edit berkas --}}
                    @if($bisaUnggah)
                        <dialog id="modalEditFile-{{ $value->uuid }}" class="jp-modal">
                            <div class="jp-modal__head">
                                <div class="u-flex u-align-center u-gap-sm">
                                    <span class="jp-modal__icon"><x-icon name="edit" size="20" /></span>
                                    <h3 class="jp-modal__title">Edit Data Dukung</h3>
                                </div>
                                <button type="button" class="jp-modal__close" aria-label="Tutup" onclick="document.getElementById('modalEditFile-{{ $value->uuid }}').close()">
                                    <x-icon name="close" size="22" />
                                </button>
                            </div>

                            {!! Form::model($value, ['route' => ['indikator.data.update', $parent->uuid, $value->uuid], 'autocomplete' => 'off', 'files' => true, 'method' => 'PUT']) !!}
                                <div class="jp-modal__body">
                                    <div class="u-flex u-flex-col u-gap-md">
                                        <div class="jp-field">
                                            <label class="jp-field__label">Nama File / Label Berkas <span class="jp-label__required">*</span></label>
                                            <input type="text" name="label" class="jp-input" value="{{ old('label', $value->label) }}" required>
                                        </div>

                                        <div class="jp-field">
                                            <label class="jp-field__label">Nomor Surat / SK Dokumen <span class="jp-label__required">*</span></label>
                                            <input type="text" name="nomor_surat" class="jp-input" value="{{ old('nomor_surat', $value->nomor_surat) }}" required>
                                        </div>

                                        @if($value->url)
                                            <div class="jp-field">
                                                <label class="jp-field__label">URL / Link Web</label>
                                                <input type="text" name="url" class="jp-input" value="{{ old('url', $value->url) }}">
                                            </div>
                                        @else
                                            <div class="jp-field">
                                                <label class="jp-field__label">Ganti File Lampiran</label>
                                                <input type="file" name="file" class="jp-input jp-input--file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.mp4">
                                                <p class="jp-field__hint">Opsional, maksimal 10 MB.</p>
                                            </div>
                                        @endif

                                        <div class="jp-field">
                                            <label class="jp-field__label">Deskripsi Berkas</label>
                                            <textarea name="deskripsi" class="jp-textarea" rows="3">{{ old('deskripsi', $value->deskripsi) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="jp-modal__foot">
                                    <button type="button" class="jp-btn jp-btn--ghost" onclick="document.getElementById('modalEditFile-{{ $value->uuid }}').close()">Batal</button>
                                    <button type="submit" class="jp-btn jp-btn--accent">Simpan Perubahan</button>
                                </div>
                            {!! Form::close() !!}
                        </dialog>
                    @endif
                @endforeach
            </div>
        @else
            {{-- Belum ada berkas sama sekali --}}
            <x-empty
                icon="upload"
                title="Belum ada berkas data dukung"
                desc="Indikator ini belum memiliki bukti dukung. Unggah dokumen atau tautan resmi agar indikator dapat dinilai oleh tim verifikator."
            >
                @if($bisaUnggah)
                    <button type="button" class="jp-btn jp-btn--accent u-mt-sm" onclick="document.getElementById('modalUploadFile').showModal()">
                        <x-icon name="upload" size="16" />
                        Tambah Data Dukung
                    </button>
                @endif
            </x-empty>
        @endif

    </div>
</div>

{{-- MODAL PEMBAHASAN BERKAS --}}
<dialog id="modalPembahasanChat" class="jp-modal jp-modal--lg">
    <div class="jp-modal__head">
        <div class="u-flex u-align-center u-gap-sm" style="min-width: 0;">
            <span class="jp-modal__icon"><x-icon name="chat" size="20" /></span>
            <div style="min-width: 0;">
                <h3 id="modalChatFileLabel" class="jp-modal__title">Pembahasan Berkas</h3>
                <span class="jp-modal__eyebrow">Catatan &amp; diskusi tim pembahas</span>
            </div>
        </div>
        <button type="button" class="jp-modal__close" aria-label="Tutup" onclick="document.getElementById('modalPembahasanChat').close()">
            <x-icon name="close" size="22" />
        </button>
    </div>

    {{-- Bar persetujuan (tim pembahas) --}}
    @if(role_me() != 4)
        <div id="modalValidateBar" class="jp-modal__bar">
            <div class="u-flex u-align-center u-gap-xs u-flex-wrap">
                <strong style="font-size: var(--t-xs); color: var(--c-ink);">Status data dukung:</strong>
                <span id="modalFileStatusBadge" class="jp-badge jp-badge--amber">BELUM DISETUJUI</span>
            </div>
            <form id="formModalValidate" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" name="validate" id="modalInputValidate" value="1">
                <button type="submit" id="btnModalValidate" class="jp-btn jp-btn--accent jp-btn--sm">
                    Setujui Data Dukung
                </button>
            </form>
        </div>
    @endif

    {{-- Bar pembaruan (pemohon, saat berkas belum disetujui) --}}
    @if(role_me() == 4)
        <div id="modalPemohonUpdateBar" class="jp-modal__bar jp-modal__bar--amber" style="display: none;">
            <form id="formModalPemohonUpdate" method="POST" action="" enctype="multipart/form-data" style="width: 100%;">
                @csrf
                @method('PUT')
                <input type="hidden" name="label" id="pemohonInputLabel">
                <input type="hidden" name="nomor_surat" id="pemohonInputNomor">

                <div class="u-flex u-justify-between u-align-center u-flex-wrap u-gap-xs u-mb-xs">
                    <strong class="u-flex u-align-center u-gap-xs" style="font-size: var(--t-xs); color: var(--c-amber);">
                        <x-icon name="upload" size="15" />
                        Unggah pembaruan berkas / tautan perbaikan
                    </strong>
                    <span class="jp-badge jp-badge--amber">PERBAIKAN DIBUTUHKAN</span>
                </div>

                <div class="jp-searchbar">
                    <div id="fieldUpdateFile" style="flex: 1 1 240px; display: none;">
                        <input type="file" name="file" class="jp-input jp-input--file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.mp4">
                    </div>
                    <div id="fieldUpdateUrl" style="flex: 1 1 240px; display: none;">
                        <input type="text" name="url" id="inputUpdateUrl" class="jp-input jp-input--sm" placeholder="Masukkan URL pembaruan (https://…)">
                    </div>
                    <button type="submit" class="jp-btn jp-btn--accent jp-btn--sm">Kirim Pembaruan</button>
                </div>
            </form>
        </div>
    @endif

    <div id="modalChatFeed" class="jp-chat-feed">
        <p class="u-text-center jp-field__hint u-p-lg">Memuat percakapan…</p>
    </div>

    <form id="formModalChat" method="POST" action="" class="jp-chat-compose">
        @csrf
        <div class="jp-searchbar">
            <label for="inputModalChat" class="u-sr-only">Tulis komentar</label>
            <input type="text" name="komentar" id="inputModalChat" class="jp-input" required placeholder="Tulis komentar atau penjelasan berkas…">
            <button type="submit" class="jp-btn jp-btn--accent">Kirim</button>
        </div>
    </form>
</dialog>

{{-- MODAL UPLOAD BERKAS BARU --}}
@if($bisaUnggah)
    <dialog id="modalUploadFile" class="jp-modal">
        <div class="jp-modal__head">
            <div class="u-flex u-align-center u-gap-sm">
                <span class="jp-modal__icon"><x-icon name="upload" size="20" /></span>
                <h3 class="jp-modal__title">Tambah Data Dukung Baru</h3>
            </div>
            <button type="button" class="jp-modal__close" aria-label="Tutup" onclick="document.getElementById('modalUploadFile').close()">
                <x-icon name="close" size="22" />
            </button>
        </div>

        {!! Form::open(['route' => ['indikator.data.store', $parent->uuid], 'autocomplete' => 'off', 'files' => true]) !!}
            <div class="jp-modal__body">
                <div class="jp-form-grid u-mb-md">
                    <div class="jp-field">
                        <label class="jp-field__label">Nama File / Label <span class="jp-label__required">*</span></label>
                        <input type="text" name="label" class="jp-input" required placeholder="Deskripsikan berkas…">
                    </div>
                    <div class="jp-field">
                        <label class="jp-field__label">Nomor Surat / SK <span class="jp-label__required">*</span></label>
                        <input type="text" name="nomor_surat" class="jp-input" required placeholder="Nomor surat atau SK…">
                    </div>
                </div>

                <div class="jp-field u-mb-md">
                    <label class="jp-field__label" for="modal_jenis">Jenis Berkas / Sumber Data <span class="jp-label__required">*</span></label>
                    <select class="jp-input" name="jenis" id="modal_jenis" required>
                        <option value="">-- Pilih Jenis Berkas / Sumber Data --</option>
                        <option value="url" selected>URL / Link Web (https://…)</option>
                        @foreach(permohonan_files() as $key => $value)
                            <option value="{{$key}}">{{Str::title($value)}} (File Upload)</option>
                        @endforeach
                    </select>
                </div>

                <div class="jp-field u-mb-md" id="modal_field_url">
                    <label class="jp-field__label">URL / Tautan Dokumen <span class="jp-label__required">*</span></label>
                    <input type="text" name="url" class="jp-input" placeholder="https://samarindakota.go.id/dokumen.pdf">
                </div>

                <div class="jp-field u-mb-md" id="modal_field_file" style="display: none;">
                    <label class="jp-field__label" for="modal_file_input">Upload File Lampiran <span class="jp-label__required">*</span></label>
                    <input type="file" name="file" id="modal_file_input" class="jp-input jp-input--file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.mp4">
                    <p class="jp-field__hint">PDF, DOCX, PNG, JPG, atau MP4. Maksimal 10 MB.</p>
                </div>

                <div class="jp-field">
                    <label class="jp-field__label">Deskripsi &amp; Penjelasan Berkas</label>
                    <textarea name="deskripsi" class="jp-textarea" rows="3" placeholder="Jelaskan ringkas isi berkas…"></textarea>
                </div>
            </div>

            <div class="jp-modal__foot">
                <button type="button" class="jp-btn jp-btn--ghost" onclick="document.getElementById('modalUploadFile').close()">Batal</button>
                <button type="submit" class="jp-btn jp-btn--accent">Simpan &amp; Unggah Berkas</button>
            </div>
        {!! Form::close() !!}
    </dialog>
@endif
@endsection

@section('js')
<script>
    function confirmDeleteFile(uuid, label) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Berkas Data Dukung?',
                text: `Apakah Anda yakin ingin menghapus berkas "${label}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C42323',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + uuid).submit();
                }
            });
        } else if (confirm(`Hapus berkas "${label}"?`)) {
            document.getElementById('form-delete-' + uuid).submit();
        }
    }

    function openPembahasanModal(parentUuid, fileUuid, fileLabel, fileStatus, fileJenis, fileUrl, fileNomor) {
        var modal = document.getElementById('modalPembahasanChat');
        var titleEl = document.getElementById('modalChatFileLabel');
        var feedEl = document.getElementById('modalChatFeed');
        var formEl = document.getElementById('formModalChat');
        var inputEl = document.getElementById('inputModalChat');

        var validateForm = document.getElementById('formModalValidate');
        var validateBadge = document.getElementById('modalFileStatusBadge');
        var validateBtn = document.getElementById('btnModalValidate');
        var validateInput = document.getElementById('modalInputValidate');

        var pemohonBar = document.getElementById('modalPemohonUpdateBar');
        var pemohonForm = document.getElementById('formModalPemohonUpdate');
        var pemohonLabel = document.getElementById('pemohonInputLabel');
        var pemohonNomor = document.getElementById('pemohonInputNomor');
        var fieldFile = document.getElementById('fieldUpdateFile');
        var fieldUrl = document.getElementById('fieldUpdateUrl');
        var inputUrl = document.getElementById('inputUpdateUrl');

        if (titleEl) titleEl.textContent = fileLabel || 'Pembahasan Berkas';
        if (formEl) formEl.action = `/indikator/${parentUuid}/data/${fileUuid}/pembahasan`;
        if (inputEl) inputEl.value = '';

        if (validateForm) {
            validateForm.action = `/indikator/${parentUuid}/data/${fileUuid}/validate`;
            if (fileStatus == 1) {
                if (validateBadge) {
                    validateBadge.className = 'jp-badge jp-badge--success';
                    validateBadge.textContent = 'DISETUJUI';
                }
                if (validateBtn) {
                    validateBtn.className = 'jp-btn jp-btn--ghost jp-btn--sm text-danger';
                    validateBtn.textContent = 'Batalkan Persetujuan';
                }
                if (validateInput) validateInput.value = '0';
            } else {
                if (validateBadge) {
                    validateBadge.className = 'jp-badge jp-badge--amber';
                    validateBadge.textContent = 'BELUM DISETUJUI';
                }
                if (validateBtn) {
                    validateBtn.className = 'jp-btn jp-btn--accent jp-btn--sm';
                    validateBtn.textContent = 'Setujui Data Dukung';
                }
                if (validateInput) validateInput.value = '1';
            }
        }

        if (pemohonBar && pemohonForm) {
            if (fileStatus == 0) {
                pemohonBar.style.display = 'block';
                pemohonForm.action = `/indikator/${parentUuid}/data/${fileUuid}`;
                if (pemohonLabel) pemohonLabel.value = fileLabel || '';
                if (pemohonNomor) pemohonNomor.value = fileNomor || '1';

                if (fileJenis === 'url') {
                    if (fieldUrl) fieldUrl.style.display = 'block';
                    if (fieldFile) fieldFile.style.display = 'none';
                    if (inputUrl) inputUrl.value = fileUrl || '';
                } else {
                    if (fieldUrl) fieldUrl.style.display = 'none';
                    if (fieldFile) fieldFile.style.display = 'block';
                }
            } else {
                pemohonBar.style.display = 'none';
            }
        }

        if (feedEl) {
            feedEl.innerHTML = '<p class="u-text-center jp-field__hint u-p-lg">Memuat percakapan…</p>';

            fetch(`/indikator/${parentUuid}/data/${fileUuid}/pembahasan`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                feedEl.innerHTML = html;
                feedEl.scrollTop = feedEl.scrollHeight;
            })
            .catch(err => {
                feedEl.innerHTML = '<p class="u-text-center text-danger u-p-lg" style="font-size: var(--t-sm);">Gagal memuat percakapan.</p>';
            });
        }

        if (modal && typeof modal.showModal === 'function') {
            modal.showModal();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var formModalChat = document.getElementById('formModalChat');
        if (formModalChat) {
            formModalChat.addEventListener('submit', function(e) {
                e.preventDefault();
                var actionUrl = formModalChat.action;
                var inputEl = document.getElementById('inputModalChat');
                var feedEl = document.getElementById('modalChatFeed');
                var komentarVal = inputEl.value.trim();

                if (!komentarVal || !actionUrl) return;

                var formData = new FormData(formModalChat);

                fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    inputEl.value = '';
                    if (feedEl) {
                        feedEl.innerHTML = html;
                        feedEl.scrollTop = feedEl.scrollHeight;
                    }
                })
                .catch(err => {
                    alert('Gagal mengirim pesan chat.');
                });
            });
        }

        var jenisSelect = document.getElementById('modal_jenis');
        var fieldUrl = document.getElementById('modal_field_url');
        var fieldFile = document.getElementById('modal_field_file');
        var fileInput = document.getElementById('modal_file_input');

        if (jenisSelect) {
            function toggleJenisFields() {
                if (jenisSelect.value === 'url') {
                    if (fieldUrl) fieldUrl.style.display = 'block';
                    if (fieldFile) fieldFile.style.display = 'none';
                    if (fileInput) fileInput.required = false;
                } else if (jenisSelect.value !== '') {
                    if (fieldUrl) fieldUrl.style.display = 'none';
                    if (fieldFile) fieldFile.style.display = 'block';
                    if (fileInput) fileInput.required = true;
                }
            }
            jenisSelect.addEventListener('change', toggleJenisFields);
            toggleJenisFields();
        }
    });
</script>
@endsection
