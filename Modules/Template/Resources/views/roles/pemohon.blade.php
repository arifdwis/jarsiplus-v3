@if (
    me()->pemohon &&
    trim((string) me()->pemohon->name) !== '' &&
    trim((string) me()->pemohon->nik) !== '' &&
    trim((string) me()->pemohon->nip) !== '' &&
    trim((string) me()->pemohon->phone) !== '' &&
    trim((string) me()->pemohon->email) !== '' &&
    trim((string) me()->pemohon->unit_kerja) !== '' &&
    trim((string) me()->pemohon->jabatan) !== ''
)
<div class="section pt-2 pb-3">
    <form class="search-form">
        <div class="form-group searchbox">
            <input type="text" class="form-control" value="" placeholder="Masukan kode">
            <i class="input-icon">
                <ion-icon name="search-outline" role="img" class="md hydrated" aria-label="search outline"></ion-icon>
            </i>
        </div>
        <small class="muted">Cari tahu permohonan anda telah ditahap mana.</small>
    </form>
</div>

<div class="section pb-5">
    <div class="row">
<!--         <div class="col-6 col-lg-3 mb-3">
            <a href="{{route('permohonan.create')}}">
                <div class="card bg-primary h-100">
                    <img src="{{asset('assets/img/PENGAJUAN_1.svg')}}" class="card-img-top px-3" alt="image">
                    <div class="card-body text-uppercase text-center pt-2">
                        <h5 class="mb-0">Pengajuan</h5>
                    </div>
                </div>
            </a>
        </div> -->
        <div class="col-6 col-lg-3 mb-3">
            <a href="{{route('permohonan.index')}}">
                <div class="card bg-primary h-100">
                    <svg class="card-img-top mt-2 px-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">

                        <path fill="#CCCC31" d="M14.217 3.5a5.17 5.17 0 0 0-4.434 0L5.489 5.512a2.25 2.25 0 0 1 .647 4.306l-1.076.461c-.534.23-.837.362-1.042.467a4.315 4.315 0 0 0-.003.05L9.783 13.5a5.17 5.17 0 0 0 4.434 0l6.691-3.137c1.456-.682 1.456-3.044 0-3.726L14.217 3.5Z"/>

                        <path fill="#CCCC31" d="M5.545 8.44a.75.75 0 0 0-.59-1.38l-1.112.477c-.557.239-1.03.441-1.4.65c-.395.222-.734.482-.989.868c-.254.386-.36.8-.408 1.25C1 10.729 1 11.242 1 11.85v2.901a.75.75 0 0 0 1.5 0v-2.862c0-.656.001-1.088.037-1.421c.034-.315.093-.47.17-.586c.075-.115.195-.231.471-.387c.292-.164.689-.335 1.292-.593l1.075-.461Z"/>

                        <path fill="#ecf0f1" d="M5 11.258L9.783 13.5a5.17 5.17 0 0 0 4.434 0L19 11.258v5.367c0 1.008-.503 1.952-1.385 2.44C16.146 19.88 13.796 21 12 21c-1.796 0-4.146-1.121-5.615-1.935C5.504 18.577 5 17.633 5 16.625v-5.367Z" opacity="1"/></g></svg>
                    </svg>
                    <div class="card-body text-uppercase text-center pt-2">
                        <h5 class="mb-0">Permohonan</h5>
                    </div>
                </div>
            </a>
        </div>
