<div class="row justify-content-md-between align-items-md-center mb-5">
	<div class="col-md-6 col-xl-5">
		<div class="mb-4">
			<h1 class="display-4 mb-2">
				{{ $title ?? 'Data' }} 
			</h1>
			<h3 class="text-muted mb-2">Sepertinya Anda belum memiliki {{ $title ?? 'Data' }}.</h3>
			<p class="lead text-secondary">
				Mari membuat pengalaman pertama Anda.
			</p>
		</div>

		@if(function_exists('me') && me() && me()->roles && me()->roles->first() && me()->roles->first()->id != 5)
			<div class="d-flex flex-wrap gap-2">
				@isset($create)
					<a href="{{ $create }}" type="button" class="btn btn-primary">Tambah Data</a>
				@elseif(isset($prefix) && isset($kategori) && isset($kategori->uuid))
					<a href="{{ route("$prefix.create", $kategori->uuid) }}" type="button" class="btn btn-primary">Tambah Data</a>
				@elseif(isset($prefix))
					<a href="{{ route("$prefix.create") }}" type="button" class="btn btn-primary">Tambah Data</a>
				@endisset
			</div>
		@endif
	</div>

	<div class="col-md-6 col-xl-6 text-center">
		<img class="img-fluid" style="max-height: 280px;" src="{{ asset('img/logo.svg') }}" alt="JarSi+ Samarinda">
	</div>
</div>