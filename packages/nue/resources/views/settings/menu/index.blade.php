@extends('layouts.app')
@section('title', $title)

@section('css')
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.css">
	<style>
		.dd-handle {
			height: 40px;
			margin: 5px;
			padding: 10px;
			border: 1px solid #eeeff5;
		}
		.dd-list .dd-list {
			padding-left: 40px;
		}
		.tom-select-custom .ts-control.multi .ts-input>div {
			padding: 0.25rem 0.5rem!important;
		}

		.swal2-modal .swal2-title {
			font-size: 20px;
		}
		.swal2-modal .swal2-buttonswrapper {
			margin-top: 0;
		}
		.swal2-modal .swal2-styled {
			font-size: 15px;
			font-weight: 500;
			margin: 20px 5px;
			padding: 5px 20px;
		}
	</style>
@endsection

@section('js')
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.js"></script>
	<script>
		$(document).ready(function() {
			Nue.components.NueSelect.init('.js-select')

			$('#nestable-menu').on('click', function(e) {
				var target = $(e.target),
				action = target.data('action');
				if (action === 'expand-all') {
					$('#nestable').nestable('expandAll');
				}
				if (action === 'collapse-all') {
					$('#nestable').nestable('collapseAll');
				}
			});

            var updateOutput = function(e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };

            $('#nestable').nestable({group: 1}).on('change', updateOutput);
			updateOutput($('#nestable').data('output', $('#nestable-output')));
        });

		$('.menu-delete').click(function() {
			var id = $(this).data('id');
			swal({
				title: "Are you sure ?",
				type: "warning",
				text: "We will delete this menu permanently.",
				width: "300px", 
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Confirm",
				cancelButtonText: "Cancel",
				allowOutsideClick: false
			}).then(function(data) {
				$.ajax({
					type: 'DELETE',
					url: '{{ route("$prefix.index") }}' + '/' + id,
					data: {
						"id": id,
						"_token": $('meta[name="csrf-token"]').attr('content'),
					},
					success: function(data) {
						if(data == "success") {
							history.go(0);
						} else {
							swal({
								type: 'warning',
								title: 'Galat!',
								width: "300px", 
								html: 'Terjadi kesalahan saat menghapus data. Coba sekali lagi.'
							});
						}
					}
				});
			});
		});
	</script>
@endsection

@section('content')

    @include('nue::partials.breadcrumb', ['lists' => [
        'Settings' => 'javascript:;', 
        $title => 'active'
    ]])

    @include('nue::partials.datatable.header', [
        'title' => $title, 
        'description' => 'Here is a list of all your data from your database.'
    ])

    <div class="content container-fluid p-3">
    	<div class="row">
    		<div class="col-md-7 pe-2">
    			<div class="card rounded-1 mb-3">
    				<div class="card-header">
    					{!! Form::open(['route' => "$prefix.store"]) !!}
                            <div id="nestable-menu" class="btn-group">
								<a class="btn btn-primary btn-sm" data-action="expand-all" title="Expand">
									Expand
								</a>
								<a class="btn btn-primary btn-sm" data-action="collapse-all" title="Collapse">
									Collapse
								</a>
							</div>
							<div class="btn-group">
								<button type="submit" class="btn btn-info btn-sm" title="Save">
									<span class="hidden-xs">&nbsp;Save</span>
								</button>
								<a class="btn btn-white btn-sm" title="Refresh" onclick="return history.go(0)">
									<span class="hidden-xs">&nbsp;Refresh</span>
								</a>
							</div>
                            {!! Form::hidden('order', null, ['id' => 'nestable-output']) !!}
                        {!! Form::close() !!}
    				</div>
    				<div class="card-body">
    					<div class="dd" id="nestable">
							<ol class="dd-list">
								@foreach(config('nue.database.menu_model')::whereParentId(0)->orderBy('order')->get() as $i => $temp)
									<li class="dd-item" data-id="{!! $temp->id !!}">
										<div class="dd-handle d-flex justify-content-between">
											<div>
												<span class="iconify me-1" data-icon="{!! $temp->icon !!}"></span>
												{!! $temp->title !!}
												<span class="text-muted">{!! $temp->uri !!}</span>
											</div>
											<div class="dd-nodrag">
												<a href="{!! route("$prefix.edit", $temp->id) !!}" class="text-success me-1">
													<span class="iconify i-lg" data-icon="icon-park-twotone:edit"></span> 
													Edit
												</a>
												<a href="javascript:void(0);" class="menu-delete text-danger" data-id="{!! $temp->id !!}">
													<span class="iconify i-lg" data-icon="icon-park-twotone:delete-five"></span>
												</a>
											</div>
										</div>
										@if(config('nue.database.menu_model')::where('parent_id', $temp->id)->count())
											<ol class="dd-list">
                                            	@foreach(config('nue.database.menu_model')::where('parent_id', $temp->id)->orderBy('order', 'asc')->get() as $side)
													<li class="dd-item" data-id="{!! $side->id !!}">
														<div class="dd-handle d-flex justify-content-between">
															<div>
																<span class="iconify me-1" data-icon="{!! $side->icon !!}"></span>
																{!! $side->title !!}
																<span class="text-muted">{!! $side->uri !!}</span>
															</div>
															<div class="dd-nodrag">
																<a href="{!! route("$prefix.edit", $side->id) !!}" class="text-success me-1">
																	<span class="iconify i-lg" data-icon="icon-park-twotone:edit"></span> 
																	Edit
																</a>
																<a href="javascript:void(0);" class="menu-delete text-danger" data-id="{!! $side->id !!}">
																	<span class="iconify i-lg" data-icon="icon-park-twotone:delete-five"></span>
																</a>
															</div>
														</div>
													</li>
												@endforeach
											</ol>
										@endif
									</li>
								@endforeach
							</ol>
						</div>
    				</div>
    			</div>
    		</div>
    		<div class="col-md-5 ps-2">
    			{!! Form::open(['route' => "$prefix.store"]) !!}
	    			<div class="card rounded-1">
	    				<div class="card-header with-border">
	    					<h3 class="card-title mb-0">New</h3>
	    				</div>
						@include("$view.form")
						<div class="card-footer p-3">
							<div class="d-flex justify-content-end">
								<button type="reset" class="btn btn-sm btn-warning me-2">Reset</button>
								<button type="submit" class="btn btn-sm btn-info">Submit</button>
							</div>
						</div>
					</div>
					{!! Form::hidden('purpose', 'add') !!}
    			{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection