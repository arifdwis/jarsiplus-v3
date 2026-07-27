@extends('template::layouts.master', ['footer' => false])

@section('css')
    <style>
        .legenda {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <section class="page-header">
        <div class="header-light text-center mb-3">
            <h1 class="title">Statistik</h1>
            <h4 class="subtitle">Statistik Data Jarsiplus.</h4>
        </div>
        <div class="section">
            <div class="row">

            </div>
        </div>
    </section>

    <svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
        <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z"
            fill="#f9f9f9"></path>
    </svg>

    <div class="section full mt-2">
        <div class="wide-block pt-2 pb-2">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <div class="card bg-primary h-100">
                        <div class="card-body text-center pt-4 pb-4">
                            <h5 class="mb-2 text-white">Pemohon</h5>
                            <h2 class="mb-0 text-white">{{$cpemohon}}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <div class="card bg-primary h-100">
                        <div class="card-body text-center pt-4 pb-4">
                            <h5 class="mb-2 text-white">Permohonan</h5>
                            <h2 class="mb-0 text-white">{{$permohonan}}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <div class="card bg-primary h-100">
                        <div class="card-body text-center pt-4 pb-4">
                            <h5 class="mb-2 text-white">Inovasi Publish</h5>
                            <h2 class="mb-0 text-white">{{$selesai}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="section full mb-2 mt-2">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Table Pemohon</h5>
                <code>Daftar 10 Pemohon Terakhir</code>
                <div class="wide-block p-0 mt-2">
                    <div class="table-responsive">
                        <table class="table table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col" class="d-none d-md-table-cell">Unit Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pemohon as $key => $value)
                                    <tr>
                                        <th scope="row">{{$key + 1}}</th>
                                        <td>{{$value->name}}</td>
                                        <td>{{$value->jabatan}}</td>
                                        <td class="d-none d-md-table-cell">{{\Illuminate\Support\Str::limit($value->unit_kerja, 30)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Grafik Jumlah Permohonan per Hari</h5>
            <div class="wide-block pt-2 pb-2" style="position: relative; height:300px; width:100%;">
                <canvas id="permohonanChartHari"></canvas>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Grafik Jumlah Permohonan per Bulan</h5>
            <div class="wide-block pt-2 pb-2" style="position: relative; height:300px; width:100%;">
                <canvas id="permohonanChartBulan"></canvas>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var permohonanPerHariData = {!! json_encode($permohonanPerHari) !!};
        var permohonanPerBulanData = {!! json_encode($permohonanPerBulan) !!};

        var permohonanChartHari = document.getElementById('permohonanChartHari').getContext('2d');
        var permohonanChartInstanceHari = new Chart(permohonanChartHari, {
            type: 'line',
            data: {
                labels: permohonanPerHariData.dates,
                datasets: [{
                    label: 'Per Hari',
                    data: permohonanPerHariData.counts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Tanggal'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Jumlah Permohonan'
                        }
                    }
                }
            }
        });

        var permohonanChartBulan = document.getElementById('permohonanChartBulan').getContext('2d');
        var permohonanChartInstanceBulan = new Chart(permohonanChartBulan, {
            type: 'line',
            data: {
                labels: permohonanPerBulanData.months,
                datasets: [{
                    label: 'Per Bulan',
                    data: permohonanPerBulanData.counts,
                    backgroundColor: 'rgba(192, 75, 75, 0.2)',
                    borderColor: 'rgba(192, 75, 75, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Jumlah Permohonan'
                        }
                    }
                }
            }
        });
    </script>

@endsection