<!--         <div class="col-6 col-lg-3 mb-2">
            <a href="{{route('permohonan.index')}}">
                <div class="card bg-primary h-100">
                    <img src="{{asset('/images/kerjasama.svg')}}" class="card-img-top px-3" alt="image">
                    <div class="card-body text-uppercase text-center pt-2">
                        <h5 class="mb-0">Kerja Sama</h5>
                    </div>
                </div>
            </a>
        </div> -->
        <div class="col-6 col-lg-3 mb-3">
            <a href="{{route('informasi.index')}}">
                <div class="card bg-primary h-100">
                    <svg class="card-img-top mt-2 px-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="#CCCC31" d="m20.312 12.647l.517-1.932c.604-2.255.907-3.382.68-4.358a4 4 0 0 0-1.162-2.011c-.731-.685-1.859-.987-4.114-1.591c-2.255-.605-3.383-.907-4.358-.68a4 4 0 0 0-2.011 1.162c-.587.626-.893 1.543-1.348 3.209l-.244.905l-.517 1.932c-.605 2.255-.907 3.382-.68 4.358a4 4 0 0 0 1.162 2.011c.731.685 1.859.987 4.114 1.592c2.032.544 3.149.843 4.064.73c.1-.012.198-.03.294-.052a4 4 0 0 0 2.011-1.16c.685-.732.987-1.86 1.592-4.115Z"/>
                        <path fill="#ecf0f1" d="M16.415 17.974a4 4 0 0 1-1.068 1.678c-.731.685-1.859.987-4.114 1.591s-3.383.907-4.358.679a4 4 0 0 1-2.011-1.161c-.685-.731-.988-1.859-1.592-4.114l-.517-1.932c-.605-2.255-.907-3.383-.68-4.358a4 4 0 0 1 1.162-2.011c.731-.685 1.859-.987 4.114-1.592c.426-.114.813-.218 1.165-.309l-.244.906l-.517 1.932c-.605 2.255-.907 3.382-.68 4.358a4 4 0 0 0 1.162 2.011c.731.685 1.859.987 4.114 1.592c2.032.544 3.149.843 4.064.73Z" opacity="1"/></g></svg>
                        <div class="card-body text-uppercase text-center pt-2">
                            <h5 class="mb-0">Informasi</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3 mb-3">
                <a href="{{route('statistik.index')}}">
                    <div class="card bg-primary h-100">
                        <svg class="card-img-top mt-2 px-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                          <g>
                            <path fill="#ecf0f1" d="M6.222 4.601a9.499 9.499 0 0 1 1.395-.771c1.372-.615 2.058-.922 2.97-.33c.913.59.913 1.56.913 3.5v1.5c0 1.886 0 2.828.586 3.414c.586.586 1.528.586 3.414.586H17c1.94 0 2.91 0 3.5.912c.592.913.285 1.599-.33 2.97a9.498 9.498 0 0 1-10.523 5.435A9.5 9.5 0 0 1 6.222 4.601Z" opacity="1"/>
                            <path fill="#CCCC31" d="M21.446 7.069a8.026 8.026 0 0 0-4.515-4.515C15.389 1.947 14 3.344 14 5v4a1 1 0 0 0 1 1h4c1.657 0 3.053-1.39 2.446-2.931Z"/>
                        </g>
                    </svg>
                    <div class="card-body text-uppercase text-center pt-2">
                        <h5 class="mb-0">Statistik & Data</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <a href="{{route('faq.index')}}">
                <div class="card bg-primary h-100">
                   <svg class="card-img-top mt-2 px-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor">
                    <path fill="#ecf0f1" d="M21 15.998v-6c0-2.828 0-4.242-.879-5.121C19.353 4.109 18.175 4.012 16 4H8c-2.175.012-3.353.109-4.121.877C3 5.756 3 7.17 3 9.998v6c0 2.829 0 4.243.879 5.122c.878.878 2.293.878 5.121.878h6c2.828 0 4.243 0 5.121-.878c.879-.88.879-2.293.879-5.122Z" opacity="1"/>
                    <path fill="#CCCC31" d="M8 3.5A1.5 1.5 0 0 1 9.5 2h5A1.5 1.5 0 0 1 16 3.5v1A1.5 1.5 0 0 1 14.5 6h-5A1.5 1.5 0 0 1 8 4.5v-1Z"/>
                    <path fill="#CCCC31" d="M6.25 10.5A.75.75 0 0 1 7 9.75h10a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75Zm1 3.5a.75.75 0 0 1 .75-.75h8a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75Zm1 3.5a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/></g></svg>
                    <div class="card-body text-uppercase text-center pt-2">
                        <h5 class="mb-0">Faq</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@else
<div class="section full mt-2 mb-2">
    <div class="section-title">PERHATIAN !!</div>
    <div class="wide-block pt-2 pb-2" style="text-align: justify;">
       Kami ingin memberitahu Anda betapa pentingnya melengkapi data diri Anda. Ini bukan hanya untuk keamanan akun Anda, tetapi juga untuk memastikan bahwa kami dapat memberikan layanan yang lebih baik dan relevan sesuai dengan kebutuhan Anda. <br><br>

       Mohon luangkan waktu sebentar untuk mengisi nama, NIK, NIP, nomor WA, email, unit kerja, dan jabatan. Dengan informasi yang lengkap dan akurat, kami dapat memberikan pengalaman yang lebih baik dalam penanganan permohonan Anda.<br><br>

       <a class="btn btn-dark my-2 btn-block" href="{{route('settings')}}">Lengkapi Biodata</a> 
   </div>
</div>

</div>
@endif
