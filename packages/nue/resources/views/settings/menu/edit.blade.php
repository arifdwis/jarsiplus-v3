@extends('layouts.app')
@section('title', "Edit :: $title")

@section('css')
@endsection

@section('js')
    <script>
        Nue.components.NueSelect.init('.js-select')
    </script>
@endsection

@section('content')
    
    @include('nue::partials.breadcrumb', ['lists' => [
        'Settings' => 'javascript:;', 
        $title => route("$prefix.index"), 
        'Edit' => 'active'
    ]])

    {!! Form::model($edit, ['route' => ["$prefix.update", $edit->id], 'method' => 'PUT']) !!}
        <div class="card rounded-0 shadow-0 border-top-0">
            <div class="card-header rounded-0 bg-white p-2">
                <h2 class="page-header-title mb-0">
                    Edit {{ $title }}
                </h2>
                <p class="mb-0">Please make changes according to your needs.</p>
            </div>
            @include("$view.form")
        </div>
    {!! Form::close() !!}

@endsection