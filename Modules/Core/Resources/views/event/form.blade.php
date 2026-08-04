<div class="card-body bg-light pb-10" style="min-height:calc(100vh - 163px)">

    <div class="row mb-2">
        <label class="col-sm-2 col-form-label" for="banner">
            File Banner (Potrait)
        </label>
        <div class="col-sm-8">
            <div class="d-flex align-items-center">
                <label class="avatar" for="avatarUploader" style="width: 140px; height: 180px; border-radius: 8px; overflow: hidden; border: 1px solid #CBD5E1; background: #FFFFFF;">
                    @if(!isset($edit) || !$edit->banner)
                    <img id="avatarImg" src="{{ asset('baimbai/Banner Lomba Baimbai 2026.jpeg') }}" alt="" style="width: 140px; height: 180px; object-fit: cover;">
                    @else
                    <img id="avatarImg" class="avatar-img" src="{{ asset($edit->banner) }}" alt="" style="width: 140px; height: 180px; object-fit: cover;">
                    @endif
                </label>

                <div class="d-flex gap-3 ms-3">
                    <div class="form-attachment-btn btn btn-xs btn-primary">
                        Upload File
                        <input type="file" class="js-file-attach form-attachment-btn-label" id="avatarUploader" name="banner" 
                        data-hs-file-attach-options='{
                            "textTarget": "#avatarImg",
                            "mode": "image",
                            "targetAttr": "src",
                            "allowTypes": [".png", ".jpeg", ".jpg"]
                        }'>
                    </div>
                </div>
            </div>
            {!! $errors->first('banner', '<span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-sm-2 col-form-label" for="title">
            Judul Event <span class="text-danger">*</span>
        </label>
        <div class="col-sm-8">
            {!! Form::text('title', null, ['class' => 'form-control' . $errors->first('title', ' is-invalid'), 'required' => 'required', 'placeholder' => 'Contoh: Lomba Inovasi Kota Samarinda "BAIMBAI 2026"']) !!}
            {!! $errors->first('title', '<span class="invalid-feedback">:message</span>') !!}
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
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
