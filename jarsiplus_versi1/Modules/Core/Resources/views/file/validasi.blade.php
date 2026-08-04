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
@if($edit->count())

@include('layouts.breadcrumb', ['lists' => [
'Dashboard' => 'javascript:;', 
'Validasi' => 'active'
]])

{!! Form::model($edit, ['route' => ["$prefix.update", $kategori->uuid ,$edit->uuid], 'autocomplete' => 'off', 'method' => 'put', 'files' => true]) !!}
<div class="content container-fluid p-3">
    <div class="row">
        <div class="col-md-8 pe-2">
            <div class="card rounded-1 mb-3">
                <div class="card-header">
                    <h3 class="card-title mb-0">VALIDASI PERMOHONAN</h3>
                </div>
                <div class="card-body">
                    <div class="card card-bordered shadow-none rounded-0">
                      <!-- Section: Timeline -->
                      <section class="py-5" style="padding-left: 5vh;">
                          <ul class="timeline">
                            @foreach ($validasi as $value)
                            <li class="timeline-item mb-5">
                              <h5 class="fw-bold">{{$value->operator->name}} (Pembahas)</h5>
                              <p class="text-muted mb-2 fw-bold">{{tgl_indo($value->created_at)}}</p>
                              <p class="text-muted mb-2 fw-bold">{{\Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->diffForHumans()}}</p>
                              <p class="text-muted">
                                PERMOHONAN DISETUJUI
                            </p>
                        </li>
                        @endforeach
                    </ul>
                        <h5 class="fw-bold">DISETUJUI OLEH {{$validasi->count()}} Pembahas</h5>
                </section>
                <!-- Section: Timeline -->
            </div>
        </div>
    </div>
</div>
<div class="col-md-4 pe-2">
    <div class="card rounded-1 mb-3">
        <div class="card-header">
            <h3 class="card-title mb-0">ACTION</h3>
        </div>
        <div class="card-body">
                       <!-- <div class="row mb-2">
                        <label class="col-sm-3 col-form-label" for="deskripsi_perbaikan">
                            DESKRIPSI PERBAIKAN <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            {!! Form::textarea('deskripsi_perbaikan', null, ['class' => 'form-control form-control-sm form-style' . $errors->first('deskripsi_perbaikan', ' is-invalid')]) !!}
                            {!! $errors->first('deskripsi_perbaikan', ' <span class="invalid-feedback">:message</span>') !!}
                        </div>
                    </div> 
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label" for="title">
                            Komentar <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            {!! Form::textarea('komentar', null, ['class' => 'form-control form-control-sm form-style' . $errors->first('komentar', ' is-invalid')]) !!}
                            {!! $errors->first('komentar', ' <span class="invalid-feedback">:message</span>') !!}
                        </div>
                    </div>  -->
                    @if ($edit->status == 0)
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label" for="status">
                            Status <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            <!-- Select -->
                            <div class="btn-group col-sm-12" role="group" aria-label="Basic radio toggle button group">
                              <input type="radio" class="btn-check" value="1" name="status" id="pSetuju" autocomplete="off">
                              <label class="btn btn-outline-primary" for="pSetuju">Setuju</label>
                          </div>
                      </div>
                </div>
                @else
                <div class="row mb-2">
                        <label class="col-sm-3 col-form-label" for="status">
                            Status <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            <!-- Select -->
                            <div class="btn-group col-sm-12" role="group" aria-label="Basic radio toggle button group">
                             <input type="radio" class="btn-check" value="1" name="status" id="pSetuju" autocomplete="off" disabled>
                              <label class="btn btn-outline-primary" for="pSetuju">Telah Di Setujui</label>
                          </div>
                      </div>
                </div>
                @endif
            </div> 
        </div>
    </div>
</div>
</div>
<div class="position-fixed start-50 bottom-0 translate-middle-x w-100 zi-99 mb-3" style="max-width: 40rem;">
    <div class="card card-sm bg-dark border-dark mx-2">
        <div class="card-body">
            <div class="row justify-content-center justify-content-sm-between">
                <div class="col">
                    <a href="{{ route("$prefix.index", $kategori->uuid) }}" class="btn btn-ghost-light">
                        <span class="iconify" data-icon="heroicons-solid:arrow-left"></span>
                        Back
                    </a>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-3">
                        <button type="reset" class="btn btn-ghost-light">Reset</button>
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
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