@extends('layouts.app')
@section('title', "show :: $title")

@section('css')

@endsection

@section('js')
    @include('core::layouts.components.tinymce')
@endsection

@section('content')

    @include('layouts.breadcrumb', [
        'lists' => [
            'Dashboard' => 'javascript:;',
            $title => route("$prefix.index"),
            'Detail Inovasi' => 'active'
        ]
    ])

    <div class="card card-bordered shadow-none rounded-0">
        <div class="card-body bg-light pb-10" style="min-height:calc(100vh - 163px)">
            <div class="content container-fluid p-3">
                <div class="row">
                    <div class="col-md-9 pe-2">
                        <div class="card rounded-1 mb-3">
                            <div class="card-header">
                                <h3 class="card-title mb-0">INOVASI {{$show->label}}</h3>
                            </div>
                            <div class="card-body">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th style="padding-bottom: 1em;">BIODATA PEMOHON</th>
                                        </tr>
                                        <tr>
                                            <td>KABUPATEN / KOTA</td>
                                            <td>:</td>
                                            <td style="text-transform: uppercase;"> {{$show->kota->name}} </td>
                                        </tr>
                                        <tr>
                                            <td>NAMA INSTANSI</td>
                                            <td>:</td>
                                            <td style="text-transform: uppercase;"> {{$show->pemohon1->unit_kerja}}</td>
                                        </tr>
                                        <tr>
                                            <td>ADMINISTRATOR</td>
                                            <td>:</td>
                                            <td style="text-transform: uppercase;"> {{$show->pemohon1->name}} </td>
                                        </tr>

                                        <tr>
                                            <th style="padding-bottom: 1em; padding-top : 2em;">RANCANG BANGUN</th>
                                        </tr>
                                        <tr>
                                            <td colspan="3">{{$show->rancang_bangun}}</td>
                                        </tr>
                                        <tr>
                                            <th style="padding-bottom: 1em; padding-top: 1em;">TUJUAN INOVASI</th>
                                        </tr>
                                        <tr>
                                            <td colspan="3">{{$show->tujuan_inovasi}}</td>
                                        </tr>
                                        <tr>
                                            <th style="padding-bottom: 1em; padding-top: 1em;">HASIL INOVASI</th>
                                        </tr>
                                        <tr>
                                            <td colspan="3">{{$show->hasil_inovasi}}</td>
                                        </tr>
                                            <tr>
                                            <th style="padding-bottom: 1em; padding-top: 1em;">MANFAAT INOVASI</th>
                                        </tr>
                                        <tr>
                                            <td colspan="3">{{$show->manfaat_inovasi}}</td>
                                        </tr>
                                    <!-- <tr>
                                        <th style="padding-bottom: 1em; padding-top: 1em;">WAKTU UJI COBA</th>
                                    </tr>
                                    <tr>
                                        <td colspan="3">{{$show->waktu_uji_coba}}</td>
                                    </tr>
                                        <tr>
                                            <th style="padding-bottom: 1em; padding-top: 1em; ">WAKTU PELAKSANAAN</th>
                                        </tr>
                                        <tr>
                                            <td colspan="3">{{$show->waktu_pelaksanaan}}</td>
                                    </tr> -->
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    </div>

                    <div class="    col-md-3 pe-2">
                    <div class="    card rounded-1 mb-3">
                        <div class="    card-header">
                            <h3 class="c    ard-title mb-0">RINCIAN</h3>
                        </div>
                            <div class="    card-body">
                            <table class    ="table table-striped">
                                <tbo    dy>
                                        <tr>
                                            <th style="padding-bottom: 1em;">BIDANG INOVASI</th>
                                        </tr>
                                        <tr>
                                            <td colspan="3">{{$show->kategori->label}}</td>
                                        </tr>
                                        <tr>
                                            <th style="padding-bottom: 1em; padding-top: 1em;">URUSAN UTAMA</th>
                                        </tr>
                                        <tr>
                                            <td colspan="3">{{$show->urusan_utama}}</td>
                                        </tr>
                                        <tr>
                                            <th style="padding-bottom: 1em; padding-top: 1em;">URUSAN LAINNYA</th>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                {{$show->urusan_lainnya}}</td>

                                                                                </tr>
                                        <tr>
                                            <th style="padding-bottom: 1em; padding-top: 1em;">TAHAPAN INOVASI</th>
                                        </tr>
                                        <tr>
                                             <td colspan="3"
                                                >{{ [$show->tahapan, 'Inisiatif', 'Uji Coba', 'Penerapan'][$show->tahapan] }}</td>

                                                                                 </tr>
                                         <tr>
                                                <th style="padding-bottom: 1em; padding-top: 1em;">INISIATOR INOVASI</th>
                                            </tr>
                                            <tr>
                                                <td colspan="3">{{ [1 => 'Kepala Daerah', 2 => 'Anggota DPRD', 3 => 'OPD', 4 => 'ASN', 5 => 'Masyarakat'][$show->inisiator] }}</td>
                                            </tr>
                                            <tr>
                                                <th style="padding-bottom: 1em; padding-top: 1em;">JENIS INOVASI</th>
                                            </tr>
                                            <tr>
                                               <td colspan="3">{{ [1 => 'Digital', 2 => 'Non Digital'][$show->jenis] }}</td>
                                   </tr>        
                                     <tr>

                                                                                           <th style="padding-bottom: 1em; padding-top: 1em;">ANGGARAN INOVASI</th>
                             </tr>
                                          <tr>
                                                     <td colspan="3">
                                                @if($show->anggaran)
                                                    <a href="{{ asset($show->anggaran) }}" class="btn btn-primary" target="_blank">Lihat Data</a>
                                                @else
                                                    Tidak ada data
                                                @endif
                                            </td>
                            </tr            >

                                       <tr>

                                                                                                     <th   style="padding-bottom: 1em; padding-top: 1em;">Proposal Inovasi</th>
                                        </tr>
                            <tr>
                                                        <td colspan="3">
                                                @if($show->profil_bisnis)
                                                    <a href="{{ asset($show->profil_bisnis) }}" class="btn btn-primary" target="_blank">Lihat Data</a>
                                                @else
                                                    Tidak ada data
                                                @endif
                                            </td>
                                        </tr>
                        </tbody>
                                </table>
                </div>

                </div>
        </div>

    </div>

    </div>
    </div>
    </div>

@endsection