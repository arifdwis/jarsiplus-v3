<div class="card-body bg-light pb-10" style="min-height:calc(100vh - 163px)">

    <div class="row mb-2">
        <label class="col-sm-2 col-form-label" for="file">
            file
        </label>
        <div class="col-sm-8">
            <div class="d-flex align-items-center">
                <label class="avatar " for="avatarUploader" style="width: 200px; height: 100px;">
                    @if(!isset($edit))
                    <img src="{{asset('assets/img/holder.jpg')}}" alt="" style="width: 200px; height: 100px;">
                    @else
                    <img id="avatarImg" class="avatar-img" src="{{ viewImg($edit->file, 'm') }}" alt="">
                    @endisset
                </label>

                <div class="d-flex gap-3 ms-3">
                    <div class="form-attachment-btn btn btn-xs btn-primary">
                        Upload file
                        <input type="file" class="js-file-attach form-attachment-btn-label" id="avatarUploader" name="file" 
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
            {!! $errors->first('file', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-sm-2 col-form-label" for="label">
            label <span class="text-danger">*</span>
        </label>
        <div class="col-sm-8">
            {!! Form::text('label', null, ['class' => 'form-control' . $errors->first('label', ' is-invalid')]) !!}
            {!! $errors->first('label', ' <span class="invalid-feedback">:message</span>') !!}
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