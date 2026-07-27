@foreach($data as $temp)
    @php
        $pendaftaranDitutup = role_me() == 4 && pendaftaran_inovasi_ditutup();
    @endphp
    <div class="modal fade modalbox" id="ModalForm{{$temp->id}}" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if($pendaftaranDitutup)
                        <span class="btn btn-secondary disabled">Data Dukung Ditutup</span>
                    @else
                        <a href="{{ route("indikator.data.index", [$temp->uuid]) }}" class="btn btn-primary">Data Dukung</a>
                    @endif
                    <a href="javascript:;" data-dismiss="modal">Close</a>

                </div>
                <div class="modal-body">
                    <div class="login-form">
                        <div class="section mt-2">
                            <h1>{{$temp->label_indikator}}</h1>
                            <h4>Parameter {{$temp->indikators->deskripsi}}</h4>
                        </div>

                        {{-- Info: upload bukti dukung dulu --}}
                        <div class="section mt-2">
                            <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 10px 14px; font-size: 13px; color: #856404;">
                                <strong><ion-icon name="information-circle-outline"></ion-icon> Penting:</strong>
                                Upload <b>Data Dukung</b> terlebih dahulu sebelum memilih parameter. Jika bukti dukung
                                kosong, bobot akan tetap kosong meskipun parameter sudah dipilih.
                            </div>
                        </div>

                        {{-- Tampilkan parameter yang sudah dipilih --}}
                        @if($temp->parameter_id)
                            <div class="section mt-2">
                                <div
                                    style="background: #e8f5e9; border: 1px solid #4caf50; border-radius: 8px; padding: 10px 14px; font-size: 13px;">
                                    <strong><ion-icon name="checkmark-circle-outline"></ion-icon> Parameter terpilih:</strong>
                                    {{ $temp->label_parameter ?? ($temp->parameters->label ?? '-') }}
                                    @if($temp->bobot)
                                        <br><strong>Bobot:</strong> {{ $temp->bobot }}
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($pendaftaranDitutup)
                            <div class="section mt-4 mb-5">
                                <div class="alert alert-warning mb-0">
                                    {{ pendaftaran_inovasi_pesan_tutup() }}
                                </div>
                            </div>
                        @elseif(role_me() == 4)
                            <div class="section mt-4 mb-5">
                                {!! Form::model($temp, ['route' => ["$prefix.update", $parent->uuid, $temp->id], 'autocomplete' => 'off', 'files' => true, 'method' => 'PUT']) !!}
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="require-form label" for="parameter_id_{{$temp->id}}">Parameter</label>
                                        <select class="form-control custom-select select2 py-2" name="parameter_id"
                                            id="parameter_id_{{$temp->id}}">
                                            <option value="">-- Pilih Salah Satu --</option>
                                            @foreach(Modules\Formulir\Entities\Parameter::where('indikator_id', $temp->indikator_id)->orderBy('bobot', 'asc')->get() as $parameter)
                                                <option value="{{$parameter->id}}" data-bobot="{{$parameter->bobot}}" {{ $temp->parameter_id == $parameter->id ? 'selected' : '' }}>{{$parameter->label}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg">Submit</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        @else
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="require-form label" for="parameter_id_view_{{$temp->id}}">Parameter</label>
                                    <select class="form-control custom-select select2 py-2" name="parameter_id"
                                        id="parameter_id_view_{{$temp->id}}" disabled>
                                        <option value="">-- Pilih Salah Satu --</option>
                                        @foreach(Modules\Formulir\Entities\Parameter::where('indikator_id', $temp->indikator_id)->orderBy('bobot', 'asc')->get() as $parameter)
                                            <option value="{{$parameter->id}}" data-bobot="{{$parameter->bobot}}" {{ $temp->parameter_id == $parameter->id ? 'selected' : '' }}>{{$parameter->label}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
