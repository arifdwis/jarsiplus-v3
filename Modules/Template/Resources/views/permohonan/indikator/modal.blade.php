@foreach($data as $temp)
    @php
        $pendaftaranDitutup = role_me() == 4 && pendaftaran_inovasi_ditutup();
        $parameterTerpilih = $temp->label_parameter ?? ($temp->parameters->label ?? null);
    @endphp

    <dialog class="jp-modal" id="modal-{{$temp->id}}">
        <div class="jp-modal__head">
            <div style="min-width: 0;">
                <span class="jp-modal__eyebrow">INDIKATOR</span>
                <h3 class="jp-modal__title">{{ $temp->label_indikator }}</h3>
            </div>
            <button type="button" class="jp-modal__close" aria-label="Tutup" onclick="this.closest('dialog').close()">
                <x-icon name="close" size="22" />
            </button>
        </div>

        <div class="jp-modal__body">
            @if(filled($temp->indikators->deskripsi ?? null))
                <p class="jp-card__text u-mb-md">{{ $temp->indikators->deskripsi }}</p>
            @endif

            <div class="jp-notice jp-notice--amber u-mb-md">
                <span class="jp-notice__icon"><x-icon name="info" size="18" /></span>
                <div class="jp-notice__body">
                    <p class="jp-notice__text">
                        Unggah <strong>data dukung</strong> terlebih dahulu sebelum memilih parameter.
                        Jika bukti dukung kosong, bobot tetap kosong meskipun parameter sudah dipilih.
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
                            @if($temp->bobot)<br>Bobot: <strong>{{ $temp->bobot }}</strong>@endif
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
                {!! Form::model($temp, ['route' => ["$prefix.update", $parent->uuid, $temp->id], 'autocomplete' => 'off', 'files' => true, 'method' => 'PUT', 'id' => 'formModalParameter-'.$temp->id]) !!}
                    <div class="jp-field">
                        <label class="jp-label" for="parameter_id_{{$temp->id}}">Parameter</label>
                        <select class="jp-select" name="parameter_id" id="parameter_id_{{$temp->id}}">
                            <option value="">-- Pilih Salah Satu --</option>
                            @foreach(Modules\Formulir\Entities\Parameter::where('indikator_id', $temp->indikator_id)->orderBy('bobot', 'asc')->get() as $parameter)
                                <option value="{{$parameter->id}}" data-bobot="{{$parameter->bobot}}" {{ $temp->parameter_id == $parameter->id ? 'selected' : '' }}>
                                    {{$parameter->label}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                {!! Form::close() !!}
            @else
                <div class="jp-field">
                    <label class="jp-label" for="parameter_id_view_{{$temp->id}}">Parameter</label>
                    <select class="jp-select" name="parameter_id" id="parameter_id_view_{{$temp->id}}" disabled>
                        <option value="">-- Pilih Salah Satu --</option>
                        @foreach(Modules\Formulir\Entities\Parameter::where('indikator_id', $temp->indikator_id)->orderBy('bobot', 'asc')->get() as $parameter)
                            <option value="{{$parameter->id}}" data-bobot="{{$parameter->bobot}}" {{ $temp->parameter_id == $parameter->id ? 'selected' : '' }}>
                                {{$parameter->label}}
                            </option>
                        @endforeach
                    </select>
                    <p class="jp-field__hint">Hanya pemohon yang dapat mengubah parameter.</p>
                </div>
            @endif
        </div>

        <div class="jp-modal__foot">
            @if($pendaftaranDitutup)
                <span class="jp-btn jp-btn--ghost is-disabled">Data Dukung Ditutup</span>
            @else
                <a href="{{ route('indikator.data.index', [$temp->uuid]) }}" class="jp-btn jp-btn--ghost">Data Dukung</a>
            @endif

            @if(!$pendaftaranDitutup && role_me() == 4)
                <button type="submit" form="formModalParameter-{{$temp->id}}" class="jp-btn jp-btn--accent">Simpan</button>
            @else
                <button type="button" class="jp-btn jp-btn--ghost" onclick="this.closest('dialog').close()">Tutup</button>
            @endif
        </div>
    </dialog>
@endforeach
