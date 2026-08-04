@extends('layouts.app')
@section('title', $title)

@section('js')
@endsection

@section('css')
<style type="text/css">
.timeline {
  border-left: 1px solid hsl(0, 0%, 90%);
  position: relative;
  list-style: none;
}

.timeline .timeline-item {
  position: relative;
}

.timeline .timeline-item:after {
  position: absolute;
  display: block;
  top: 0;
}

.timeline .timeline-item:after {
  background-color: hsl(0, 0%, 90%);
  left: -38px;
  border-radius: 50%;
  height: 11px;
  width: 11px;
  content: "";
}
}

</style>
@endsection

@section('content')
@if($data->count())

@include('layouts.breadcrumb', ['lists' => [
'Dashboard' => 'javascript:;', 
'Pembahasan' => 'active'
]])

@include('layouts.datatable.header', [
'title' => 'Pembahasan', 
'description' => 'Here is a list of all your data from your database.', 
'create' => route("$prefix.create", $kategori->uuid), 
'datatable' => true
])

<div class="card card-bordered shadow-none rounded-0">
  <!-- Section: Timeline -->
<section class="py-5" style="padding-left: 5vh;">
  <ul class="timeline">
    @foreach ($data as $value)
    <li class="timeline-item mb-5">
      <h5 class="fw-bold">{{$value->operator->name}}</h5>
      <p class="text-muted mb-2 fw-bold">{{tgl_indo($value->created_at)}}</p>
      <p class="text-muted mb-2 fw-bold">{{\Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->diffForHumans()}}</p>
        {{$value->file}}
      <p class="text-muted">
        {{$value->komentar}}
      </p>
    </li>
    @endforeach
  </ul>
</section>
<!-- Section: Timeline -->
</div>

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