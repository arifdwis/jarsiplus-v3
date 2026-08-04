@extends('layouts.app')
@section('title', 'Data Bukti Dukung Inovasi')

@section('css')
    <style>
        #datatable {
            width: 100% !important;
        }

        #datatable td,
        #datatable th {
            white-space: normal !important;
            word-break: break-word;
            vertical-align: middle;
        }

        .col-date {
            white-space: nowrap !important;
            word-break: normal !important;
            width: 130px !important;
            min-width: 130px !important;
            text-align: center !important;
        }

        .col-access {
            width: 135px !important;
            min-width: 135px !important;
            text-align: center !important;
        }

        .col-jenis {
            width: 110px !important;
            min-width: 110px !important;
            text-align: center !important;
        }

        .kpi-card {
            border: 1px solid #e7eaf3;
            border-radius: 0.75rem;
            transition: all 0.2s ease-in-out;
            background: #ffffff;
        }

        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1.25rem rgba(189, 197, 209, 0.25);
        }

        .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .btn-filter-jenis.active {
            background-color: #377dff !important;
            color: #ffffff !important;
            border-color: #377dff !important;
        }

        .table-thead-custom th {
            background-color: #f8f9fa !important;
            color: #1e2022 !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
    </style>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            var selectedJenisFilter = '';
            var selectedTahunFilter = '';
            var selectedPermohonanFilter = '';

            HSCore.components.HSDatatables.init('.js-datatable', {
                scrollY: 'calc(100vh - 380px)',
                scrollX: false,
                autoWidth: false,
                ajax: {
                    url: '{!! request()->fullUrl() !!}',
                    data: function(d) {
                        d.datatable = true;
                        d.jenis_filter = selectedJenisFilter;
                        d.tahun_filter = selectedTahunFilter;
                        d.permohonan_filter = selectedPermohonanFilter;
                    }
                },
                columns: [
                    { data: 'pilihan', name: 'pilihan', className: 'text-center col-check', orderable: false, searchable: false, width: '30px' },
                    { data: 'permohonan', name: 'permohonan', width: '26%' },
                    { data: 'pemohon', name: 'pemohon', width: '22%' },
                    { data: 'bukti', name: 'bukti', width: '24%' },
                    { data: 'jenis', name: 'jenis', className: 'text-center col-jenis', width: '110px' },
                    { data: 'akses', name: 'akses', className: 'text-center col-access', orderable: false, searchable: false, width: '135px' },
                    { data: 'tanggal', name: 'tanggal', className: 'text-center col-date', width: '130px' }
                ],
                @include('nue::partials.datatable.script')
            });

            $('.js-datatable').on('draw.dt', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(el) { return new bootstrap.Tooltip(el); });
            });

            function reloadDataTable() {
                if ($.fn.dataTable.isDataTable('#datatable')) {
                    $('#datatable').DataTable().ajax.reload();
                }
            }

            // Filter Jenis
            $('.btn-filter-jenis').on('click', function() {
                $('.btn-filter-jenis').removeClass('active');
                $(this).addClass('active');
                selectedJenisFilter = $(this).data('filter');
                reloadDataTable();
            });

            // Filter Tahun
            $('#filter-tahun').on('change', function() {
                selectedTahunFilter = $(this).val();
                reloadDataTable();
            });

            // Filter Permohonan / Inovasi Text Input
            var timerPermohonan;
            $('#filter-permohonan').on('keyup change input', function() {
                clearTimeout(timerPermohonan);
                var val = $(this).val();
                timerPermohonan = setTimeout(function() {
                    selectedPermohonanFilter = val;
                    reloadDataTable();
                }, 300);
            });

            // Reset All Filters
            $('#btn-reset-filter').on('click', function() {
                selectedJenisFilter = '';
                selectedTahunFilter = '';
                selectedPermohonanFilter = '';
                $('.btn-filter-jenis').removeClass('active');
                $('.btn-filter-jenis[data-filter=""]').addClass('active');
                $('#filter-tahun').val('');
                $('#filter-permohonan').val('');
                if ($.fn.dataTable.isDataTable('#datatable')) {
                    var dt = $('#datatable').DataTable();
                    dt.search('').draw();
                    dt.ajax.reload();
                }
            });
        });
    </script>
@endsection

