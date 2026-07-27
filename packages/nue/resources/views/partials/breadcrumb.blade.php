@isset($lists)
	<nav aria-label="breadcrumb" class="p-2 border-bottom bg-white">
		<ol class="breadcrumb breadcrumb-no-gutter small mb-0">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/">
					<i class="iconify" data-icon="icon-park-twotone:dashboard-one"></i>
				</a>
			</li>
			@foreach($lists as $label => $link)
				@if($loop->last)
					<li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
				@else
					<li class="breadcrumb-item">
						<a class="breadcrumb-link" href="{{ $link }}">{!! $label !!}</a>
					</li>
				@endif
			@endforeach
		</ol>
	</nav>
@endisset