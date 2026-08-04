@extends('layouts.app')
@section('title', 'Penawaran')

@section('css')
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.0/lity.min.css">
@endsection

@section('js')
<script>
    var table = HSCore.components.HSDatatables.init('.js-datatable', {
        scrollY: 'calc(100vh - 250px)',
        ajax : '{!! request()->fullUrl() !!}?datatable=true', 
        columns: [
            { data: 'pilihan', name: 'pilihan', className: 'text-center', orderable: false, searchable: false },
            { data: 'indikator', name: 'indikator'},
            { data: 'status', name: 'status',className: 'text-center'},
            { data: 'file', name: 'file',className: 'text-center'},
            { data: 'validasi', name: 'validasi' ,className: 'text-center'}
            ],
        @include('nue::partials.datatable.script')
    });
</script>
@endsection

@section('content')
@if($data->count())
{!! Form::open(['method' => 'DELETE', 'route' => ["$prefix.destroy", $kategori->uuid, 'hapus-all'], 'id' => 'submit-all']) !!}

@include('layouts.breadcrumb', ['lists' => [
'Dashboard' => 'javascript:;', 
'Penawaran' => 'active'
]])

@include('layouts.datatable.header', [
'title' => 'File Data Dukung', 
'description' => 'Here is a list of all your data from your database.', 
'create' => route("$prefix.create", $kategori->uuid), 
'datatable' => true
])

<div class="card card-bordered shadow-none rounded-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="datatable" class="js-datatable align-middle table-bordered table table-sm table-hover table-thead-bordered table-nowrap">
                <thead class="thead-light">
                    <tr>
                        <th class="table-column-pr-0" width="5%">
                            <div class="form-check mb-0">
                                <input id="datatable-checkbox-check" type="checkbox" class="form-check-input">
                                <label class="form-check-label" for="check-all"></label>
                            </div>
                        </th>
                        <th width="35%">Informasi</th>
                        <th width="15%">Status</th>
                        <th width="15%">File</th>
                        <th width="30%">Validasi</th>   
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @include('layouts.datatable.footer')
</div>

{!! Form::close() !!}
@else

@include('layouts.breadcrumb', ['lists' => [
'Dashboard' => 'javascript:;', 
'Penawaran' => 'active'
]])
<div class="content container-fluid">
    @include('layouts.empties')
</div>

@endif
@endsection