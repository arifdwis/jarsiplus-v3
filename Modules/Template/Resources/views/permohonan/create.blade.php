@extends('template::layouts.master')

@section('title', 'Formulir Pengajuan Inovasi — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
<x-page-header
    badge="PENGAJUAN BARU"
    title="Formulir Inovasi Daerah"
    desc="Perwali Kota Samarinda No. 22 Tahun 2020. Isi formulir bertahap dalam tiga segment; data tersimpan saat Anda mengirim di akhir."
    :back="route('permohonan.index')"
    backLabel="Batal & kembali ke daftar"
/>

<div class="jp-section jp-section--sm">
    <div class="l-container">

        @if ($errors->any())
            <div class="jp-notice jp-notice--danger u-mb-lg">
                <span class="jp-notice__icon"><x-icon name="alert-circle" size="20" /></span>
                <div class="jp-notice__body">
                    <strong class="jp-notice__title">Pengisian belum dapat diproses</strong>
                    <ul class="jp-notice__list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Indikator langkah --}}
        <div class="u-mb-lg">
            <div class="jp-steps" id="step-cards-header">
                <button type="button" class="jp-step is-active" id="step-card-1" onclick="switchStepDirect(1)">
                    <span class="jp-badge jp-badge--accent jp-step__badge" id="step-badge-1">STEP 01</span>
                    <span class="jp-step__title">Segment 1</span>
                    <span class="jp-step__desc">Data Umum Inovasi Daerah</span>
                </button>

                <button type="button" class="jp-step" id="step-card-2" onclick="switchStepDirect(2)">
                    <span class="jp-badge jp-badge--neutral jp-step__badge" id="step-badge-2">STEP 02</span>
                    <span class="jp-step__title">Segment 2</span>
                    <span class="jp-step__desc">Data Inovator &amp; Pengusul</span>
                </button>

                <button type="button" class="jp-step" id="step-card-3" onclick="switchStepDirect(3)">
                    <span class="jp-badge jp-badge--neutral jp-step__badge" id="step-badge-3">STEP 03</span>
                    <span class="jp-step__title">Segment 3</span>
                    <span class="jp-step__desc">Rancang Bangun &amp; Proposal</span>
                </button>
            </div>

            <div class="jp-meter u-mt-sm">
                <div class="jp-meter__fill" id="step-progress-bar" style="width: 33.33%;"></div>
            </div>
        </div>

        <form action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data" id="formPermohonan">
            @csrf

            {{-- ============ STEP 1 — Data Umum Inovasi Daerah ============ --}}
            <div class="step-panel" id="step-1-panel">
                <div class="jp-card">
                    <header class="jp-card-head">
                        <div class="u-flex u-align-center u-gap-sm u-flex-wrap">
                            <span class="jp-badge jp-badge--accent">SEGMENT 1 &middot; 1/3</span>
                            <h3 class="u-mb-0">Data Umum Inovasi Daerah</h3>
                        </div>
                        <span class="font-mono jp-card-head__note">Klasifikasi &amp; identitas usulan</span>
                    </header>

                    <div class="jp-form-grid u-mb-md">
                        <div class="jp-field">
                            <label class="jp-field__label" for="field_nama_instansi">
                                Nama Instansi / Perangkat Daerah <span class="jp-label__required">*</span>
                            </label>
                            <input type="text" name="nama_instansi" id="field_nama_instansi" class="jp-input" value="{{ old('nama_instansi', optional(me()->corporate)->name ?? optional(me()->pemohon)->unit_kerja) }}" required placeholder="Contoh: Dinas Pariwisata Kota Samarinda">
                        </div>

                        <div class="jp-field">
                            <label class="jp-field__label" for="field_id_kota">
                                Kabupaten / Kota <span class="jp-label__required">*</span>
                            </label>
                            <select name="id_kota" id="field_id_kota" class="jp-input select2" required>
                                <option value="">-- Pilih Salah Satu Kabupaten / Kota --</option>
                                @foreach($provinsis as $prov)
                                    <optgroup label="{{ $prov->name }}">
                                        @foreach($prov->citys as $child)
                                            <option value="{{ $child->id }}" {{ (old('id_kota', optional(me()->corporate)->kota_id) == $child->id || $child->name == 'KOTA SAMARINDA') ? 'selected' : '' }}>
                                                {{ $child->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="jp-field u-mb-md">
                        <label class="jp-field__label" for="field_label">
                            Judul Inovasi Daerah <span class="jp-label__required">*</span>
                        </label>
                        <input type="text" name="label" id="field_label" class="jp-input" value="{{ old('label') }}" required placeholder="Contoh: Aplikasi Satu Data Satu Inovasi">
                    </div>

                    <div class="jp-form-grid u-mb-md">
                        <div class="jp-field">
                            <label class="jp-field__label" for="field_id_kategori">
                                Kategori Urusan / Bidang Inovasi <span class="jp-label__required">*</span>
                            </label>
                            <select name="id_kategori" id="field_id_kategori" class="jp-input select2" required>
                                <option value="">-- Pilih Kategori Urusan --</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('id_kategori') == $k->id ? 'selected' : '' }}>{{ $k->label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="jp-field">
                            <label class="jp-field__label" for="field_urusan_utama">
                                Urusan Pemerintahan (Utama) <span class="jp-label__required">*</span>
                            </label>
                            <select name="urusan_utama" id="field_urusan_utama" class="jp-input select2" required>
                                <option value="">-- Pilih Urusan Pemerintahan --</option>
                                @foreach($urusans as $u)
                                    <option value="{{ $u->label }}" {{ old('urusan_utama') == $u->label ? 'selected' : '' }}>{{ $u->label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="jp-field">
                            <label class="jp-field__label" for="field_urusan_lainnya">
                                Urusan Lainnya Yang Berkaitan <span class="jp-label__required">*</span>
                            </label>
                            <select name="urusan_lainnya" id="field_urusan_lainnya" class="jp-input select2" required>
                                <option value="">-- Pilih Urusan Lainnya --</option>
                                @foreach($urusans as $u)
                                    <option value="{{ $u->label }}" {{ old('urusan_lainnya') == $u->label ? 'selected' : '' }}>{{ $u->label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="jp-field">
                            <label class="jp-field__label" for="field_tahapan">
                                Tahapan Inovasi <span class="jp-label__required">*</span>
                            </label>
                            <select name="tahapan" id="field_tahapan" class="jp-input select2" required>
                                <option value="">-- Pilih Tahapan Inovasi --</option>
                                <option value="1" {{ old('tahapan') == '1' ? 'selected' : '' }}>Inisiatif</option>
                                <option value="2" {{ old('tahapan') == '2' ? 'selected' : '' }}>Uji Coba</option>
                                <option value="3" {{ old('tahapan', '3') == '3' ? 'selected' : '' }}>Penerapan</option>
                            </select>
                        </div>

                        <div class="jp-field">
                            <label class="jp-field__label" for="field_inisiator">
                                Inisiator Inovasi Daerah <span class="jp-label__required">*</span>
                            </label>
                            <select name="inisiator" id="field_inisiator" class="jp-input select2" required>
                                <option value="">-- Pilih Inisiator Inovasi --</option>
                                <option value="1" {{ old('inisiator') == '1' ? 'selected' : '' }}>Kepala Daerah</option>
                                <option value="2" {{ old('inisiator') == '2' ? 'selected' : '' }}>Anggota DPRD</option>
                                <option value="3" {{ old('inisiator', '3') == '3' ? 'selected' : '' }}>OPD (Organisasi Perangkat Daerah)</option>
                                <option value="4" {{ old('inisiator') == '4' ? 'selected' : '' }}>ASN</option>
                                <option value="5" {{ old('inisiator') == '5' ? 'selected' : '' }}>Masyarakat</option>
                            </select>
                        </div>

                        <div class="jp-field">
                            <label class="jp-field__label" for="field_jenis">
                                Jenis Inovasi Daerah <span class="jp-label__required">*</span>
                            </label>
                            <select name="jenis" id="field_jenis" class="jp-input select2" required>
                                <option value="">-- Pilih Jenis Inovasi --</option>
                                <option value="1" {{ old('jenis', '1') == '1' ? 'selected' : '' }}>Digital</option>
                                <option value="2" {{ old('jenis') == '2' ? 'selected' : '' }}>Non Digital</option>
                            </select>
                        </div>
                    </div>

                    <label class="jp-consent">
                        <input type="checkbox" id="check-form-1" required>
                        <span>Dengan menggunakan layanan kami, Anda memercayakan informasi kepada Pemerintah Kota Samarinda untuk perlindungan dan pengelolaan data pengajuan sesuai ketentuan hukum yang berlaku.</span>
                    </label>

                    <div class="jp-form-foot">
                        <a href="{{ route('permohonan.index') }}" class="jp-btn jp-btn--ghost">Batal</a>
                        <button type="button" class="jp-btn jp-btn--accent" onclick="nextStep(2)">
                            Lanjut ke Segment 2 <span aria-hidden="true">&rarr;</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ============ STEP 2 — Biodata Inovator ============ --}}
            <div class="step-panel" id="step-2-panel" style="display: none;">
                <div class="jp-card">
                    <header class="jp-card-head">
                        <div class="u-flex u-align-center u-gap-sm u-flex-wrap">
                            <span class="jp-badge jp-badge--accent">SEGMENT 2 &middot; 2/3</span>
                            <h3 class="u-mb-0">Biodata Inovator Utama</h3>
                        </div>
                        <span class="font-mono jp-card-head__note">Identitas pemohon dari SSO</span>
                    </header>

                    <p class="jp-field__hint u-mb-md">
                        Data di bawah diambil otomatis dari profil SSO Anda dan tidak dapat diubah di formulir ini.
                        Perbarui melalui <a href="{{ route('settings.profile.index') }}">Pengaturan Profil</a> bila ada yang keliru.
                    </p>

                    @php
                        $biodata = [
                            'NIK Pemohon'              => optional(me()->pemohon)->nik,
                            'Nama Lengkap Inovator'    => optional(me()->pemohon)->name ?? me()->name,
                            'NIP / Nomor Kepegawaian'  => optional(me()->pemohon)->nip,
                            'Telp. Pribadi / WhatsApp' => optional(me()->pemohon)->phone,
                            'Email Pribadi / Resmi'    => optional(me()->pemohon)->email ?? me()->email,
                            'Unit Kerja'               => optional(me()->pemohon)->unit_kerja,
                            'Jabatan'                  => optional(me()->pemohon)->jabatan,
                        ];
                    @endphp

                    <div class="jp-deflist jp-deflist--2 u-mb-md">
                        @foreach($biodata as $label => $value)
                            <div class="jp-deflist__row">
                                <span class="jp-deflist__label">{{ $label }}</span>
                                <span class="jp-deflist__value">
                                    @if(filled($value)){{ $value }}@else<span class="jp-value-empty"></span>@endif
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <label class="jp-consent">
                        <input type="checkbox" id="check-form-2" required>
                        <span>Dengan menggunakan layanan JARSIPLUS, Anda memercayakan informasi kepada Pemerintah Kota Samarinda untuk perlindungan dan pengelolaan data pengajuan sesuai ketentuan hukum yang berlaku.</span>
                    </label>

                    <div class="jp-form-foot">
                        <button type="button" class="jp-btn jp-btn--ghost" onclick="prevStep(1)">
                            <span aria-hidden="true">&larr;</span> Kembali ke Segment 1
                        </button>
                        <button type="button" class="jp-btn jp-btn--accent" onclick="nextStep(3)">
                            Lanjut ke Segment 3 <span aria-hidden="true">&rarr;</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ============ STEP 3 — Rancang Bangun & Lampiran ============ --}}
            <div class="step-panel" id="step-3-panel" style="display: none;">
                <div class="jp-card">
                    <header class="jp-card-head">
                        <div class="u-flex u-align-center u-gap-sm u-flex-wrap">
                            <span class="jp-badge jp-badge--accent">SEGMENT 3 &middot; 3/3</span>
                            <h3 class="u-mb-0">Rancang Bangun, Proposal &amp; Lampiran</h3>
                        </div>
                        <span class="font-mono jp-card-head__note">Perwali No. 22/2020</span>
                    </header>

                    <div class="jp-field u-mb-md">
                        <label class="jp-field__label" for="field_rancang_bangun">
                            Rancang Bangun Inovasi <span class="jp-label__required">*</span>
                        </label>
                        <textarea name="rancang_bangun" id="field_rancang_bangun" class="jp-textarea" rows="5" required placeholder="Latar belakang, pokok perubahan, dan kebaruan inovasi…">{{ old('rancang_bangun') }}</textarea>
                        <p class="jp-field__hint">Maksimal sekitar 300 kata.</p>
                    </div>

                    <div class="jp-field u-mb-md">
                        <label class="jp-field__label" for="field_tujuan_inovasi">
                            Tujuan Inovasi Daerah <span class="jp-label__required">*</span>
                        </label>
                        <textarea name="tujuan_inovasi" id="field_tujuan_inovasi" class="jp-textarea" rows="4" required placeholder="Tujuan yang ingin dicapai dari inovasi ini…">{{ old('tujuan_inovasi') }}</textarea>
                        <p class="jp-field__hint">Maksimal sekitar 500 kata.</p>
                    </div>

                    <div class="jp-field u-mb-md">
                        <label class="jp-field__label" for="field_manfaat_inovasi">
                            Manfaat Inovasi <span class="jp-label__required">*</span>
                        </label>
                        <textarea name="manfaat_inovasi" id="field_manfaat_inovasi" class="jp-textarea" rows="4" required placeholder="Manfaat yang dirasakan masyarakat atau organisasi…">{{ old('manfaat_inovasi') }}</textarea>
                        <p class="jp-field__hint">Maksimal sekitar 500 kata.</p>
                    </div>

                    <div class="jp-field u-mb-md">
                        <label class="jp-field__label" for="field_hasil_inovasi">
                            Hasil Inovasi <span class="jp-label__required">*</span>
                        </label>
                        <textarea name="hasil_inovasi" id="field_hasil_inovasi" class="jp-textarea" rows="4" required placeholder="Hasil dan dampak terukur yang sudah dicapai…">{{ old('hasil_inovasi') }}</textarea>
                        <p class="jp-field__hint">Maksimal sekitar 500 kata.</p>
                    </div>

                    <div class="jp-form-grid u-mb-md">
                        <div class="jp-field">
                            <label class="jp-field__label" for="field_waktu_uji_coba">
                                Waktu Uji Coba Inovasi <span class="jp-label__required">*</span>
                            </label>
                            <input type="date" name="waktu_uji_coba" id="field_waktu_uji_coba" class="jp-input" value="{{ old('waktu_uji_coba') }}" required>
                        </div>

                        <div class="jp-field">
                            <label class="jp-field__label" for="field_waktu_pelaksanaan">
                                Waktu Pelaksanaan Inovasi <span class="jp-label__required">*</span>
                            </label>
                            <input type="date" name="waktu_pelaksanaan" id="field_waktu_pelaksanaan" class="jp-input" value="{{ old('waktu_pelaksanaan') }}" required>
                        </div>

                        <div class="jp-field">
                            <label class="jp-field__label" for="field_anggaran">File Anggaran</label>
                            <input type="file" name="anggaran" id="field_anggaran" class="jp-input jp-input--file" accept=".pdf,.doc,.docx">
                            <p class="jp-field__hint">PDF atau Word, maksimal 10 MB. Opsional.</p>
                        </div>

                        <div class="jp-field">
                            <label class="jp-field__label" for="field_profil_bisnis">Proposal Inovasi / Profil Bisnis</label>
                            <input type="file" name="profil_bisnis" id="field_profil_bisnis" class="jp-input jp-input--file" accept=".pdf,.doc,.docx,.jpg,.png">
                            <p class="jp-field__hint">PDF, Word, atau gambar, maksimal 10 MB. Opsional.</p>
                        </div>
                    </div>

                    <div class="jp-notice jp-notice--amber">
                        <span class="jp-notice__icon"><x-icon name="shield" size="20" /></span>
                        <div class="jp-notice__body">
                            <strong class="jp-notice__title">Pernyataan integritas</strong>
                            <ol type="a" class="jp-notice__list">
                                <li>Menyampaikan informasi dan data diri yang benar.</li>
                                <li>Menggunakan layanan yang tersedia dengan penuh tanggung jawab sesuai kewenangan yang diberikan.</li>
                                <li>Menaati kebijakan yang berlaku di Pemerintah Kota Samarinda.</li>
                            </ol>
                            <label class="jp-consent jp-consent--bare u-mt-sm">
                                <input type="checkbox" id="check-form-3" required>
                                <span><strong>Saya menyetujui seluruh pernyataan di atas.</strong></span>
                            </label>
                        </div>
                    </div>

                    <div class="jp-form-foot">
                        <button type="button" class="jp-btn jp-btn--ghost" onclick="prevStep(2)">
                            <span aria-hidden="true">&larr;</span> Kembali ke Segment 2
                        </button>
                        <button type="submit" class="jp-btn jp-btn--accent jp-btn--lg">
                            <x-icon name="check" size="18" />
                            Kirim Pengajuan Inovasi
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('js')
<script>
let currentStep = 1;

function validateStep(stepNum) {
    if (stepNum === 1) {
        const requiredIds = ['field_nama_instansi', 'field_id_kota', 'field_label', 'field_id_kategori', 'field_urusan_utama', 'field_urusan_lainnya', 'field_tahapan', 'field_inisiator', 'field_jenis'];
        for (let id of requiredIds) {
            const el = document.getElementById(id);
            if (el && !el.value.toString().trim()) {
                el.focus();
                alert('Harap lengkapi semua isian bertanda bintang (*) pada Segment 1 terlebih dahulu!');
                return false;
            }
        }
        const check1 = document.getElementById('check-form-1');
        if (check1 && !check1.checked) {
            check1.focus();
            alert('Harap centang persetujuan pengelolaan data pada Segment 1 terlebih dahulu!');
            return false;
        }
    } else if (stepNum === 2) {
        const check2 = document.getElementById('check-form-2');
        if (check2 && !check2.checked) {
            check2.focus();
            alert('Harap centang persetujuan data pada Segment 2 terlebih dahulu!');
            return false;
        }
    }
    return true;
}

function updateStepUI(stepNum) {
    currentStep = stepNum;

    document.querySelectorAll('.step-panel').forEach(panel => panel.style.display = 'none');
    const activePanel = document.getElementById(`step-${stepNum}-panel`);
    if (activePanel) activePanel.style.display = 'block';

    for (let i = 1; i <= 3; i++) {
        const card = document.getElementById(`step-card-${i}`);
        const badge = document.getElementById(`step-badge-${i}`);
        if (!card || !badge) continue;

        card.classList.remove('is-active', 'is-done');

        if (i === stepNum) {
            card.classList.add('is-active');
            badge.className = 'jp-badge jp-badge--accent jp-step__badge';
        } else if (i < stepNum) {
            card.classList.add('is-done');
            badge.className = 'jp-badge jp-badge--success jp-step__badge';
        } else {
            badge.className = 'jp-badge jp-badge--neutral jp-step__badge';
        }
    }

    const progressMap = { 1: '33.33%', 2: '66.66%', 3: '100%' };
    document.getElementById('step-progress-bar').style.width = progressMap[stepNum];

    window.scrollTo({ top: 120, behavior: 'smooth' });
}

function nextStep(targetStep) {
    if (validateStep(currentStep)) {
        updateStepUI(targetStep);
    }
}

function prevStep(targetStep) {
    updateStepUI(targetStep);
}

function switchStepDirect(targetStep) {
    if (targetStep > currentStep) {
        if (!validateStep(currentStep)) return;
    }
    updateStepUI(targetStep);
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formPermohonan');
    if (form) {
        form.addEventListener('submit', (e) => {
            if (!validateStep(1) || !validateStep(2)) {
                e.preventDefault();
                return false;
            }

            const fieldRb = document.getElementById('field_rancang_bangun');
            const fieldTj = document.getElementById('field_tujuan_inovasi');
            const fieldMf = document.getElementById('field_manfaat_inovasi');
            const fieldHs = document.getElementById('field_hasil_inovasi');
            const fieldWp = document.getElementById('field_waktu_pelaksanaan');
            const check3 = document.getElementById('check-form-3');

            if (!fieldRb.value.trim() || !fieldTj.value.trim() || !fieldMf.value.trim() || !fieldHs.value.trim() || !fieldWp.value.trim()) {
                e.preventDefault();
                alert('Harap isi lengkap Rancang Bangun, Tujuan, Manfaat, Hasil, dan Waktu Pelaksanaan Inovasi pada Segment 3!');
                return false;
            }

            if (!check3.checked) {
                e.preventDefault();
                alert('Harap centang persetujuan pernyataan integritas pada Segment 3 sebelum mengirim data!');
                return false;
            }

            const submitBtn = form.querySelector('button[type="submit"]');
            if (form.getAttribute('data-submitting') === 'true') {
                e.preventDefault();
                return false;
            }
            form.setAttribute('data-submitting', 'true');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Mengirim pengajuan…';
            }
        });
    }
});
</script>
@endsection
