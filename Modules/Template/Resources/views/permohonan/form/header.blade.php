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
    <div class="section">
        <div class="row">
            <div class="col-4 px-1">
                <div class="form-mark-1 text-white rounded d-flex flex-wrap w-100 p-1 active">
                    <div class="font-weight-bold bg-light rounded w-100 pt-3 pb-3 d-flex justify-content-center f-number">
                        1
                    </div>
                    <div class="text-white rounded">
                        <div class="label">
                            Permohonan
                        </div>
                        <div class="description">
                            Data Permohonan JARSIPLUS
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 px-1">
                <div class="form-mark-2 text-white rounded d-flex flex-wrap w-100 p-1">
                    <div class="font-weight-bold bg-light rounded w-100 pt-3 pb-3 d-flex justify-content-center f-number">
                        2
                    </div>
                    <div class="text-white rounded">
                        <div class="label">
                           Petugas
                        </div>
                        <div class="description">
                            Data Petugas Penginput JARSIPLUS
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 px-1">
                <div class="form-mark-3 text-white rounded d-flex flex-wrap w-100 p-1">
                    <div class="font-weight-bold bg-light rounded w-100 pt-3 pb-3 d-flex justify-content-center f-number">
                        3
                    </div>
                    <div class="text-white rounded">
                        <div class="label">
                            Persiapan
                        </div>
                        <div class="description">
                            Data Deskripsi Inovasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
    <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z" fill="#f9f9f9"></path>
</svg>