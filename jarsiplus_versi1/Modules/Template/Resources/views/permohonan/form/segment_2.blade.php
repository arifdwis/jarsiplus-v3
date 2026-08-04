<div class="form-2 d-none">
    <div class="form-head">
        <h4 class="font-weight-bold">Inovator </h4>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="sso-ppksd1">NIK</label>
            {!! Form::text('nik', optional(me()->pemohon)->nik, ['class' => 'form-control', 'placeholder' => 'Contoh : 647200001xxx','disabled']) !!}
            {!! $errors->first('nik', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="nama">Nama Lengkap</label>
            {!! Form::text('nama', optional(me()->pemohon)->name, ['class' => 'form-control   ', 'placeholder' => 'Contoh : Some One','disabled']) !!}
            {!! $errors->first('nama', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="nip">NIP/Nomor Kepegawaian/Nomor Karyawan</label>
            {!! Form::text('nip', optional(me()->pemohon)->nip, ['class' => 'form-control', 'placeholder' => 'Contoh : 199713314xxxx','disabled']) !!}
            {!! $errors->first('nip', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="telepon_p">Telp. Pribadi</label>
            {!! Form::tel('telepon_p', optional(me()->pemohon)->phone, ['class' => 'form-control', 'placeholder' => 'Contoh : 081259xxxx','disabled']) !!}
            {!! $errors->first('telepon_p', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="email_p">Email Pribadi</label>
            {!! Form::email('email_p', optional(me()->pemohon)->email, ['class' => 'form-control   ', 'placeholder' => 'Contoh : anonymnous@gmail.com','disabled']) !!}
            {!! $errors->first('email_p', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="unit_kerja">Unit Kerja</label>
            {!! Form::text('unit_kerja', optional(me()->pemohon)->unit_kerja, ['class' => 'form-control ', 'placeholder' => 'Contoh : Dinas Komunikasi dan Informatika','disabled']) !!}
            {!! $errors->first('unit_kerja', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="jabatan">Jabatan</label>
            {!! Form::text('jabatan', optional(me()->pemohon)->jabatan, ['class' => 'form-control', 'placeholder' => 'Contoh : Staff','disabled']) !!}
            {!! $errors->first('jabatan', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <hr>

 {{--  <div class="form-head">
          <h4 class="font-weight-bold">Pemohon Pengajuan Kerja Sama Daerah (PPKSD)-2</h4>
      </div>
  
      <div class="form-group boxed">
          <div class="input-wrapper">
              <label class="require-form label" for="id_pemohon_1">PPKSD 2</label>
              <select class="form-control custom-select select2 py-2" name="id_pemohon_1" id="id_pemohon_1">
                  <option value="null">-- Pilih Salah Satu --</option>
                  @foreach(Modules\Pemohon\Entities\Pemohon::orderBy('name','asc')->get() as $i => $value)
                  @isset($data)
                  <option {{$data->id_pemohon_1 == $value->id ? 'selected' : ''}} value="{{$value->id}}">{{$value->name}}</option>
                  @else
                  <option value="{{$value->id}}">{{$value->name}}</option>
                  @endif
                  @endforeach
              </select>
          </div>
      </div>
  --}}
    <div class="row mt-3 mb-3">
        <div class="col-12 pb-2 d-flex justify-content-center">
            <div class="custom-control custom-switch p-0 p-1">
                <input type="checkbox" class="custom-control-input" id="check-form-2">
                <label class="custom-control-label" for="check-form-2"></label>
            </div>
        </div>
        <div class="col-12">
            <small>Dengan menggunakan layanan kami, Anda memercayakan informasi Anda kepada kami. Kami paham bahwa melindungi informasi Anda dan memberikan kontrol kepada Anda adalah tanggung jawab yang besar dan memerlukan kerja keras.</small>
        </div>
    </div>


    <div class="mt-3 mb-1 w-100 d-flex justify-content-between">
        <button type="button" class="btn btn-outline-primary btn-prev-form"><ion-icon name="arrow-back-outline"></ion-icon> Sebelumnya</button>
        <button type="button" class="btn btn-primary btn-next-form" disabled='true'><ion-icon name="arrow-forward-outline"></ion-icon> Selanjutnya</button>
    </div>

</div>