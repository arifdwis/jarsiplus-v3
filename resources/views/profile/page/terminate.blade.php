<div id="deleteAccountSection" class="card">
    <div class="card-header">
        <h3 class="card-title mb-1">{{ __('Delete Account') }}</h3>
        <p class="text-muted d-block mb-0">
            {{ __('Permanently delete your account.') }}
        </p>
    </div>
    {!! $errors->first('password', '<div class="alert alert-danger rounded-0">:message</div>') !!}
    <div class="card-body">
        <p class="card-text">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
        <div class="d-flex mt-5">
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete">
                {{ __('Delete Account') }}
            </button>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        {!! Form::open(['class' => 'modal-content', 'method' => 'DELETE']) !!}
            <div class="modal-body">
                <h3 class="mb-3">{{ __('Delete Account') }}</h3>
                <p>{{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>
                <div class="mb-3">
                    <label for="password" class="form-label fw-semi-bold text-muted">
                        {{ __('Current Password') }} <span class="text-danger">*</span>
                    </label>
                    <div class="input-group input-group-merge" data-hs-validation-validate-class>
                        <input type="password" class="js-toggle-password form-control" name="password" placeholder="{{ __('Enter your current password') }}" aria-label="{{ __('Enter your current password') }}" required
                        data-hs-toggle-password-options='{
                            "target": "#password-target",
                            "defaultClass": "bi-eye-slash",
                            "showClass": "bi-eye",
                            "classChangeTarget": "#password-icon"
                        }'>
                        <a id="password-target" class="input-group-append input-group-text" href="javascript:;">
                            <i id="password-icon" class="bi-eye"></i>
                        </a>
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="agree" required>
                    <label class="form-check-label" for="agree">
                        {{ __('Confirm that I want to delete my account.') }}
                    </label>
                </div>
            </div>
            <div class="modal-footer bg-light p-3">
                <button type="button" class="btn btn-sm btn-white" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete Account') }}</button>
            </div>
            {!! Form::hidden('page', 'terminate') !!}
        {!! Form::close() !!}
    </div>
</div>