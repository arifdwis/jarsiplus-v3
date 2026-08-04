{{-- Dashboard Pemohon / Inovator --}}
@php
    $pemohon = me()->pemohon;
    $isBiodataComplete = $pemohon &&
        trim((string) $pemohon->name) !== '' &&
        trim((string) $pemohon->nik) !== '' &&
        trim((string) $pemohon->nip) !== '' &&
        trim((string) $pemohon->phone) !== '' &&
        trim((string) $pemohon->email) !== '' &&
        trim((string) $pemohon->unit_kerja) !== '' &&
        trim((string) $pemohon->jabatan) !== '';

    $pemohonId = $pemohon ? $pemohon->id : null;

    // Satu query, dipakai untuk ringkasan angka sekaligus daftar terbaru.
    $allPermohonan = (class_exists('\Modules\Formulir\Entities\Permohonan'))
        ? \Modules\Formulir\Entities\Permohonan::where(function($q) use ($pemohonId) {
            $q->where('id_pemohon_0', me()->id);
            if ($pemohonId) {
                $q->orWhere('id_pemohon_1', $pemohonId);
            }
        })->latest()->get()
        : collect();

    $myPermohonan = $allPermohonan->take(5);

    $countTotal      = $allPermohonan->count();
    $countValidasi   = $allPermohonan->where('status', 0)->count();
    $countPembahasan = $allPermohonan->whereIn('status', [1, 2])->count();
    $countSelesai    = $allPermohonan->where('status', 4)->count();
@endphp

@if($isBiodataComplete)
    {{-- Ringkasan angka: memberi konteks langsung begitu halaman dibuka --}}
    <div class="l-grid l-grid--4 u-mb-lg">
        <x-stat-tile label="Total Usulan"       :value="$countTotal"      icon="folder"       accent="var(--c-accent)" />
        <x-stat-tile label="Menunggu Validasi"  :value="$countValidasi"   icon="clock"        accent="var(--c-amber)" />
        <x-stat-tile label="Dalam Pembahasan"   :value="$countPembahasan" icon="chat"         accent="var(--c-sky)" />
        <x-stat-tile label="Selesai / Evaluasi" :value="$countSelesai"    icon="check-circle" accent="var(--c-success)" />
    </div>

    {{-- Lacak progres: satu baris ringkas, bukan blok besar --}}
    <form action="{{ route('permohonan.index') }}" method="GET" class="jp-inline-panel u-mb-xl">
        <div class="jp-inline-panel__label">
            <x-icon name="search" size="18" style="color: var(--c-accent);" />
            <div>
                <label for="lacakKodePemohon" class="jp-label">Lacak progres permohonan</label>
                <p class="jp-field__hint">Masukkan kode pengajuan untuk memantau status validasi.</p>
            </div>
        </div>

        <div class="jp-searchbar jp-inline-panel__control">
            <input type="text" id="lacakKodePemohon" name="kode" class="jp-input" placeholder="Contoh: 4769fe91">
            <button type="submit" class="jp-btn jp-btn--accent">Cari Kode</button>
        </div>
    </form>

    {{-- Menu utama --}}
    <div class="u-mb-xl">
        <div class="jp-section__head u-mb-lg">
            <h2 class="jp-section__title">Menu Utama Pemohon</h2>
            <p class="jp-section__desc">Akses cepat ke pengusulan inovasi baru, kelola berkas, profil pengguna, dan bantuan teknis.</p>
        </div>

        <div class="l-grid l-grid--4">
            <a href="{{ route('permohonan.create') }}" class="jp-action-card jp-action-card--accent">
                <div>
                    <span class="jp-action-card__icon-box"><x-icon name="document" size="22" /></span>
                    <h3 class="jp-action-card__title">Pengajuan Inovasi</h3>
                    <p class="jp-action-card__desc">Ajukan usulan inovasi daerah baru melalui formulir Segment 1–3.</p>
                </div>
                <span class="jp-action-card__link">Buat Usulan Baru <span aria-hidden="true">&rarr;</span></span>
            </a>

            <a href="{{ route('permohonan.index') }}" class="jp-action-card jp-action-card--teal">
                <div>
                    <span class="jp-action-card__icon-box jp-action-card__icon-box--teal"><x-icon name="folder" size="22" /></span>
                    <h3 class="jp-action-card__title">Permohonan Saya</h3>
                    <p class="jp-action-card__desc">Kelola usulan yang telah diajukan &amp; lengkapi berkas indikator.</p>
                </div>
                <span class="jp-action-card__link">Buka Permohonan <span aria-hidden="true">&rarr;</span></span>
            </a>

            <a href="{{ route('settings.profile.index') }}" class="jp-action-card jp-action-card--success">
                <div>
                    <span class="jp-action-card__icon-box jp-action-card__icon-box--success"><x-icon name="user" size="22" /></span>
                    <h3 class="jp-action-card__title">Kelola Profil</h3>
                    <p class="jp-action-card__desc">Perbarui NIK, NIP, kontak WhatsApp, email, unit kerja, dan jabatan.</p>
                </div>
                <span class="jp-action-card__link">Edit Profil <span aria-hidden="true">&rarr;</span></span>
            </a>

            <a href="{{ url('/faq') }}" class="jp-action-card jp-action-card--amber">
                <div>
                    <span class="jp-action-card__icon-box jp-action-card__icon-box--amber"><x-icon name="info" size="22" /></span>
                    <h3 class="jp-action-card__title">FAQ &amp; Panduan</h3>
                    <p class="jp-action-card__desc">Petunjuk pengisian indikator &amp; syarat unggah bukti dukung.</p>
                </div>
                <span class="jp-action-card__link">Buka FAQ <span aria-hidden="true">&rarr;</span></span>
            </a>
        </div>
    </div>

    {{-- Permohonan terbaru --}}
    <div>
        <div class="u-flex u-justify-between u-align-end u-flex-wrap u-gap-sm u-mb-lg">
            <div>
                <h2 class="jp-section__title u-mb-0">Permohonan Terbaru Anda</h2>
                <p class="jp-section__desc">Lima usulan inovasi terakhir beserta status progresnya.</p>
            </div>
            @if($countTotal > 0)
                <a href="{{ route('permohonan.index') }}" class="jp-link-arrow">
                    Lihat Semua ({{ $countTotal }}) <span aria-hidden="true">&rarr;</span>
                </a>
            @endif
        </div>

        @if($myPermohonan->count() > 0)
            <div class="jp-table-wrapper">
                <table class="jp-table">
                    <thead>
                        <tr>
                            <th style="width: 130px;">Kode</th>
                            <th>Nama Inovasi</th>
                            <th style="width: 120px;">Diajukan</th>
                            <th style="width: 175px;">Status</th>
                            <th style="width: 130px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myPermohonan as $item)
                            @php
                                if ($item->status == 0) {
                                    $rowBadge = 'jp-badge--amber';
                                    $rowLabel = 'Menunggu Validasi';
                                } elseif ($item->status == 1 || $item->status == 2) {
                                    $rowBadge = 'jp-badge--accent';
                                    $rowLabel = 'Pembahasan';
                                } elseif ($item->status == 4) {
                                    $rowBadge = 'jp-badge--success';
                                    $rowLabel = 'Selesai';
                                } elseif ($item->status == 9) {
                                    $rowBadge = 'jp-badge--danger';
                                    $rowLabel = 'Ditolak';
                                } else {
                                    $rowBadge = 'jp-badge--neutral';
                                    $rowLabel = 'Draf';
                                }
                                $tautan = route('permohonan.show', $item->kode ?? $item->uuid);
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ $tautan }}" class="font-mono" style="font-weight: 700;">{{ $item->kode }}</a>
                                </td>
                                <td>
                                    <a href="{{ $tautan }}" class="jp-link-title" style="font-weight: 600;">
                                        {{ $item->label ?? $item->nama_inovasi ?? $item->kode }}
                                    </a>
                                </td>
                                <td class="font-mono" style="white-space: nowrap; color: var(--c-ink-subtle);">
                                    {{ $item->created_at ? $item->created_at->format('d M Y') : '—' }}
                                </td>
                                <td>
                                    <span class="jp-badge {{ $rowBadge }}">{{ $rowLabel }}</span>
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ $tautan }}" class="jp-btn jp-btn--ghost jp-btn--sm"
                                       title="{{ $item->status > 0 ? 'Kelola berkas indikator' : 'Lihat detail & riwayat status' }}">
                                        {{ $item->status > 0 ? 'Kelola' : 'Detail' }}
                                        <x-icon name="chevron-right" size="12" />
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-empty
                icon="document"
                title="Anda belum mengajukan inovasi"
                desc="Usulan yang Anda buat akan tampil di sini beserta kode pelacakan dan status verifikasinya."
                :action="route('permohonan.create')"
                actionLabel="Buat Usulan Inovasi Pertama"
            />
        @endif
    </div>
