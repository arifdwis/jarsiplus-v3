@extends('layouts.app')
@section('title', $title)

@section('css')
    <style>
        #datatable {
            width: 100% !important;
        }

        #datatable td,
        #datatable th {
            white-space: normal !important;
            word-break: break-word;
        }

        .dataTables_scrollHead table,
        .dataTables_scrollBody table {
            width: 100% !important;
        }

        .dataTables_scrollBody {
            overflow-x: hidden !important;
        }
    </style>
@endsection

@section('js')
    <script>
        var table = HSCore.components.HSDatatables.init('.js-datatable', {
            scrollY: 'calc(100vh - 250px)',
            scrollX: false,
            autoWidth: false,
            ajax: '{!! request()->fullUrl() !!}?datatable=true',
            columns: [
                { data: 'pilihan', name: 'pilihan', className: 'text-center', orderable: false, searchable: false, width: '30px' },
                { data: 'nama', name: 'nama' },
                { data: 'instansi', name: 'instansi' },
                { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false, width: '50px' }
            ],
            @include('nue::partials.datatable.script')
        });

        // Initialize Bootstrap tooltips after each DataTable draw
        $('.js-datatable').on('draw.dt', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(el) { return new bootstrap.Tooltip(el); });
        });
    </script>
@endsection

@section('content')
    @if($data->count())
        {!! Form::open(['method' => 'DELETE', 'route' => ["$prefix.destroy", 'hapus-all'], 'id' => 'submit-all']) !!}

        @include('layouts.breadcrumb', [
            'lists' => [
                'Dashboard' => 'javascript:;',
                $title => 'active'
            ]
        ])

        @include('layouts.datatable.header', [
            'title' => $title,
            'description' => 'Here is a list of all your data from your database.',
            'create' => route("$prefix.create"),
            'datatable' => true
        ])

        <div class="card card-bordered shadow-none rounded-0">
            <div class="card-body p-0">
                <div class="table-responsive" style="overflow-x: hidden;">
                    <table id="datatable" class="js-datatable align-middle table-bordered table table-sm table-hover table-thead-bordered" style="width:100%;">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:30px;">
                                    <div class="form-check mb-0">
                                        <input id="datatable-checkbox-check" type="checkbox" class="form-check-input">
                                        <label class="form-check-label" for="check-all"></label>
                                    </div>
                                </th>
                                <th style="width:35%;">Nama</th>
                                <th>Instansi / Jabatan</th>
                                <th style="width:50px;">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            @include('layouts.datatable.footer')
        </div>

        {!! Form::close() !!}
    @else

        @include('layouts.breadcrumb', [
            'lists' => [
                'Dashboard' => 'javascript:;',
                $title => 'active'
            ]
        ])
        <div class="content container-fluid">
            @include('layouts.empty')
        </div>

    @endif
@endsection