@section('content')
    @include('layouts.breadcrumb', [
        'lists' => [
            'Dashboard' => 'javascript:;',
            'JARSIPLUS' => 'javascript:;',
            'Bukti Dukung' => 'active'
        ]
    ])

    <div class="content container-fluid py-4">
        <!-- Page Header -->
        <div class="page-header mb-4 pb-2 border-bottom">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title d-flex align-items-center gap-2 mb-1">
                        <span class="iconify text-primary" data-icon="material-symbols:folder-open-outline" style="font-size: 32px;"></span>
                        Data Bukti Dukung Inovasi
                    </h1>
                    <p class="page-header-text text-muted mb-0">
                        Rekapitulasi seluruh dokumen bukti dukung (File Upload & Tautan URL) dari setiap permohonan inovasi.
                    </p>
                </div>
                <div class="col-sm-auto">
                    <a href="{{ route('epanel.bukti-dukung.export') }}" class="btn btn-primary d-inline-flex align-items-center gap-1 shadow-sm px-3 py-2">
                        <span class="iconify fs-5" data-icon="clarity:export-line"></span>
                        Export CSV
                    </a>
                </div>
            </div>
        </div>

        <!-- Ringkasan KPI Cards -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="kpi-card p-3">
                    <div class="d-flex align-items-center">
                        <div class="kpi-icon bg-soft-primary text-primary me-3">
                            <span class="iconify" data-icon="ph:files-duotone"></span>
                        </div>
                        <div>
                            <span class="d-block fs-6 text-muted fw-medium">Total Bukti Dukung</span>
                            <h3 class="mb-0 fw-bold text-dark">{{ number_format($totalBukti) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="kpi-card p-3">
                    <div class="d-flex align-items-center">
                        <div class="kpi-icon bg-soft-info text-info me-3">
                            <span class="iconify" data-icon="bx:bxs-file-pdf"></span>
                        </div>
                        <div>
                            <span class="d-block fs-6 text-muted fw-medium">File Upload</span>
                            <h3 class="mb-0 fw-bold text-dark">{{ number_format($totalFile) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="kpi-card p-3">
                    <div class="d-flex align-items-center">
                        <div class="kpi-icon bg-soft-success text-success me-3">
                            <span class="iconify" data-icon="bx:bx-link-external"></span>
                        </div>
                        <div>
                            <span class="d-block fs-6 text-muted fw-medium">Tautan URL</span>
                            <h3 class="mb-0 fw-bold text-dark">{{ number_format($totalUrl) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="kpi-card p-3">
                    <div class="d-flex align-items-center">
                        <div class="kpi-icon bg-soft-warning text-warning me-3">
                            <span class="iconify" data-icon="humbleicons:user-asking"></span>
                        </div>
                        <div>
                            <span class="d-block fs-6 text-muted fw-medium">Permohonan Terkait</span>
                            <h3 class="mb-0 fw-bold text-dark">{{ number_format($totalInovasi) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="card card-bordered shadow-sm mb-4">
            <div class="card-body p-3">
                <div class="row g-3 align-items-center">
                    <!-- Filter Jenis -->
                    <div class="col-12 col-md-auto me-md-2">
                        <label class="form-label small fw-bold text-dark mb-1 d-flex align-items-center gap-1">
                            <i class="iconify text-primary" data-icon="icon-park-outline:filter"></i> Jenis Bukti
                        </label>
                        <div class="btn-group btn-group-sm w-100" role="group">
                            <button type="button" class="btn btn-outline-secondary btn-filter-jenis active" data-filter="">Semua Data</button>
                            <button type="button" class="btn btn-outline-secondary btn-filter-jenis" data-filter="file"><i class="iconify me-1" data-icon="bx:bxs-file-pdf"></i>File Upload</button>
                            <button type="button" class="btn btn-outline-secondary btn-filter-jenis" data-filter="url"><i class="iconify me-1" data-icon="bx:bx-link-external"></i>Tautan URL</button>
                        </div>
                    </div>

                    <!-- Filter Tahun -->
                    <div class="col-6 col-md-2">
                        <label for="filter-tahun" class="form-label small fw-bold text-dark mb-1 d-flex align-items-center gap-1">
                            <i class="iconify text-primary" data-icon="clarity:calendar-line"></i> Tahun
                        </label>
                        <select id="filter-tahun" class="form-select form-select-sm">
                            <option value="">Semua Tahun</option>
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">Tahun {{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Permohonan (Text Input Search) -->
                    <div class="col-12 col-md-4">
                        <label for="filter-permohonan" class="form-label small fw-bold text-dark mb-1 d-flex align-items-center gap-1">
                            <i class="iconify text-primary" data-icon="humbleicons:user-asking"></i> Permohonan / Inovasi
                        </label>
                        <input type="text" id="filter-permohonan" class="form-control form-control-sm" placeholder="Ketik kata kunci Nama Inovasi...">
                    </div>

                    <!-- Reset Filter Button -->
                    <div class="col-6 col-md-auto ms-auto text-end pt-md-3">
                        <button type="button" id="btn-reset-filter" class="btn btn-soft-secondary btn-sm d-inline-flex align-items-center gap-1">
                            <i class="iconify" data-icon="bx:bx-refresh"></i> Reset Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="card card-bordered shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatable" class="js-datatable align-middle table-bordered table table-sm table-hover table-thead-bordered mb-0" style="width:100%;">
                        <thead class="thead-light table-thead-custom">
                            <tr>
                                <th class="col-check text-center" style="width:30px;">
                                    <div class="form-check mb-0">
                                        <input id="datatable-checkbox-check" type="checkbox" class="form-check-input">
                                        <label class="form-check-label" for="check-all"></label>
                                    </div>
                                </th>
                                <th>Permohonan / Inovasi</th>
                                <th>Inovator / Pemohon</th>
                                <th>Bukti Dukung & Indikator</th>
                                <th class="text-center col-jenis" style="width:110px;">Jenis</th>
                                <th class="text-center col-access" style="width:135px;">Akses File / URL</th>
                                <th class="text-center col-date" style="width:130px;">Tgl Upload</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            @include('layouts.datatable.footer')
        </div>
    </div>
@endsection
