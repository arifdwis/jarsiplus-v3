@foreach($data as $temp)
    <div class="modal fade modalbox" id="ModalForm{{$temp->id}}" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                   <a href="{{ route("indikator.data.index", [$temp->uuid]) }}" class="btn btn-primary">Data Dukung</a>
                    <a href="javascript:;" data-dismiss="modal">Close</a>
                    
                </div>
                <div class="modal-body">
                    <div class="login-form">
                        <div class="section mt-2">
                            <h1>{{$temp->label_indikator}}</h1>
                            <h4>Parameter {{$temp->indikators->deskripsi}}</h4>
                        </div>
                        <div class="section mt-4 mb-5">
                            {!! Form::model($temp, ['route' => ["$prefix.update", $parent->uuid, $temp->id], 'autocomplete' => 'off', 'files' => true, 'method' => 'PUT']) !!}
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="require-form label" for="parameter_id">Parameter</label>
                                    <select class="form-control custom-select select2 py-2" name="parameter_id" id="parameter_id">
                                        <option value="null" selected>-- Pilih Salah Satu --</option>
                                        @foreach(Modules\Formulir\Entities\Parameter::where('indikator_id', $temp->indikator_id)->orderBy('bobot', 'asc')->get() as $parameter)
                                        <option value="{{$parameter->id}}" data-bobot="{{$parameter->bobot}}">{{$parameter->label}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary btn-block btn-lg">Submit</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach