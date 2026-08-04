<div class="card-body bg-light pb-10" style="min-height:calc(100vh - 163px)">
    <h2>BIODATA PEMOHON</h2>
    <div class="row mb-3">
        <label class="col-sm-1 col-form-label" for="nama">
            Nama <span class="text-danger">*</span>
        </label>
        <div class="col-sm-9">
            {!! Form::text('nama', null, ['class' => 'form-control' . $errors->first('nama', ' is-invalid')]) !!}
            {!! $errors->first('nama', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-1 col-form-label" for="nip">
            NIP <span class="text-danger">*</span>
        </label>
        <div class="col-sm-4">
            {!! Form::text('nip', null, ['class' => 'form-control' . $errors->first('nip', ' is-invalid')]) !!}
            {!! $errors->first('nip', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
        <label class="col-sm-1 col-form-label" for="nik">
            NIK <span class="text-danger">*</span>
        </label>
        <div class="col-sm-4">
            {!! Form::text('nik', null, ['class' => 'form-control' . $errors->first('nik', ' is-invalid')]) !!}
            {!! $errors->first('nik', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-1 col-form-label" for="telepon">
            No. HP <span class="text-danger">*</span>
        </label>
        <div class="col-sm-4">
            {!! Form::text('telepon', null, ['class' => 'form-control' . $errors->first('telepon', ' is-invalid')]) !!}
            {!! $errors->first('telepon', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
        <label class="col-sm-1 col-form-label" for="email">
            EMAIL <span class="text-danger">*</span>
        </label>
        <div class="col-sm-4">
            {!! Form::email('email', null, ['class' => 'form-control' . $errors->first('email', ' is-invalid')]) !!}
            {!! $errors->first('email', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
    <div class="row mb-2">
    </div>
    <div class="row mb-2">
        <label class="col-sm-1 col-form-label" for="file">
            FILE
        </label>
        <div class="col-md-4">
            <fieldset class="form-group {{ $errors->first('file', 'form-group-error') }}">
            {!! Form::file('file', ['class' => 'form-control']) !!}
            {!! $errors->first('file', '<span class="text-muted"><small>:message</small></span>') !!}
        </fieldset>
        <div class="alert alert-success">
            <small>
                Hanya menerima file dengan format <b>pdf</b>.
            </small>
        </div>
    </div>
    <label class="col-sm-1 col-form-label" for="foto">
            Foto
        </label>
        <div class="col-sm-4">
            <div class="d-flex align-items-center">
                <label class="avatar avatar-xl avatar-rounded" for="foto">
                    @isset($edit)
                    <img id="avatarImg" class="avatar-img" src="{{ $edit->foto }}" alt="">
                    @else
                    <img id="avatarImg" class="avatar-img" src="https://cdn.btekno.id/templates/v2/img/160x160/img1.jpg" alt="">
                    @endisset
                </label>

                <div class="d-flex gap-3 ms-3">
                    <div class="form-attachment-btn btn btn-xs btn-primary">
                        Upload foto
                        <input type="file" class="js-file-attach form-attachment-btn-label" id="foto" name="foto" 
                        data-hs-file-attach-options='{
                            "textTarget": "#avatarImg",
                            "mode": "image",
                            "targetAttr": "src",
                            "resetTarget": ".js-file-attach-reset-img",
                            "resetImg": "https://cdn.btekno.id/templates/v2/img/160x160/img1.jpg",
                            "allowTypes": [".png", ".jpeg", ".jpg"]
                        }'>
                    </div>
                    <button type="button" class="js-file-attach-reset-img btn btn-white btn-xs ms-n2">Delete</button>
                </div>
            </div>
            {!! $errors->first('foto', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
</div>
<br>
<h2>UNIT KERJA PEMOHON</h2>
<div class="row mb-3">
    <label class="col-sm-1 col-form-label" for="unit_kerja">
       INSTANSI<span class="text-danger">*</span>
   </label>
   <div class="col-sm-9">
    {!! Form::text('unit_kerja', null, ['class' => 'form-control' . $errors->first('unit_kerja', ' is-invalid')]) !!}
    {!! $errors->first('unit_kerja', ' <span class="invalid-feedback">:message</span>') !!}
</div>
</div>
<div class="row mb-3">
    <label class="col-sm-1 col-form-label" for="jabatan">
        JABATAN<span class="text-danger">*</span>
    </label>
    <div class="col-sm-9">
        {!! Form::text('jabatan', null, ['class' => 'form-control' . $errors->first('jabatan', ' is-invalid')]) !!}
        {!! $errors->first('jabatan', ' <span class="invalid-feedback">:message</span>') !!}
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