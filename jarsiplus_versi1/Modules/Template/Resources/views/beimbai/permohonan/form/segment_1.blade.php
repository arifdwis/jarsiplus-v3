 <section class="form-1">

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="nama_instansi" >Nama Instansi</label>
            {!! Form::text('nama_instansi', optional(me()->corporate)->name, ['class' => 'form-control', 'placeholder' => 'Contoh : Dinas Pariwisata']) !!}
            {!! $errors->first('nama_instansi', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="id_kota">Kabupaten / Kota</label>
            <select class="form-control custom-select select2 py-2" name="id_kota" id="id_kota">
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
        <div class="input-wrapper">
            <label class="require-form label" for="label" >Judul</label>
            {!! Form::text('label', null, ['class' => 'form-control', 'placeholder' => 'Contoh : Kerja Sama Pengadaan Barang Dan Jasa Melalui Layanan Elektronik (LPSE) Kota Samarinda']) !!}
            {!! $errors->first('label', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>


    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="urusan_utama">Urusan Pemerintahan</label>
            <select class="form-control custom-select select2 py-2" name="urusan_utama" id="urusan_utama">
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
            <select class="form-control custom-select select2 py-2" name="id_kategori" id="id_kategori">
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
            <select class="form-control custom-select select2 py-2" name="urusan_lainnya" id="urusan_lainnya">
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
            <select class="form-control custom-select select2 py-2" name="tahapan" id="tahapan">
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
            <select class="form-control custom-select select2 py-2" name="inisiator" id="inisiator">
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
            <select class="form-control custom-select select2 py-2" name="jenis" id="jenis">
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



    {{--<div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="kode_pos">Kode Pos</label>
            {!! Form::tel('kode_pos', optional(me()->corporate)->postal_code, ['class' => 'form-control ', 'placeholder' => 'Contoh : 7712xx']) !!}
            {!! $errors->first('kode_pos', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="alamat">Alamat Instansi / Perusahaan / Lembaga</label>
            {!! Form::textarea('alamat', optional(me()->corporate)->address, ['class' => 'form-control   ', 'placeholder' => 'Contoh : Jl. Kusuma Bangsa No.66, Samarinda', 'rows' => 3]) !!}
            {!! $errors->first('alamat', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="telepon">Telp Instansi / Perusahaan / Lembaga</label>
            {!! Form::tel('telepon', optional(me()->corporate)->phone, ['class' => 'form-control', 'placeholder' => 'Contoh : 081259xxxx']) !!}
            {!! $errors->first('telepon', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="email">Email Instansi / Perusahaan / Lembaga</label>
            {!! Form::email('email', optional(me()->corporate)->email, ['class' => 'form-control   ', 'placeholder' => 'Contoh : anonymous@gmail.com']) !!}
            {!! $errors->first('email', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label" for="website">Website Instansi / Perusahaan / Lembaga</label>
            {!! Form::text('website', optional(me()->corporate)->website, ['class' => 'form-control  ', 'placeholder' => 'Contoh : https://diskominfo.samarindakot.go.id']) !!}
            {!! $errors->first('website', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>
    --}}
    <div class="row mt-3 mb-3">
        <div class="col-12 pb-2 d-flex justify-content-center">
            <div class="custom-control custom-switch p-0 p-1">
                <input type="checkbox" class="custom-control-input" id="check-form-1">
                <label class="custom-control-label" for="check-form-1"></label>
            </div>
        </div>
        <div class="col-12">
            <small>Dengan menggunakan layanan kami, Anda memercayakan informasi Anda kepada kami. Kami paham bahwa melindungi informasi Anda dan memberikan kontrol kepada Anda adalah tanggung jawab yang besar dan memerlukan kerja keras.</small>
        </div>
    </div>

    <div class="mt-3 mb-1 w-100 d-flex justify-content-end">
        <button type="button" class="btn btn-primary btn-next-form" readonly>
            <ion-icon name="arrow-forward-outline"></ion-icon>
            Selanjutnya 
        </button>
    </div>

</section>