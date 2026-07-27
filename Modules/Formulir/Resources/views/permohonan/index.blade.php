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

        #datatable th,
        #datatable td {
            vertical-align: middle;
        }

        #datatable th.col-year,
        #datatable td.col-year,
        #datatable th.col-action,
        #datatable td.col-action,
        #datatable th.col-check,
        #datatable td.col-check {
            white-space: nowrap !important;
            word-break: normal;
        }

        .dataTables_scrollHead th.col-year,
        .dataTables_scrollBody td.col-year {
            width: 100px !important;
            min-width: 100px !important;
            max-width: 100px !important;
            text-align: center !important;
        }

        .dataTables_scrollHead th.col-action,
        .dataTables_scrollBody td.col-action {
            width: 100px !important;
            min-width: 100px !important;
            max-width: 100px !important;
            text-align: center !important;
        }

        table.dataTable thead th.sorting, 
        table.dataTable thead th.sorting_asc, 
        table.dataTable thead th.sorting_desc {
            background-position: right 5px center !important;
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
            ajax: '{!! request()->fullUrlWithQuery(["datatable" => "true"]) !!}',
            columns: [
                { data: 'pilihan', name: 'pilihan', className: 'text-center col-check', orderable: false, searchable: false, width: '30px' },
                { data: 'pemohon', name: 'pemohon' },
                { data: 'keperluan', name: 'keperluan' },
                { data: 'tahun', name: 'tahun', className: 'text-center col-year', width: '100px' },
                { data: 'aksi', name: 'aksi', className: 'text-center col-action', orderable: false, searchable: false, width: '100px' }
            ],
            @include('nue::partials.datatable.script')
        });

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
                                <th class="col-check" style="width:30px;">
                                    <div class="form-check mb-0">
                                        <input id="datatable-checkbox-check" type="checkbox" class="form-check-input">
                                        <label class="form-check-label" for="check-all"></label>
                                    </div>
                                </th>
                                <th style="width:40%;">Inovator</th>
                                <th>Nama Inovasi</th>
                                <th class="text-center col-year" style="width:100px;">Tahun</th>
                                <th class="text-center col-action" style="width:100px;">Aksi</th>
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