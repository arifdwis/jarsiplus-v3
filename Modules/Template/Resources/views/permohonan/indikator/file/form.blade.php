<div class="u-mb-md">
    <h3 class="u-mb-2xs">Formulir Upload Data Dukung</h3>
    <p class="jp-field__hint">Tanda bintang (<span class="jp-label__required">*</span>) menunjukkan isian wajib.</p>
</div>

<div class="jp-form-grid u-mb-md">
    <div class="jp-field">
        <label class="jp-field__label">Nama File / Label Berkas <span class="jp-label__required">*</span></label>
        {!! Form::text('label', null, ['class' => 'jp-input', 'required' => 'required', 'placeholder' => 'Deskripsikan berkas Anda…']) !!}
        {!! $errors->first('label', '<small class="jp-field__error">:message</small>') !!}
    </div>

    <div class="jp-field">
        <label class="jp-field__label">Nomor Surat / SK Dokumen <span class="jp-label__required">*</span></label>
        {!! Form::text('nomor_surat', null, ['class' => 'jp-input', 'required' => 'required', 'placeholder' => 'Masukkan nomor surat atau SK…']) !!}
        {!! $errors->first('nomor_surat', '<small class="jp-field__error">:message</small>') !!}
    </div>
</div>

@if(!isset($data))
    <div class="jp-field u-mb-md">
        <label class="jp-field__label" for="jenis">Jenis Berkas / Sumber Data <span class="jp-label__required">*</span></label>
        <select class="jp-input" name="jenis" id="jenis" required>
            <option value="url">URL / Link Web (https://…)</option>
            @foreach(permohonan_files() as $key => $value)
                <option value="{{$key}}">{{Str::title($value)}} (File Upload)</option>
            @endforeach
        </select>
    </div>
@endif

{{-- Isian URL --}}
<div class="jp-field u-mb-md" id="field-url">
    <label class="jp-field__label">URL / Tautan Dokumen <span class="jp-label__required">*</span></label>
    {!! Form::text('url', null, ['class' => 'jp-input', 'placeholder' => 'https://samarindakota.go.id/dokumen.pdf']) !!}
    {!! $errors->first('url', '<small class="jp-field__error">:message</small>') !!}
</div>

{{-- Isian unggah berkas --}}
<div class="jp-field u-mb-md" id="field-file" style="display: none;">
    <label class="jp-field__label" for="file-upload">Upload File Lampiran <span class="jp-label__required">*</span></label>
    <input type="file" name="file" id="file-upload" class="jp-input jp-input--file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.mp4">
    <p class="jp-field__hint">Format didukung: PDF, DOCX, PNG, JPG, MP4. Ukuran maksimal <strong>10 MB</strong>.</p>
    {!! $errors->first('file', '<small class="jp-field__error">:message</small>') !!}
</div>

<div class="jp-field u-mb-md">
    <label class="jp-field__label">Deskripsi &amp; Penjelasan Berkas</label>
    {!! Form::textarea('deskripsi', null, ['class' => 'jp-textarea', 'rows' => 3, 'placeholder' => 'Jelaskan ringkas isi berkas bukti dukung ini…']) !!}
    {!! $errors->first('deskripsi', '<small class="jp-field__error">:message</small>') !!}
</div>
