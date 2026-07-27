<script>
    var params = '{!! request()->has('_pjax') ? '&' : '?' !!}datatable=true';
    var table = Nue.components.NueDatatables.init('.js-datatable', {
        scrollY: 'calc(100vh - 200px)',
        ajax : '{!! request()->fullUrl() !!}' + params, 
        columns: [
            { data: 'pilihan', name: 'pilihan', className: 'pe-0 bg-light text-center', orderable: false, searchable: false },
            { data: 'key', name: 'key' },
			{ data: 'value', name: 'value' },
            { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false }, 
        ],
        @include('nue::partials.datatable.script')
    });

    @include('nue::partials.datatable.delete', [
        'url' => route("$prefix.index")
    ])
</script>

@include('nue::partials.breadcrumb', ['lists' => [
    __('Nue Extensions') => 'javascript:;', 
    $title => 'active'
]])

@include('nue::partials.toolbar', [
    'create' => route("$prefix.create"), 
    'datatable' => true
])

<div class="card border-0 shadow-none rounded-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="datatable" class="js-datatable table table-sm table-hover table-bordered table-nowrap">
                <thead class="thead-light">
                    <tr>
                        <th class="pe-0" width="1">
                            <div class="form-check mb-0">
                                <input id="datatable-checkbox-check" type="checkbox" class="form-check-input">
                                <label class="form-check-label" for="check-all"></label>
                            </div>
                        </th>
                        <th>{{ __('Key') }}</th>
                        <th>{{ __('Value') }}</th>
						<th width="1">{{ __('Action') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @include('nue::partials.datatable.footer')
</div>
