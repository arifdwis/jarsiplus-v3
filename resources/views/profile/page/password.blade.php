{!! Form::model(me(), ['method' => 'PUT', 'files' => true]) !!}
    <div id="passwordSection" class="card">
        <div class="card-header">
            <h3 class="card-title mb-1">{{ __('Update Password') }}</h3>
            <p class="text-muted d-block mb-0">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label for="old_password" class="col-sm-3 col-form-label form-label">
                    Current Password <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <div class="input-group input-group-merge {{ $errors->first('old_password', ' is-invalid') }}" data-hs-validation-validate-class>
                        <input type="password" class="js-toggle-password form-control" name="old_password" placeholder="{{ __('Enter your current password') }}" aria-label="{{ __('Enter your current password') }}"
                        data-hs-toggle-password-options='{
                            "target": "#old-target",
                            "defaultClass": "bi-eye-slash",
                            "showClass": "bi-eye",
                            "classChangeTarget": "#old-icon"
                        }'>
                        <a id="old-target" class="input-group-append input-group-text" href="javascript:;">
                            <i id="old-icon" class="bi-eye"></i>
                        </a>
                    </div>
                    <x-nue::error for="old_password" class="mt-1" />
                </div>
            </div>
            <div class="row mb-3">
                <label for="new_password" class="col-sm-3 col-form-label form-label">
                    New Password <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <div class="input-group input-group-merge {{ $errors->first('new_password', ' is-invalid') }}" data-hs-validation-validate-class>
                        <input type="password" class="js-toggle-password form-control" name="new_password" placeholder="{{ __('Enter your new password') }}" aria-label="{{ __('Enter your new password') }}"
                        data-hs-toggle-password-options='{
                            "target": "#new-target",
                            "defaultClass": "bi-eye-slash",
                            "showClass": "bi-eye",
                            "classChangeTarget": "#new-icon"
                        }'>
                        <a id="new-target" class="input-group-append input-group-text" href="javascript:;">
                            <i id="new-icon" class="bi-eye"></i>
                        </a>
                    </div>
                    <x-nue::error for="new_password" class="mt-1" />
                </div>
            </div>
            <div class="row mb-3">
                <label for="new_password_confirmation" class="col-sm-3 col-form-label form-label">
                    Confirm New Password <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <div class="mb-3">
                        <div class="input-group input-group-merge {{ $errors->first('new_password_confirmation', ' is-invalid') }}" data-hs-validation-validate-class>
                            <input type="password" class="js-toggle-password form-control" name="new_password_confirmation" placeholder="{{ __('Confirm your new password') }}" aria-label="{{ __('Confirm your new password') }}"
                            data-hs-toggle-password-options='{
                                "target": "#confirm-target",
                                "defaultClass": "bi-eye-slash",
                                "showClass": "bi-eye",
                                "classChangeTarget": "#confirm-icon"
                            }'>
                            <a id="confirm-target" class="input-group-append input-group-text" href="javascript:;">
                                <i id="confirm-icon" class="bi-eye"></i>
                            </a>
                        </div>
                        <x-nue::error for="new_password_confirmation" class="mt-1" />
                    </div>
                    <h5>{{ __('Password requirements:') }}</h5>
                    <p class="fs-6 mb-2">{{ __('Ensure that these requirements are met:') }}</p>
                    <ul class="fs-6">
                        <li>{{ __('Minimum 8 characters long - the more, the better') }}</li>
                        <li>{{ __('At least one lowercase character') }}</li>
                        <li>{{ __('At least one uppercase character') }}</li>
                        <li>{{ __('At least one number, symbol, or whitespace character') }}</li>
                    </ul>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    {{ __('Save Changes') }}
                </button>
            </div>
        </div>
    </div>
    {!! Form::hidden('page', 'password') !!}
{!! Form::close() !!}