@else
    {{-- Biodata belum lengkap --}}
    <div class="jp-notice jp-notice--amber u-mb-xl">
        <span class="jp-notice__icon"><x-icon name="alert-triangle" size="22" /></span>
        <div class="jp-notice__body">
            <strong class="jp-notice__title">Biodata pengguna belum lengkap</strong>
            <p class="jp-notice__text">
                Silakan melengkapi data profil Anda terlebih dahulu sebelum mengajukan permohonan inovasi baru.
                Isian meliputi Nama Lengkap, NIK, NIP, Nomor WhatsApp, Email, Unit Kerja, dan Jabatan.
            </p>
        </div>
        <div class="jp-notice__action">
            <a href="{{ route('settings.profile.index') }}" class="jp-btn jp-btn--accent">
                Lengkapi Profil Sekarang <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
    </div>

    <div class="l-grid l-grid--2">
        <a href="{{ route('settings.profile.index') }}" class="jp-action-card jp-action-card--accent">
            <div>
                <span class="jp-action-card__icon-box"><x-icon name="user" size="22" /></span>
                <h3 class="jp-action-card__title">Lengkapi Profil Biodata</h3>
                <p class="jp-action-card__desc">Isi data diri dan instansi Anda untuk membuka akses pengajuan inovasi.</p>
            </div>
            <span class="jp-action-card__link">Buka Pengaturan Profil <span aria-hidden="true">&rarr;</span></span>
        </a>

        <a href="{{ url('/faq') }}" class="jp-action-card jp-action-card--amber">
            <div>
                <span class="jp-action-card__icon-box jp-action-card__icon-box--amber"><x-icon name="info" size="22" /></span>
                <h3 class="jp-action-card__title">Panduan &amp; Bantuan Teknis</h3>
                <p class="jp-action-card__desc">Pelajari alur pengajuan, syarat berkas, dan pertanyaan yang sering diajukan.</p>
            </div>
            <span class="jp-action-card__link">Buka FAQ <span aria-hidden="true">&rarr;</span></span>
        </a>
    </div>
@endif
