 @extends('layouts.app')
@section('title', "Create :: $title")

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
@endsection

@section('content')

@include('nue::partials.breadcrumb', ['lists' => [
'Settings' => 'javascript:;', 
$title => route("$prefix.index"), 
'Create' => 'active'
]])

{!! Form::model($edit, ['route' => ["$prefix.update", $edit->uuid], 'autocomplete' => 'off', 'files' => true, 'method' => 'PUT']) !!}
<div class="card rounded-0 shadow-0 border-top-0">
    <div class="card-header rounded-0 bg-white p-2">
        <h2 class="page-header-title mb-0">
            Ubah {{ $title }}
        </h2>
        <p class="mb-0">Just complete these forms to create a new one.</p>
    </div>
    @include("$view.form")
</div>
{!! Form::close() !!}

@endsection