@extends('template::layouts.master')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<section class="page-header">
    <div class="header-light text-center">
        @isset($data)
            @if($data->status == 9)
                <h3 class="title text-white">Permohonan Ditolak</h3>
                <h4 class="subtitle">{{$data->alasan_tolak}}.</h4>
            @endif

            @if($data->status == 1 OR $data->status == 2)
                <h3 class="title text-white">Permohonan Tervalidasi</h3>
                <h4 class="subtitle">Permohonan anda telah tervalidasi silahkan melanjutkan ketahap selanjutnya.</h4>
            @endif

             @if($data->status == 0)
                <h3 class="title text-white">Menunggu Validasi</h3>
                <h4 class="subtitle">Permohonan anda sedang menunggu validasi dari admin kami.</h4>
            @endif
        
        @else
        <h1 class="title">Permohonan</h1>
        <h4 class="subtitle">Permohonan terdiri dari beberapa form.</h4>
        @endisset
    </div>
</section>
<svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
    <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z" fill="#f9f9f9"></path>
</svg>

<div class="section pb-1 pt-2">
    <h3 class="section-title text-uppercase font-weight-bold pb-0" style="line-height: 1.2">Formulir Inovasi Daerah</h3>
    <h5 class="section-subtitle mt-1">Mohon untuk melengkapi semua data untuk Inovasi Daerah</h5>
    {!! Form::model($data, ['route' => ["$prefix.update", $data->uuid], 'autocomplete' => 'off', 'method' => 'PUT']) !!}
    <span style="font-size: .8rem" class="mb-2">
        (<span style="color: #d93659; font-weight: bold;">*</span>) Tidak boleh kosong
    </span>
    <hr>
    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="nama_instansi" >Nama Instansi</label>
           {!! Form::text('nama_instansi', optional($data->pemohon1)->unit_kerja, ['class' => 'form-control', 'placeholder' => 'Contoh : Dinas Pariwisata', 'required' => 'required']) !!}
            {!! $errors->first('nama_instansi', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="id_kota">Kabupaten / Kota</label>
            <select class="form-control custom-select select2 py-2" name="id_kota" id="id_kota" required>
                <option value="null" selected="">-- Pilih Salah Satu --</option>
                @foreach(Modules\Wilayah\Entities\Provinsi::orderBy('name','asc')->get() as $i => $temp)
                
                <optgroup label="{{$temp->name}}">
                    @foreach($temp->citys as $n => $child)
                    @isset($data)
                    <option {{$data->id_kota == $child->id ? 'selected' : ''}} value="{{$child->id}}">{{$child->name}}</option>
                    @else
                    <option {{optional(me()->corporate)->kota_id == $child->id ? 'selected' : ''}} value="{{$child->id}}">{{$child->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
                
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group boxed">
        <div class "input-wrapper">
            <label class="require-form label" for="label" >Judul</label>
            {!! Form::text('label', null, ['class' => 'form-control', 'placeholder' => 'Contoh : Aplikasi Satu Data Satu Inovasi', 'required' => 'required']) !!}
            {!! $errors->first('label', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="urusan_utama">Urusan Pemerintahan</label>
            <select class="form-control custom-select select2 py-2" name="urusan_utama" id="urusan_utama" required>
                <option value="null" selected="">-- Pilih Salah Satu --</option>
                @foreach(Modules\Formulir\Entities\Urusan::pluck('label', 'label') as $label => $temp)
                @isset($data)
                <option {{$data->urusan_utama == $label ? 'selected' : ''}} value="{{$label}}">{{$temp}}</option>
                @else
                <option value="{{$label}}">{{$temp}}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="id_kategori">Kategori Urusan</label>
            <select class="form-control custom-select select2 py-2" name="id_kategori" id="id_kategori" required>
                <option value="null" selected="">-- Pilih Salah Satu --</option>
                @foreach(Modules\Formulir\Entities\Kategori::pluck('label', 'id') as $i => $temp)
                @isset($data)
                <option {{$data->id_kategori == $i ? 'selected' : ''}} value="{{$i}}">{{$temp}}</option>
                @else
                <option value="{{$i}}">{{$temp}}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="urusan_lainnya">Urusan Lainnya Yang Berkaitan</label>
            <select class="form-control custom-select select2 py-2" name="urusan_lainnya" id="urusan_lainnya" required>
                <option value="null" selected="">-- Pilih Salah Satu --</option>
                @foreach(Modules\Formulir\Entities\Urusan::pluck('label', 'label') as $label => $temp)
                @isset($data)
                <option {{$data->urusan_lainnya == $label ? 'selected' : ''}} value="{{$label}}">{{$temp}}</option>
                @else
                <option value="{{$label}}">{{$temp}}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="tahapan">Tahapan Inovasi</label>
            <select class="form-control custom-select select2 py-2" name="tahapan" id="tahapan" required>
                <option value="null" selected="">-- Pilih Salah Satu --</option>
                @foreach([1 => 'Inisiatif', 2 => 'Uji Coba', 3 => 'Penerapan'] as $key => $value)
                @isset($data)
                <option {{ $data->tahapan == $key ? 'selected' : ''}} value="{{ $key }}">{{ $value }}</option>
                @else
                <option value="{{ $key }}">{{ $value }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="inisiator">Inisiator Inovasi Daerah</label>
            <select class="form-control custom-select select2 py-2" name="inisiator" id="inisiator" required>
                <option value="null" selected="">-- Pilih Salah Satu --</option>
                @foreach([1 => 'Kepala Daerah', 2 => 'Anggota DPRD', 3 => 'OPD', 4 => 'ASN', 5 => 'Masyarakat'] as $key => $value)
                @isset($data)
                <option {{ $data->inisiator == $key ? 'selected' : ''}} value="{{ $key }}">{{ $value }}</option>
                @else
                <option value="{{ $key }}">{{ $value }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="jenis">Jenis Inovasi Daerah</label>
            <select class="form-control custom-select select2 py-2" name="jenis" id="jenis" required>
                <option value="null" selected="">-- Pilih Salah Satu --</option>
                @foreach([1 => 'Digital', 2 => 'Non Digital'] as $key => $value)
                @isset($data)
                <option {{ $data->inisiator == $key ? 'selected' : ''}} value="{{ $key }}">{{ $value }}</option>
                @else
                <option value="{{ $key }}">{{ $value }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="rancang_bangun">Rancang Bangun </label>
            <small class="text-muted">(300 Kata)</small>
            {!! Form::textarea('rancang_bangun', null, ['class' => 'form-control', 'placeholder'=>'Masukan Rancang Bangun.', 'required' => 'required']) !!}
            {!! $errors->first('rancang_bangun', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="tujuan_inovasi">Tujuan Inovasi Daerah </label>
            <small class="text-muted">(500 Kata)</small>
            {!! Form::textarea('tujuan_inovasi', null, ['class' => 'form-control', 'placeholder'=>'Masukan Tujuan Inovasi Daerah.', 'required' => 'required']) !!}
            {!! $errors->first('tujuan_inovasi', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class ="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="manfaat_inovasi">Manfaat Inovasi </label>
            <small class="text-muted">(500 Kata)</small>
            {!! Form::textarea('manfaat_inovasi', null, ['class' => 'form-control', 'placeholder'=>'Masukan Manfaat Inovasi.', 'required' => 'required']) !!}
            {!! $errors->first('manfaat_inovasi', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="hasil_inovasi">Hasil Inovasi</label>
            <small class="text-muted">(500 Kata)</small>
            {!! Form::textarea('hasil_inovasi', null, ['class' => 'form-control', 'placeholder'=>'Masukan Hasil Inovasi.', 'required' => 'required']) !!}
            {!! $errors->first('hasil_inovasi', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>
    {!! Form::close() !!}

    @include('template::partials.juri-komentar')
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('js/permohonan.js?v='.env('APP_VERSION'))}}"></script>
<script type="text/javascript">
    $('input').attr('disabled','true');
    $('select').attr('disabled','true');
    $('textarea').attr('disabled','true');
    $('.btn-next-form').removeAttr('disabled');
    $('.custom-switch').hide();
    $('.btn-submit').hide();
</script>
@endsection