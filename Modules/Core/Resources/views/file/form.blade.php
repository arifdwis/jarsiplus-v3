<div class="card-body bg-light pb-10" style="min-height:calc(100vh - 163px)">
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="label">
            Kategori File <span class="text-danger">*</span>
        </label>
        <div class="col-sm-6">
            <select class="form-select form-select-lg mb-3" name="label">
              <option selected="">Pilih Kategori File Permohonan</option>
              <option value="Surat Tanggapan Kerja Sama" class="dropdown-item">Surat Tanggapan Kerja Sama</option>
              <option value="Penawaran Kerja Sama" class="dropdown-item">Penawaran Kerja Sama</option>
              <option value="Rancangan Kesepakatan Kerja Sama" class="dropdown-item">Rancangan Kesepakatan Kerja Sama</option>
              <option value="Rancangan Perjanjian Kerja Sama" class="dropdown-item">Rancangan Perjanjian Kerja Sama</option>
          </select>
</div>
</div>
<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="deskripsi">
        deskripsi <span class="text-danger">*</span>
    </label>
    <div class="col-sm-9">
        {!! Form::textarea('deskripsi', null, ['class' => 'form-control form-style' . $errors->first('deskripsi', ' is-invalid')]) !!}
        {!! $errors->first('deskripsi', ' <span class="invalid-feedback">:message</span>') !!}
    </div>
</div>
<div class="row mb-2">
    <label class="col-sm-2 col-form-label" for="file">
        FILE
    </label>
    <div class="col-md-6">
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
</div>
</div>

<div class="position-fixed start-50 bottom-0 translate-middle-x w-100 zi-99 mb-3" style="max-width: 40rem;">
    <div class="card card-sm bg-dark border-dark mx-2">
        <div class="card-body">
            <div class="row justify-content-center justify-content-sm-between">
                <div class="col">
                    <a href="{{ route("$prefix.index" ,$kategori->uuid) }}" class="btn btn-ghost-light">
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