@isset($edit)
	<div class="card-body bg-light pb-10" style="min-height:calc(100vh - 163px)">
@else
	<div class="card-body">
@endisset
	<div class="row mb-2">
		<label class="col-sm-3 col-form-label" for="parent_id">
			Parent
		</label>
		<div class="col-sm-9">
			<div class="tom-select-custom tom-select-custom-with-tags">
				<select class="js-select form-select" autocomplete="off" name="parent_id" 
					data-nue-tom-select-options='{
						"hideSearch": true
					}'>
					@foreach($options as $i => $temp)
						<option value="{{ $i }}"
							@isset($edit)
								{{ $i == $edit->parent_id ? 'selected' : '' }}
							@endisset
						>
							{{ $temp }}
						</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>

	<div class="row mb-2">
		<label class="col-sm-3 col-form-label" for="title">
			Title <span class="text-danger">*</span>
		</label>
		<div class="col-sm-9">
			{!! Form::text('title', null, ['class' => 'form-control form-control-sm form-style' . $errors->first('title', ' is-invalid')]) !!}
			{!! $errors->first('title', ' <span class="invalid-feedback">:message</span>') !!}
		</div>
	</div>

	<div class="row mb-2">
		<label class="col-sm-3 col-form-label" for="icon">
			Icon <span class="text-danger">*</span>
		</label>
		<div class="col-sm-9">
			{!! Form::text('icon', null, ['class' => 'form-control form-control-sm form-style' . $errors->first('icon', ' is-invalid'), 'placeholder' => 'eg. icon-park-twotone:save-one']) !!}
			{!! $errors->first('icon', ' <span class="invalid-feedback">:message</span>') !!}
			<span class="small mt-1">
				<span class="iconify" data-icon="fa:info-circle"></span>
				Get the icons from here <a href="https://iconify.design" target="_blank">https://iconify.design</a>
			</span>
		</div>
	</div>

	<div class="row mb-2">
		<label class="col-sm-3 col-form-label" for="uri">
			URI
		</label>
		<div class="col-sm-9">
			<div class="input-group input-group-sm">
				<span class="input-group-text bg-light">{{ env('APP_URL') }}/</span>
				{!! Form::text('uri', null, ['class' => 'form-control form-style']) !!}
			</div>
		</div>
	</div>

	<div class="row mb-2">
		<label class="col-sm-3 col-form-label" for="roles[]">
			Roles
		</label>
		<div class="col-sm-9">
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
		</div>
	</div>

	<div class="row mb-2">
		<label class="col-sm-3 col-form-label" for="permission">
			Permission
		</label>
		<div class="col-sm-9">
			<div class="tom-select-custom tom-select-custom-with-tags">
				<select class="js-select form-select" autocomplete="off" name="permission" 
					data-nue-tom-select-options='{
						"hideSearch": true,
						"placeholder": "Select permission ..."
					}'>
					@foreach(config('nue.database.permissions_model')::pluck('name', 'slug') as $i => $temp)
						<option value="{{ $i }}"
							@isset($edit)
								{{ $i == $edit->permission ? 'selected' : '' }}
							@endisset
						>
							{{ $temp }}
						</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>

	@isset($edit)
		<div class="mb-5">&nbsp;</div>
	@endisset
</div>

@isset($edit)
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
@endisset