<div class="card-body bg-light pb-10" style="min-height:calc(100vh - 163px)">
    <div class="content container-fluid p-3">
        <div class="row">
            <div class="col-md-8 pe-2">
                <div class="card rounded-1 mb-3">
                    <div class="card-header">
                        <h3 class="card-title mb-0">PENGAJUAN PERMOHONAN</h3>
                    </div>
                    <div class="card-body">
                        <table>
                            <tbody>
                                <tr>
                                    <th style="padding-bottom: 1em;">DATA PERMOHONAN</th>
                                </tr>
                                <tr>
                                    <td>NAMA INSTANSI</td>
                                    <td>&emsp;:&emsp;</td>
                                    <td style="text-transform: uppercase;"> {{$edit->permohonans->nama_instansi}}</td>
                                </tr>
                                <tr>
                                    <td>JUDUL PERMOHONAN</td>
                                    <td>&emsp;:&emsp;</td>
                                    <td style="text-transform: uppercase;"> {{$edit->permohonans->label}} </td>
                                </tr>
                                <tr>
                                    <td>PPKSD-1</td>
                                    <td>&emsp;:&emsp;</td>
                                    <td style="text-transform: uppercase;"> {{$edit->permohonans->pemohon1->name}} </td>
                                </tr>
                                <tr>
                                    <td>PPKSD-2</td>
                                    <td>&emsp;:&emsp;</td>
                                    <td style="text-transform: uppercase;"> {{$edit->permohonans->pemohon2->name}} </td>
                                </tr>
                                <tr>
                                    <td>TANGGAL</td>
                                    <td>&emsp;:&emsp;</td>
                                    <td style="text-transform: uppercase;"> {{$edit->tanggal}} </td>
                                </tr>
                            </tbody>
                        </table>
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
                            {!! Form::textarea('deskripsi_perbaikan', null, ['class' => 'form-control form-control-sm' . $errors->first('deskripsi_perbaikan', ' is-invalid')]) !!}
                            {!! $errors->first('deskripsi_perbaikan', ' <span class="invalid-feedback">:message</span>') !!}
                        </div>
                    </div> 
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label" for="title">
                            Komentar <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            {!! Form::textarea('komentar', null, ['class' => 'form-control form-control-sm' . $errors->first('komentar', ' is-invalid')]) !!}
                            {!! $errors->first('komentar', ' <span class="invalid-feedback">:message</span>') !!}
                        </div>
                    </div>  -->
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label" for="status">
                            Status <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-12">
                            <!-- Select -->
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                              <input type="radio" class="btn-check" value="Disetujui" name="status" id="pSetuju" autocomplete="off">
                              <label class="btn btn-outline-primary" for="pSetuju">Setuju</label>
                              <input type="radio" class="btn-check" value ="Mohon Diatur Ulang" name="status" id="pTolak" autocomplete="off">
                              <label class="btn btn-outline-primary" for="pTolak">Atur Ulang</label>
                          </div>
                      </div>
              </div>
          </div> 
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