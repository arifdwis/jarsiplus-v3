@extends('layouts.app')
@section('title', $title)

@section('js')
<script>
    var table = HSCore.components.HSDatatables.init('.js-datatable', {
        scrollY: 'calc(100vh - 250px)',
        ajax : '{!! request()->fullUrl() !!}?datatable=true', 
        columns: [
            { data: 'pilihan', name: 'pilihan', className: 'text-center', orderable: false, searchable: false },
            { data: 'label', name: 'label' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false }
            ],
        @include('nue::partials.datatable.script')
    });
</script>
@endsection

@section('content')
@if($data->count())
{!! Form::open(['method' => 'DELETE', 'route' => ["$prefix.destroy", 'hapus-all'], 'id' => 'submit-all']) !!}

@include('layouts.breadcrumb', ['lists' => [
'Dashboard' => 'javascript:;', 
$title => 'active'
]])

@include('layouts.datatable.header', [
'title' => $title, 
'description' => 'Here is a list of all your data from your database.', 
'create' => route("$prefix.create"), 
'datatable' => true
])

<div class="card card-bordered shadow-none rounded-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="datatable" class="js-datatable align-middle table-bordered table table-sm table-hover table-thead-bordered table-nowrap">
                <thead class="thead-light">
                    <tr>
                        <th class="table-column-pr-0" width="1">
                            <div class="form-check mb-0">
                                <input id="datatable-checkbox-check" type="checkbox" class="form-check-input">
                                <label class="form-check-label" for="check-all"></label>
                            </div>
                        </th>
                        <th>Halaman</th>
                        <th>Status</th>
                        <th width="1">Action</th>
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
$title => 'active'
]])
<div class="content container-fluid">
    @include('layouts.empty')
</div>

@endif
@endsection