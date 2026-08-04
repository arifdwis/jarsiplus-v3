<div class="card-body bg-light pb-10" style="min-height:calc(100vh - 163px)">
    <div class="content container-fluid p-3">
        <div class="row">
            {{-- Kolom Kiri: Detail Pengajuan --}}
            <div class="col-md-8 pe-2">
                <div class="card rounded-1 mb-3">
                    <div class="card-header">
                        <h3 class="card-title mb-0">PENGAJUAN INOVASI DAERAH</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="text-cap mb-3">Biodata Pemohon</h6>
                            <table class="table table-borderless table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <td class="text-muted" style="width: 180px;">Kabupaten / Kota</td>
                                        <td style="width: 10px;">:</td>
                                        <td class="text-uppercase fw-semibold">{{$edit->kota->name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Nama Instansi</td>
                                        <td>:</td>
                                        <td class="text-uppercase fw-semibold">{{ $edit->pemohon1->unit_kerja ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Administrator</td>
                                        <td>:</td>
                                        <td class="text-uppercase fw-semibold">{{$edit->pemohon1->name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">WhatsApp</td>
                                        <td>:</td>
                                        <td>
                                            <a href="https://wa.me/{{$edit->pemohon1->phone}}" target="_blank"
                                                class="link-primary">
                                                {{$edit->pemohon1->phone}}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h6 class="text-cap mb-2">Rancang Bangun</h6>
                            <p class="text-dark">{{$edit->rancang_bangun}}</p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-cap mb-2">Tujuan Inovasi</h6>
                            <p class="text-dark">{{$edit->tujuan_inovasi}}</p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-cap mb-2">Hasil Inovasi</h6>
                            <p class="text-dark">{{$edit->hasil_inovasi}}</p>
                        </div>

                        <div class="mb-0">
                            <h6 class="text-cap mb-2">Manfaat Inovasi</h6>
                            <p class="text-dark mb-0">{{$edit->manfaat_inovasi}}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Rincian + Action --}}
            <div class="col-md-4">
                {{-- Card Rincian --}}
                <div class="card rounded-1 mb-3">
                    <div class="card-header">
                        <h3 class="card-title mb-0">RINCIAN</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <small class="text-cap text-muted mb-1">Bidang Inovasi</small>
                                <div class="fw-semibold">{{$edit->kategori->label}}</div>
                            </li>
                            <li class="list-group-item">
                                <small class="text-cap text-muted mb-1">Urusan Utama</small>
                                <div class="fw-semibold">{{$edit->urusan_utama}}</div>
                            </li>
                            <li class="list-group-item">
                                <small class="text-cap text-muted mb-1">Urusan Lainnya</small>
                                <div class="fw-semibold">{{$edit->urusan_lainnya}}</div>
                            </li>
                            <li class="list-group-item">
                                <small class="text-cap text-muted mb-1">Tahapan Inovasi</small>
                                <div class="fw-semibold">
                                    {{ [$edit->tahapan, 'Inisiatif', 'Uji Coba', 'Penerapan'][$edit->tahapan] }}</div>
                            </li>
                            <li class="list-group-item">
                                <small class="text-cap text-muted mb-1">Inisiator Inovasi</small>
                                <div class="fw-semibold">
                                    {{ [1 => 'Kepala Daerah', 2 => 'Anggota DPRD', 3 => 'OPD', 4 => 'ASN', 5 => 'Masyarakat'][$edit->inisiator] }}
                                </div>
                            </li>
                            <li class="list-group-item">
                                <small class="text-cap text-muted mb-1">Jenis Inovasi</small>
                                <div class="fw-semibold">{{ [1 => 'Digital', 2 => 'Non Digital'][$edit->jenis] }}</div>
                            </li>
                            <li class="list-group-item">
                                <small class="text-cap text-muted mb-1">Anggaran Inovasi</small>
                                <div>
                                    @if($edit->anggaran)
                                        <a href="{{ asset($edit->anggaran) }}" class="btn btn-sm btn-primary"
                                            target="_blank">Lihat Data</a>
                                    @else
                                        <span class="text-muted">Tidak ada data</span>
                                    @endif
                                </div>
                            </li>
                            <li class="list-group-item">
                                <small class="text-cap text-muted mb-1">Proposal Inovasi</small>
                                <div>
                                    @if($edit->profil_bisnis)
                                        <a href="{{ asset($edit->profil_bisnis) }}" class="btn btn-sm btn-primary"
                                            target="_blank">Lihat Data</a>
                                    @else
                                        <span class="text-muted">Tidak ada data</span>
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Card Komentar Juri --}}
                <div class="card rounded-1 mb-3">
                    <div class="card-header">
                        <h3 class="card-title mb-0">KOMENTAR JURI</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $isJuriActiveAdmin = (!empty($juriComments) && count($juriComments));
                        @endphp
                        <button type="button"
                            class="btn w-100 {{ $isJuriActiveAdmin ? 'btn-primary' : 'btn-secondary juri-pending-btn-admin' }}"
                            @if($isJuriActiveAdmin)
                                data-bs-toggle="modal" data-bs-target="#modalKomentarJuri"
                            @endif
                            title="Dalam Proses Penilaian Juri">
                            <span class="iconify me-2"
                                data-icon="{{ $isJuriActiveAdmin ? 'ic:twotone-chat-bubble-outline' : 'mdi:comment-off-outline' }}"></span>
                            Komentar Juri
                        </button>
                    </div>
                </div>

                {{-- Card Action --}}
                <div class="card rounded-1 mb-3">
                    <div class="card-header">
                        <h3 class="card-title mb-0">ACTION</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="status">
                                Status <span class="text-danger">*</span>
                            </label>
                            @if($edit->status == 0)
                                <div class="mb-3">
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" value="1" name="status" id="pSetuju"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary" for="pSetuju">Setuju</label>
                                        <input type="radio" class="btn-check" value="9" name="status" id="pTolakRadio"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary" for="pTolakRadio">Tolak</label>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label" for="alasan_tolak">
                                        Alasan Penolakan <span class="text-danger">*</span>
                                    </label>
                                    {!! Form::textarea('alasan_tolak', null, ['class' => 'form-control' . $errors->first('alasan_tolak', ' is-invalid'), 'rows' => 4]) !!}
                                    {!! $errors->first('alasan_tolak', ' <span class="invalid-feedback">:message</span>') !!}
                                </div>
                            @elseif($edit->status == 1)
                                <div>
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" value="2" name="status" id="pLanjut"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary" for="pLanjut">Proses</label>
                                    </div>
                                </div>
                            @elseif($edit->status == 3)
                                <div>
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" value="4" name="status" id="pSelesai"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary" for="pSelesai">Selesai</label>
                                    </div>
                                </div>
                            @elseif($edit->status == 9)
                                <div>
                                    <input type="radio" class="btn-check" value="9" name="status" id="pTolak"
                                        autocomplete="off" disabled>
                                    <label class="btn btn-outline-danger" for="pTolak">Permohonan Di Tolak</label>
                                </div>
                            @else
                                <div>
                                    <input type="radio" class="btn-check" value="9" name="status" id="pTolak"
                                        autocomplete="off" disabled>
                                    <label class="btn btn-outline-success" for="pTolak">Telah Di Proses</label>
                                </div>
                            @endif

                        </div>
                        <hr>
                        <div>
                            <p class="text-muted small mb-2">
                                Kirim pemberitahuan manual sesuai status terakhir permohonan.
                            </p>
                            <button type="submit" form="status-notification-form" class="btn btn-outline-primary w-100">
                                <span class="iconify me-1" data-icon="mdi:whatsapp"></span>
                                Kirim Info Status via WhatsApp
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="position-fixed start-50 bottom-0 translate-middle-x w-100 zi-99 mb-3" style="max-width: 40rem;">
    <div class="card card-sm bg-dark border-dark mx-2">
        <div class="card-body">
            <div class="row justify-content-center justify-content-sm-between">
                <div class="col">
                    <a href="{{ route("$prefix.index") }}" class="btn btn-ghost-light">
                        <span class="iconify" data-icon="heroicons-solid:arrow-left"></span>
                        Back
                    </a>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-3">
                        <button type="reset" class="btn btn-ghost-light">Reset</button>
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
