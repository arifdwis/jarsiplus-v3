<section class="form-1">

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="require-form label" for="nama_instansi" >Nama Instansi</label>
            {!! Form::text('nama_instansi', optional(me()->corporate)->name, ['class' => 'form-control', 'placeholder' => 'Contoh : Dinas Pariwisata', 'required' => 'required']) !!}
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

    <div class="row mt-3 mb-3">
        <div class="col-12 pb-2 d-flex justify-content-center">
            <div class="custom-control custom-switch p-0 p-1">
                <input type="checkbox" class="custom-control-input" id="check-form-1" required>
                <label class="custom-control-label" for="check-form-1"></label>
            </div>
        </div>
        <div class="col-12">
            <small>Dengan menggunakan layanan kami, Anda memercayakan informasi Anda kepada kami. Kami paham bahwa melindungi informasi Anda dan memberikan kontrol kepada Anda adalah tanggung jawab yang besar dan memerlukan kerja keras.</small>
        </div>
    </div>

    <div class="mt-3 mb-1 w-100 d-flex justify-content-end">
        <button type="button" id="next-button" class="btn btn-primary btn-next-form" readonly>
            <ion-icon name="arrow-forward-outline"></ion-icon>
            Selanjutnya
        </button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Initially, disable the "Selanjutnya" button
    $('#next-button').prop('disabled', true);

    // Listen for changes on the checkbox
    $('#check-form-1').change(function() {
        if (this.checked) {
            // If the checkbox is checked, enable the button
            $('#next-button').prop('disabled', false);
        } else {
            // If the checkbox is not checked, disable the button
            $('#next-button').prop('disabled', true);
        }
    });
});
</script>

</section>


