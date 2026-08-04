<div class="form-3 d-none">
    <div class="form-head">
        <h4 class="font-weight-bold">PERWALI Kota Samarinda Nomor 22 Tahun 2020</h4>
    </div>
    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="rancang_bangun">Rancang Bangun </label>
            <small class="text-muted">(300 Kata)</small>

            {!! Form::textarea('rancang_bangun', null, ['class' => 'form-control', 'placeholder'=>'Masukan Rancang Bangun.']) !!}
            {!! $errors->first('rancang_bangun', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="tujuan_inovasi">Tujuan Inovasi Daerah </label>
            <small class="text-muted"></small>

            {!! Form::textarea('tujuan_inovasi', null, ['class' => 'form-control', 'placeholder'=>'Masukan Tujuan Inovasi Daerah.']) !!}
            {!! $errors->first('tujuan_inovasi', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="manfaat_inovasi">Manfaat Inovasi </label>
            <small class="text-muted"></small>

            {!! Form::textarea('manfaat_inovasi', null, ['class' => 'form-control', 'placeholder'=>'Masukan Manfaat Inovasi.']) !!}
            {!! $errors->first('manfaat_inovasi', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="hasil_inovasi">Hasil Inovasi</label>
            <small class="text-muted"></small>

            {!! Form::textarea('hasil_inovasi', null, ['class' => 'form-control', 'placeholder'=>'Masukan Hasil Inovasi.']) !!}
            {!! $errors->first('hasil_inovasi', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="anggaran">Anggaran</label>
            {!! Form::file('anggaran', null, ['class' => 'form-control' ]) !!}
            @if(isset($data) && $data->anggaran)
            <div class="mt-2">
                <strong>File yang sudah diunggah:</strong> 
                <a href="{{ asset($data->anggaran) }}" target="_blank">File Anggaran Ada</a>
            </div>
            @endif
            {!! $errors->first('anggaran', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>

    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label require-form" for="profil_bisnis">Proposal Inovasi</label>
            {!! Form::file('profil_bisnis', null, ['class' => 'form-control']) !!}
            @if(isset($data) && $data->profil_bisnis)
            <div class="mt-2">
                <strong>File yang sudah diunggah:</strong> 
                <a href="{{ asset($data->profil_bisnis) }}" target="_blank">File Anggaran Ada</a>
            </div>

            @endif
            {!! $errors->first('profil_bisnis', '<span class="text-muted"><small>:message</small></span>') !!}
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>


    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label">Dengan ini saya menyatakan bahwa : </label>
            <ol type="a" style="font-size: .8rem">
                <li style="line-height: 1.2" class="mb-1">Menyampaikan informasi dan data diri yang benar.</li>
                <li style="line-height: 1.2" class="mb-1">Tunduk pada keputusan Pemerintah Kota Samarinda atas pengajuan registrasi layanan fasilitas kerjasama daerah Pemerintah Kota Samarinda.</li>
                <li style="line-height: 1.2" class="mb-1">Menggunakan layanan yang tersedia dengan penuh tanggung jawab sesuai kewenangan yang diberikan.</li>
                <li style="line-height: 1.2" class="mb-1">Menaati kebijakan kerja sama daerah yang berlaku di Pemerintah Kota Samarinda.</li>
            </ol>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col-12 pb-2 d-flex justify-content-center">
            <div class="custom-control custom-switch p-0 p-1">
                <input type="checkbox" class="custom-control-input" id="check-form-3">
                <label class="custom-control-label" for="check-form-3"></label>
            </div>
        </div>
        <div class="col-12">
            <small>Dengan menggunakan layanan kami, Anda memercayakan informasi Anda kepada kami. Kami paham bahwa melindungi informasi Anda dan memberikan kontrol kepada Anda adalah tanggung jawab yang besar dan memerlukan kerja keras.</small>
        </div>
    </div>

    <div class="mt-3 mb-1 w-100 d-flex justify-content-between">
        <button type="button" class="btn btn-outline-primary btn-prev-form"><ion-icon name="arrow-back-outline"></ion-icon>  Sebelumnya</button>
        <button type="submit" class="btn btn-dark btn-submit btn-next-form" disabled='true' name="submit-form"><ion-icon name="send-outline"></ion-icon> Submit Data</button>
    </div>
</div>