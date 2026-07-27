<div class="card-body">
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="key">
            Key <span class="text-danger">*</span>
        </label>
        <div class="col-sm-9">
            {!! Form::text('key', null, ['class' => 'form-control form-style' . $errors->first('key', ' is-invalid')]) !!}
            {!! $errors->first('key', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="value">
            Value <span class="text-danger">*</span>
        </label>
        <div class="col-sm-9">
            {!! Form::textarea('value', null, ['class' => 'form-control form-style' . $errors->first('value', ' is-invalid'), 'rows' => 3]) !!}
            {!! $errors->first('value', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
</div>
<div class="card-footer bg-light border-bottom d-flex p-0">
    <button type="reset" class="btn btn-secondary rounded-0 me-0">{{ __('Reset') }}</button>
    <button type="submit" class="btn btn-success rounded-0">
        <i class="bi bi-save me-1"></i>
        {{ isset($edit) ? __('Save changes') : __('Save') }}
    </button>
</div>
