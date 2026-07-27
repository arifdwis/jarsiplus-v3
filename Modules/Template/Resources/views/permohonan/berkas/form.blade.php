<div class="form-head">
    <h4 class="font-weight-bold">Lengkapi form di bawah : </h4>
    <small>(<span style="color: #d93659; font-weight: bold;">*</span>) Tidak boleh kosong</small>
</div>
<hr>    

<div class="form-group boxed">
    <div class="input-wrapper">
        <label class="label require-form" for="label"> Nama File </label>
        <!-- <small class="text-muted">(500 Kata)</small> -->

        {!! Form::text('label', null, ['class' => 'form-control', 'placeholder'=>'Deskripsikan berkas anda.']) !!}
        {!! $errors->first('label', '<span class="text-muted"><small>:message</small></span>') !!}
        <i class="clear-input">
            <ion-icon name="close-circle"></ion-icon>
        </i>
    </div>
</div>

<div class="form-group boxed">
    <div class="input-wrapper">
        <label class="label require-form" for="nomor_surat"> Nomor Surat </label>
        <!-- <small class="text-muted">(500 Kata)</small> -->

        {!! Form::text('nomor_surat', null, ['class' => 'form-control', 'placeholder'=>'Deskripsikan berkas anda.']) !!}
        {!! $errors->first('nomor_surat', '<span class="text-muted"><small>:message</small></span>') !!}
        <i class="clear-input">
            <ion-icon name="close-circle"></ion-icon>
        </i>
    </div>
</div>

<div class="form-group boxed">
    <div class="input-wrapper">
        <label class="url" for="url"> Url</label>
        <!-- <small class="text-muted">(500 Kata)</small> -->

        {!! Form::text('url', null, ['class' => 'form-control', 'placeholder'=>'Deskripsikan berkas anda.']) !!}
        {!! $errors->first('url', '<span class="text-muted"><small>:message</small></span>') !!}
        <i class="clear-input">
            <ion-icon name="close-circle"></ion-icon>
        </i>
    </div>
</div>

@if(!isset($data))
<div class="form-group boxed">
    <div class="input-wrapper">
        <label class="label require-form" for="label">Jenis Berkas</label>
        <select class="form-control custom-select select2 py-2" name="label" id="label">
            @foreach(permohonan_files() as $key=>$value)
            <option value="{{$key}}">{{Str::title($value)}}</option>
            @endforeach
        </select>
    </div>
</div>
@endif

<div class="form-group boxed">
    <div class="input-wrapper">
        <label class="label require-form" for="label">File Berkas</label>
        <div class="custom-file-upload">
         <input type="file" name="file" id="file-upload" accept=".pdf, .jpg, .jpeg, .png" size="500000">
         <label for="file-upload">
            <span>
                <strong>
                    <ion-icon name="cloud-upload-outline"></ion-icon>
                    <i>Tap to Upload (Max 500 KB)</i>
                </strong>
            </span>
        </label>
    </div>
</div>
</div>


<div class="form-group boxed">
    <div class="input-wrapper">
        <label class="label" for="deskripsi">Deskripsi Berkas </label>
        <small class="text-muted">(500 Kata)</small>

        {!! Form::textarea('deskripsi', null, ['class' => 'form-control', 'placeholder'=>'Deskripsikan berkas anda.']) !!}
        {!! $errors->first('deskripsi', '<span class="text-muted"><small>:message</small></span>') !!}
        <i class="clear-input">
            <ion-icon name="close-circle"></ion-icon>
        </i>
    </div>
</div>
