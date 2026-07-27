<div class="row justify-content-md-between align-items-md-center mb-10">
	<div class="col-md-6 col-xl-5">
		<div class="mb-4">
			<h1 class="display-3 mb-3">
				{{$title}} 
			</h1>
			<h2 class="display-4 mb-2">{{$title}} Belum Tersedia.</h2>
			<p class="lead">
				Mari membuat pengalaman pertama Anda.
			</p>

		</div>

		@if(me()->roles->first()->id != 5) {
			<div class="d-flex flex-wrap gap-2">
				@isset($create)
				<a href="{{$create}}" type="button" class="btn btn-dark">Tambah Data</a>
				@else
				<a href="{{route("$prefix.create", $kategori->uuid)}}" type="button" class="btn btn-dark">Tambah Data</a>
				@endisset
			</div>
		}
		@else

		@endif
	</div>

	<div class="col-md-6 col-xl-6">
		<img class="img-fluid" src="https://cdn.btekno.id/templates/v2/svg/illustrations/oc-project-development.svg" alt="" data-nue-theme-appearance="default">
	</div>
</div>