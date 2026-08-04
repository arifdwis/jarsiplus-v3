<div class="form-head">
    <h4 class="font-weight-bold">Lengkapi form di bawah : </h4>
    <small>(<span style="color: #d93659; font-weight: bold;">*</span>) Tidak boleh kosong</small>
</div>
<hr>

<div class="form-group boxed">
    <div class="input-wrapper">
        <label class="label require-form" for="label"> Nama File </label>
        {!! Form::text('label', null, ['class' => 'form-control', 'placeholder' => 'Deskripsikan berkas anda.']) !!}
        {!! $errors->first('label', '<span class="text-muted"><small>:message</small></span>') !!}
        <i class="clear-input">
            <ion-icon name="close-circle"></ion-icon>
        </i>
    </div>
</div>

<div class="form-group boxed">
    <div class="input-wrapper">
        <label class="label require-form" for="nomor_surat"> Nomor Surat </label>
        {!! Form::text('nomor_surat', null, ['class' => 'form-control', 'placeholder' => 'Masukkan nomor surat.']) !!}
        {!! $errors->first('nomor_surat', '<span class="text-muted"><small>:message</small></span>') !!}
        <i class="clear-input">
            <ion-icon name="close-circle"></ion-icon>
        </i>
    </div>
</div>

@if(!isset($data))
    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="jenis">Jenis Berkas</label>
            <select class="form-control custom-select select2 py-2" name="jenis" id="jenis">
                <option value="url">URL / Link</option>
                @foreach(permohonan_files() as $key => $value)
                    <option value="{{$key}}">{{Str::title($value)}}</option>
                @endforeach
            </select>
        </div>
    </div>
@endif

{{-- Field URL - tampil ketika jenis = url --}}
<div class="form-group boxed" id="field-url">
    <div class="input-wrapper">
        <label class="label require-form" for="url">URL / Link</label>
        {!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'Masukkan URL lengkap (https://...)']) !!}
        {!! $errors->first('url', '<span class="text-muted"><small>:message</small></span>') !!}
        <i class="clear-input">
            <ion-icon name="close-circle"></ion-icon>
        </i>
    </div>
</div>

{{-- Field File Upload - tampil ketika jenis = file (pdf/word/png/mp4) --}}
<div class="form-group boxed" id="field-file" style="display: none;">
    <div class="input-wrapper">
        <label class="label require-form" for="file-upload">File Berkas</label>
        <div
            style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 8px 12px; font-size: 12px; color: #856404; margin-bottom: 10px;">
            <strong>⚠ Perhatian:</strong> Ukuran file maksimal <b>10 MB</b>
        </div>
        <div class="custom-file-upload">
            <input type="file" name="file" id="file-upload" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.mp4">
            <label for="file-upload">
                <span>
                    <strong>
                        <ion-icon name="cloud-upload-outline"></ion-icon>
                        <i>Tap to Upload</i>
                    </strong>
                </span>
            </label>
        </div>
        {!! $errors->first('file', '<span class="text-muted"><small>:message</small></span>') !!}
    </div>
</div>

<div class="form-group boxed">
    <div class="input-wrapper">
        <label class="label" for="deskripsi">Deskripsi Berkas </label>
        <small class="text-muted">(500 Kata)</small>
        {!! Form::textarea('deskripsi', null, ['class' => 'form-control', 'placeholder' => 'Deskripsikan berkas anda.']) !!}
        {!! $errors->first('deskripsi', '<span class="text-muted"><small>:message</small></span>') !!}
        <i class="clear-input">
            <ion-icon name="close-circle"></ion-icon>
        </i>
    </div>
</div>