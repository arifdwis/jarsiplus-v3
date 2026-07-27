<div class="card-body bg-light pb-10" style="min-height:calc(100vh - 163px)">

    <div class="row mb-2">
        <label class="col-sm-2 col-form-label" for="photo">
            Photo
        </label>
        <div class="col-sm-8">
            <div class="d-flex align-items-center">
                <label class="avatar avatar-xl avatar-rounded" for="avatarUploader">
                    @isset($edit)
                        <img id="avatarImg" class="avatar-img" src="{{ $edit->photo_url }}" alt="">
                    @else
                        <img id="avatarImg" class="avatar-img" src="https://cdn.btekno.id/templates/v2/img/160x160/img1.jpg" alt="">
                    @endisset
                </label>

                <div class="d-flex gap-3 ms-3">
                    <div class="form-attachment-btn btn btn-xs btn-primary">
                        Upload photo
                        <input type="file" class="js-file-attach form-attachment-btn-label" id="avatarUploader" name="photo" 
                        data-nue-file-attach-options='{
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
            {!! $errors->first('photo', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-sm-2 col-form-label" for="name">
            Name <span class="text-danger">*</span>
        </label>
        <div class="col-sm-8">
            {!! Form::text('name', null, ['class' => 'form-control form-style' . $errors->first('name', ' is-invalid')]) !!}
            {!! $errors->first('name', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-sm-2 col-form-label" for="email">
            Email <span class="text-danger">*</span>
        </label>
        <div class="col-sm-8">
            {!! Form::text('email', null, ['class' => 'form-control form-style' . $errors->first('email', ' is-invalid')]) !!}
            {!! $errors->first('email', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-sm-2 col-form-label" for="password">
            Password 
            @if(!isset($edit))
                <span class="text-danger">*</span>
            @endif
        </label>
        <div class="col-sm-4 pe-1">
            <div class="input-group input-group-merge {{ $errors->first('password', ' is-invalid') }}" data-nue-validation-validate-class>
                <input type="password" class="js-toggle-password form-control form-style" name="password" placeholder="{{ __('Enter your password') }}" aria-label="{{ __('Enter your password') }}"
                data-nue-toggle-password-options='{
                    "target": "#new-target",
                    "defaultClass": "bi-eye-slash",
                    "showClass": "bi-eye",
                    "classChangeTarget": "#new-icon"
                }'>
                <a id="new-target" class="input-group-append input-group-text" href="javascript:;">
                    <i id="new-icon" class="bi-eye"></i>
                </a>
            </div>
            {!! $errors->first('password', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
        <div class="col-sm-4 ps-1">
            <div class="input-group input-group-merge {{ $errors->first('password_confirmation', ' is-invalid') }}" data-nue-validation-validate-class>
                <input type="password" class="js-toggle-password form-control form-style" name="password_confirmation" placeholder="{{ __('Confirm your password') }}" aria-label="{{ __('Confirm your password') }}"
                data-nue-toggle-password-options='{
                    "target": "#confirm-target",
                    "defaultClass": "bi-eye-slash",
                    "showClass": "bi-eye",
                    "classChangeTarget": "#confirm-icon"
                }'>
                <a id="confirm-target" class="input-group-append input-group-text" href="javascript:;">
                    <i id="confirm-icon" class="bi-eye"></i>
                </a>
            </div>
            {!! $errors->first('password_confirmation', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
    
    <div class="row mb-2">
        <label class="col-sm-2 col-form-label" for="roles[]">
            Roles
        </label>
        <div class="col-sm-8">
            <div class="tom-select-custom tom-select-custom-with-tags">
                <select class="js-select form-select" autocomplete="off" multiple name="roles[]" 
                    data-nue-tom-select-options='{
                        "hideSearch": true,
                        "placeholder": "Select roles ..."
                    }'>
                    @foreach(config('nue.database.roles_model')::pluck('name', 'id') as $i => $temp)
                        <option value="{{ $i }}"
                            @isset($edit)
                                {{ in_array($i, $edit->roles()->pluck('id')->toArray()) ? 'selected' : '' }}
                            @endisset
                        >
                            {{ $temp }}
                        </option>
                    @endforeach
                </select>
            </div>
            {!! $errors->first('roles[]', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>

    <div class="row mb-2">
        <label class="col-sm-2 col-form-label" for="permissions[]">
            Permissions
        </label>
        <div class="col-sm-8">
            <div class="tom-select-custom tom-select-custom-with-tags">
                <select class="js-select form-select" autocomplete="off" multiple name="permissions[]" 
                    data-nue-tom-select-options='{
                        "hideSearch": true,
                        "placeholder": "Select permissions ..."
                    }'>
                    @foreach(config('nue.database.permissions_model')::pluck('name', 'id') as $i => $temp)
                        <option value="{{ $i }}"
                            @isset($edit)
                                {{ in_array($i, $edit->permissions()->pluck('id')->toArray()) ? 'selected' : '' }}
                            @endisset
                        >
                            {{ $temp }}
                        </option>
                    @endforeach>
                </select>
            </div>
            {!! $errors->first('permissions[]', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>

    <div class="mb-5">&nbsp;</div>
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