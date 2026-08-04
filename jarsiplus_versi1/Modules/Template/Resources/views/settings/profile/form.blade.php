 <div class="form-head">
        <h4 class="font-weight-bold">Lengkapi form di bawah : </h4>
        <small>(<span style="color: #d93659; font-weight: bold;">*</span>) Tidak boleh kosong</small>
    </div>
    <hr>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label pb-0" for="name">Nama Lengkap</label>
            <small>(Lengkap dengan title)</small>
            {!! Form::text('name', null, ['class' => 'form-control ', 'placeholder' => 'Contoh : Some One','required']) !!}
            {!! $errors->first('name', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>


    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="nickname">Nama Panggilan</label>
            {!! Form::text('nickname', null, ['class' => 'form-control ', 'placeholder' => 'Contoh : Some One','required']) !!}
            {!! $errors->first('nickname', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="nik">NIK</label>
            {!! Form::tel('nik', null, ['class' => 'form-control', 'placeholder' => 'Contoh : 199713314xxxx','required']) !!}
            {!! $errors->first('nik', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="name">Jenis Kelamin</label>

            <div class="custom-control custom-radio d-inline pr-5">
                <input type="radio" id="radio-1" value="L" name="gender" 
                {{$data->gender == 'L' ? 'checked' : ''}}  
                class="custom-control-input">

                <label class="custom-control-label p-0" for="radio-1">Laki-laki</label>
            </div>
            <div class="custom-control custom-radio d-inline">
                <input type="radio" id="radio-2" value="P" name="gender" 
                {{$data->gender == 'P' ? 'checked' : ''}}  
                class="custom-control-input">

                <label class="custom-control-label p-0" for="radio-2">Perempuan</label>
            </div>
        </div>
    </div>

   
    <hr>

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
            {!! Form::email('email', null, ['class' => 'form-control   ', 'placeholder' => 'Contoh : anonymnous@gmail.com','required']) !!}
            {!! $errors->first('email', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>
    <hr>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="kota_id">Kabupaten/Kota</label>
            <select class="form-control custom-select select2 py-2" name="kota_id" id="kota_id">
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
            <label class="require-form label" for="address">Alamat</label>
            {!! Form::textarea('address', null, ['class' => 'form-control   ', 'placeholder' => 'Contoh : Jl. Kusuma Bangsa No.66, Samarinda', 'rows' => 3]) !!}
            {!! $errors->first('address', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <hr>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="unit_kerja">Unit Kerja</label>
            {!! Form::text('unit_kerja', null, ['class' => 'form-control ', 'placeholder' => 'Contoh : Dinas Komunikasi dan Informatika','required']) !!}
            {!! $errors->first('unit_kerja', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="nip">Nomor Kepegawaian</label>
            {!! Form::tel('nip', null, ['class' => 'form-control', 'placeholder' => 'Contoh : 199713314xxxx','required']) !!}
            {!! $errors->first('nip', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="jabatan">Jabatan</label>
            {!! Form::text('jabatan', null, ['class' => 'form-control', 'placeholder' => 'Contoh : Staff','required']) !!}
            {!! $errors->first('jabatan', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    