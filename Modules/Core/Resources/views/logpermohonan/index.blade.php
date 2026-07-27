@extends('layouts.app')
@section('title', 'LOG PERMOHONAN')

@section('js')
    <script>
        var table = HSCore.components.HSDatatables.init('.js-datatable', {
            scrollY: 'calc(100vh - 250px)',
            ajax : '{!! request()->fullUrlWithQuery(["datatable" => "true"]) !!}', 
            columns: [
                { data: 'pilihan', name: 'pilihan', className: 'text-center', orderable: false, searchable: false },
                { data: 'id', name: 'id', className: 'text-center' },
                { data: 'user', name: 'user', className: 'small', orderable: false, searchable: false },
                { data: 'deskripsi', name: 'deskripsi', className: 'small', orderable: false, searchable: false },
                { data: 'created_at', name: 'created_at', className: 'text-end', orderable: false, searchable: false }
            ],
            @include('nue::partials.datatable.script')
        });
    </script>
@endsection

@section('content')

    {!! Form::open(['method' => 'DELETE', 'route' => ["$prefix.destroy", 'hapus-all'], 'id' => 'submit-all']) !!}

        @include('nue::partials.breadcrumb', ['lists' => [
            'Settings' => 'javascript:;', 
            $title => 'active'
        ]])

        @include('nue::partials.datatable.header', [
            'title' => 'LOG PERMOHONAN', 
            'description' => 'Here is a list of all your data from your database.', 
            'datatable' => true
        ])

    	<div class="card card-bordered shadow-none rounded-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatable" class="js-datatable table table-sm table-hover table-thead-bordered table-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th class="table-column-pr-0" width="1">
                                    <div class="form-check mb-0">
                                        <input id="datatable-checkbox-check" type="checkbox" class="form-check-input">
                                        <label class="form-check-label" for="check-all"></label>
                                    </div>
                                </th>
                                <th width="1">ID</th>
                                <th>User</th>
                                <th>Pesan</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            @include('nue::partials.datatable.footer')
        </div>

    {!! Form::close() !!}

@endsection