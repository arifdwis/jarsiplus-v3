@extends('layouts.app')
@section('title', "Create :: $title")

@section('css')

@endsection

@section('js')
<script>
  (function() {
    // INITIALIZATION OF FILE ATTACH
    // =======================================================
    new NueFileAttach('.js-file-attach')
  });
</script>
@endsection

@section('content')

@include('nue::partials.breadcrumb', ['lists' => [
'Settings' => 'javascript:;', 
$title => route("$prefix.index"), 
'Create' => 'active'
]])

{!! Form::open(['route' => ["$prefix.store"], 'autocomplete' => 'off', 'files' => true]) !!}
<div class="card rounded-0 shadow-0 border-top-0">
    <div class="card-header rounded-0 bg-white p-2">
        <h2 class="page-header-title mb-0">
            Tambah {{ $title }}
        </h2>
        <p class="mb-0">Just complete these forms to create a new one.</p>
    </div>
    @include("$view.form")
</div>
{!! Form::close() !!}

@endsection