<div class="card-body bg-light pb-10" style="min-height:calc(100vh - 163px)">
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="slug">
            Slug <span class="text-danger">*</span>
        </label>
        <div class="col-sm-9">
            {!! Form::text('slug', null, ['class' => 'form-control form-style' . $errors->first('slug', ' is-invalid'), 'placeholder' => 'Input Slug']) !!}
            {!! $errors->first('slug', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="name">
            Name <span class="text-danger">*</span>
        </label>
        <div class="col-sm-9">
            {!! Form::text('name', null, ['class' => 'form-control form-style' . $errors->first('name', ' is-invalid'), 'placeholder' => 'Input Name']) !!}
            {!! $errors->first('name', ' <span class="invalid-feedback">:message</span>') !!}
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="http_method[]">
            HTTP method
        </label>
        <div class="col-sm-9">
            <div class="tom-select-custom tom-select-custom-with-tags mb-1">
                <select class="js-select form-select form-style" name="http_method[]" autocomplete="off" multiple
                    data-nue-tom-select-options='{
                        "placeholder": "HTTP method",
                        "hideSearch": true
                    }'>
                    <option value="">HTTP method</option>
                    @foreach($options as $temp)
                        <option value="{{ $temp }}"
                            @isset($edit)
                                @if($edit->http_method)
                                    {{ in_array($temp, $edit->http_method) ? 'selected' : '' }}
                                @endif
                            @endisset
                        >{{ $temp }}</option>
                    @endforeach
                </select>
            </div>
            <span class="form-text ms-1">
                <span class="iconify" data-icon="fa:info-circle"></span>
                All methods if empty
            </span>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="http_path">
            HTTP path
        </label>
        <div class="col-sm-9">
            {!! Form::textarea('http_path', null, ['class' => 'form-control form-style', 'placeholder' => 'Input HTTP path', 'rows' => 3]) !!}
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