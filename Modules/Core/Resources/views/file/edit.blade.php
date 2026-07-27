@extends('layouts.app')
@section('title', "Create :: $title")

@section('css')

@endsection

@section('js')
@include('core::layouts.components.tinymce')
@endsection

@section('content')

@include('nue::partials.breadcrumb', ['lists' => [
'JARSIPLUS' => 'javascript:;', 
$title => route("$prefix.index", $kategori->uuid), 
'Create' => 'active'
]])

{!! Form::model($edit, ['route' => ["$prefix.update", $kategori->uuid ,$edit->uuid], 'autocomplete' => 'off', 'method' => 'put', 'files' => true]) !!}
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