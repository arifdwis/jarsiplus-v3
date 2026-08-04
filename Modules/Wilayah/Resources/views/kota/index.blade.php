@extends('layouts.app')
@section('title', $title)

@section('js')
<script>
    var table = HSCore.components.HSDatatables.init('.js-datatable', {
        scrollY: 'calc(100vh - 280px)',
        ajax : '{!! request()->fullUrl() !!}?datatable=true', 
        columns: [
            { data: 'id', name: 'id', className: 'text-center', width: '50px' },
            { data: 'name', name: 'name' }
        ],
        @include('nue::partials.datatable.script')
    });
</script>
@endsection

@section('content')
<div class="content container-fluid">

    @include('nue::partials.breadcrumb', [
        'title' => $title,
        'lists' => [
            'Dashboard' => '/',
            $title => 'active'
        ]
    ])

    @if($data->count())
        {!! Form::open(['method' => 'DELETE', 'route' => ["$prefix.destroy", 'hapus-all'], 'id' => 'submit-all']) !!}

            @include('nue::partials.datatable.header', [
                'title' => 'Data ' . $title, 
                'description' => 'Kelola daftar data ' . strtolower($title) . ' dalam sistem.', 
                'datatable' => true
            ])

            <div class="card card-bordered shadow-none rounded-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="datatable" class="js-datatable align-middle table table-sm table-hover table-thead-bordered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="60" class="text-center">ID</th>
                                    <th>Nama Kota / Kabupaten</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                @include('nue::partials.datatable.footer')
            </div>

        {!! Form::close() !!}
    @else
        @include('layouts.empty')
    @endif

</div>
@endsection