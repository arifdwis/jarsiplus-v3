 <div class="form-head">
        <h4 class="font-weight-bold">Lengkapi form di bawah : </h4>
        <small>(<span style="color: #d93659; font-weight: bold;">*</span>) Tidak boleh kosong</small>
    </div>
    <hr>

   <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="name" >Nama Instansi</label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Contoh : Dinas Pariwisata','required']) !!}
            {!! $errors->first('name', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="kota_id">Kabupaten/Kota</label>
            <select class="form-control custom-select select2 py-2" name="kota_id" id="kota_id" required/>
                <option value="null" disabled selected="">-- Pilih Salah Satu --</option>
                @foreach(Modules\Wilayah\Entities\Provinsi::orderBy('name','asc')->get() as $i => $temp)
                
                <optgroup label="{{$temp->name}}">
                    @foreach($temp->citys as $n => $child)
                        @isset($data)
                            <option {{$data->kota_id == $child->id ? 'selected' : ''}} value="{{$child->id.';'.$child->name}}">{{$child->name}}</option>
                        @else
                            <option value="{{$child->id}}">{{$child->name}}</option>
                        @endif
                    @endforeach
                </optgroup>
                
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="postal_code">Kode Pos</label>
            {!! Form::tel('postal_code', null, ['class' => 'form-control ', 'placeholder' => 'Contoh : 7712xx','required']) !!}
            {!! $errors->first('postal_code', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="address">Alamat</label>
            {!! Form::textarea('address', null, ['class' => 'form-control   ', 'placeholder' => 'Contoh : Jl. Kusuma Bangsa No.66, Samarinda', 'rows' => 3,'required']) !!}
            {!! $errors->first('address', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="phone">Telepon</label>
            {!! Form::tel('phone', null, ['class' => 'form-control', 'placeholder' => 'Contoh : 081259xxxx','required']) !!}
            {!! $errors->first('phone', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="email">Email</label>
            {!! Form::email('email', null, ['class' => 'form-control   ', 'placeholder' => 'Contoh : anonymous@gmail.com','required']) !!}
            {!! $errors->first('email', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label" for="website">Website</label>
            {!! Form::text('website', null, ['class' => 'form-control  ', 'placeholder' => 'Contoh : https://diskominfo.samarindakot.go.id']) !!}
            {!! $errors->first('website', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    