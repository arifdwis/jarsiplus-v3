@extends('layouts.app')
@section('title', __('Dashboard'))
@section('m-home', 'active')

@php
    $currentYear = (int) date('Y');

    $statusCounts = \Modules\Formulir\Entities\Permohonan::selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $totalPermohonan = (int) $statusCounts->sum();
    $statusProses = (int) $statusCounts->get(0, 0);
    $statusSetuju = (int) $statusCounts->get(1, 0);
    $statusValidasi = (int) $statusCounts->get(2, 0);
    $statusSelesai = (int) $statusCounts->get(4, 0);

    $nilaiInovasi = (float) \Modules\Formulir\Entities\Permohonan::whereNotNull('nilai_akhir')->sum('nilai_akhir');
    $targetNilai = (int) env('DASHBOARD_TARGET_NILAI', 5000);
    $persenNilai = $targetNilai > 0 ? min(round(($nilaiInovasi / $targetNilai) * 100, 1), 100) : 0;

    $todayCount = \Modules\Formulir\Entities\Permohonan::whereDate('created_at', \Carbon\Carbon::today())->count();
    $totalInovator = \Modules\Formulir\Entities\Permohonan::whereNotNull('id_pemohon_0')
        ->distinct('id_pemohon_0')
        ->count('id_pemohon_0');
    $totalKategori = \Modules\Formulir\Entities\Kategori::count();
    $avgNilai = (float) \Modules\Formulir\Entities\Permohonan::whereNotNull('nilai_akhir')->avg('nilai_akhir');

    $monthlyRaw = \Modules\Formulir\Entities\Permohonan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
        ->whereYear('created_at', $currentYear)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

    $bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $monthlyLabelsArr = [];
    $monthlyDataArr = [];

    for ($bulan = 1; $bulan <= 12; $bulan++) {
        $monthlyLabelsArr[] = $bulanNames[$bulan - 1];
        $monthlyDataArr[] = (int) ($monthlyRaw[$bulan] ?? 0);
    }

    $groupedPermohonan = \Modules\Formulir\Entities\Permohonan::selectRaw('id_pemohon_0, COUNT(*) as jumlah')
        ->whereNotNull('id_pemohon_0')
        ->groupBy('id_pemohon_0')
        ->orderByDesc('jumlah')
        ->limit(10)
        ->get();

    $pemohonMap = \Modules\Pemohon\Entities\Pemohon::whereIn(
        'id_operator',
        $groupedPermohonan->pluck('id_pemohon_0')->filter()->unique()->values()->all()
    )->get()->keyBy('id_operator');

    $recentInovasi = \Modules\Formulir\Entities\Permohonan::with('pemohon1')
        ->latest('created_at')
        ->limit(5)
        ->get();

    $dashboardPermohonan = \Modules\Formulir\Entities\Permohonan::with(['pemohon1', 'kategori'])
        ->latest('created_at')
        ->get();

    $kategoriStats = \Modules\Formulir\Entities\Kategori::query()
        ->leftJoin('permohonan', 'urusan_kategori.id', '=', 'permohonan.id_kategori')
        ->selectRaw('urusan_kategori.id, urusan_kategori.label, COUNT(permohonan.id) as total')
        ->groupBy('urusan_kategori.id', 'urusan_kategori.label')
        ->orderByDesc('total')
        ->get();

    $dashboardPermohonanJson = $dashboardPermohonan->map(function ($item) {
        return [
            'id' => $item->id,
            'title' => $item->label ?: '-',
            'innovator_id' => $item->id_pemohon_0,
            'innovator' => optional($item->pemohon1)->name ?: '-',
            'category' => optional($item->kategori)->label ?: '-',
            'status' => (int) $item->status,
            'date' => optional($item->created_at)->format('d-m-Y') ?: '-',
            'score' => $item->nilai_akhir,
        ];
    })->values();

    $kategoriStatsJson = $kategoriStats->map(function ($item) {
        return ['label' => $item->label, 'total' => (int) $item->total];
    })->values();

    $colors = ['primary', 'success', 'info', 'warning', 'danger', 'dark', 'secondary'];
@endphp

@section('css')
<style>
    .stat-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        font-size: 1.25rem;
    }
    .progress-thin {
        height: 6px;
        border-radius: 3px;
    }
    .badge-status {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        border-radius: 0.375rem;
    }
    .card-hover-shadow:hover {
        box-shadow: 0 0.375rem 0.75rem rgba(140, 152, 164, 0.15) !important;
        transition: box-shadow 0.2s ease;
    }
    .dashboard-detail-card {
        cursor: pointer;
    }
    .table-dashboard th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #97a4af;
        border-top: none;
    }
    .table-dashboard td {
        vertical-align: middle;
    }
    .quick-link-card {
        transition: all 0.2s ease;
        text-decoration: none;
        color: inherit;
    }
    .quick-link-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.375rem 0.75rem rgba(140, 152, 164, 0.2) !important;
        text-decoration: none;
        color: inherit;
    }
    .welcome-section {
        background: linear-gradient(135deg, #377dff 0%, #00c9db 100%);
        border-radius: 0.75rem;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .welcome-section::after {
        content: '';
        position: absolute;
        right: -30px;
        top: -30px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .welcome-section::before {
        content: '';
        position: absolute;
        right: 50px;
        bottom: -40px;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .nilai-card {
        background: linear-gradient(135deg, #f5f8ff 0%, #e8f0fe 100%);
        border: 1px solid #d6e4ff !important;
    }
    .rank-badge {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .chart-container {
        position: relative;
        height: 300px;
    }
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Status counts
    var status0Count = @json($statusProses);
    var status1Count = @json($statusSetuju);
    var status2Count = @json($statusValidasi);
    var status4Count = @json($statusSelesai);

    // Doughnut Chart - Status Inovasi
    var statusDoughnut = new Chart('statusDoughnutChart', {
        type: 'doughnut',
        data: {
            labels: ['Proses', 'Disetujui', 'Validasi', 'Selesai'],
            datasets: [{
                data: [status0Count, status1Count, status2Count, status4Count],
                backgroundColor: [
                    'rgba(245, 166, 35, 0.85)',
                    'rgba(0, 201, 219, 0.85)',
                    'rgba(55, 125, 255, 0.85)',
                    'rgba(0, 201, 167, 0.85)'
                ],
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { size: 12 }
                    }
                }
            }
        }
    });

    // Bar Chart - Status Permohonan
    var permohonanChart = new Chart('permohonanChart', {
        type: 'bar',
        data: {
            labels: ['Proses', 'Disetujui', 'Validasi', 'Selesai'],
            datasets: [{
                label: 'Jumlah Inovasi',
                data: [status0Count, status1Count, status2Count, status4Count],
                backgroundColor: [
                    'rgba(245, 166, 35, 0.2)',
                    'rgba(0, 201, 219, 0.2)',
                    'rgba(55, 125, 255, 0.2)',
                    'rgba(0, 201, 167, 0.2)'
                ],
                borderColor: [
                    'rgba(245, 166, 35, 1)',
                    'rgba(0, 201, 219, 1)',
                    'rgba(55, 125, 255, 1)',
                    'rgba(0, 201, 167, 1)'
                ],
                borderWidth: 2,
                borderRadius: 6,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12 } }
                },
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, font: { size: 11 } },
                    grid: { color: 'rgba(0,0,0,0.04)' }
                }
            }
        }
    });

    // Monthly Chart
    var monthlyData = @json($monthlyDataArr);
    var monthlyLabels = @json($monthlyLabelsArr);

    var monthlyChart = new Chart('monthlyChart', {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Inovasi {{ $currentYear }}',
                data: monthlyData,
                borderColor: 'rgba(55, 125, 255, 1)',
                backgroundColor: 'rgba(55, 125, 255, 0.08)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(55, 125, 255, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, font: { size: 11 } },
                    grid: { color: 'rgba(0,0,0,0.04)' }
                }
            }
        }
    });
</script>
@endsection

@section('content')
<div class="content container-fluid">

    {{-- ============ WELCOME SECTION ============ --}}
    <div class="welcome-section p-4 mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-1" style="font-weight: 600;">Hai, {{ Nue::user()->name }}! 👋</h2>
                <p class="mb-0" style="opacity: 0.85;">Selamat datang di Dashboard Jaringan Inovasi (JarSi+) Pemerintah Kota Samarinda</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <span class="d-block" style="opacity: 0.7; font-size: 0.85rem;">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
        </div>
    </div>

    {{-- ============ NILAI INOVASI CARD ============ --}}
    <div class="row gx-3 mb-4">
        <div class="col-12">
            <div class="card card-hover-shadow dashboard-detail-card shadow-none rounded-2 nilai-card h-100" data-dashboard-detail="nilai" role="button" tabindex="0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="card-subtitle text-muted mb-2" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="bi-trophy me-1"></i> Nilai Inovasi Pemerintah Kota Samarinda
                            </h6>
                            <div class="d-flex align-items-end mb-2">
                                <h2 class="display-4 mb-0 me-3" style="font-weight: 700; color: #377dff;">{{ number_format($nilaiInovasi, 0, ',', '.') }}</h2>
                                <span class="text-muted fs-6 mb-2">dari {{ number_format($targetNilai, 0, ',', '.') }} Target</span>
                            </div>
                            <div class="progress progress-thin" style="max-width: 400px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $persenNilai }}%; background: linear-gradient(90deg, #377dff, #00c9db);" aria-valuenow="{{ $persenNilai }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted mt-1 d-block">{{ $persenNilai }}% dari target tercapai</small>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <span class="badge bg-soft-primary text-primary" style="font-size: 0.85rem; padding: 0.5em 1em;">
                                <i class="bi-graph-up me-1"></i> +{{ $todayCount }} Hari Ini
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ STAT CARDS ROW 1 ============ --}}
    <div class="row gx-3 mb-2">
        <div class="col-sm-6 col-lg-3 mb-3">
            <div class="card card-hover-shadow dashboard-detail-card shadow-none border rounded-2 h-100" data-dashboard-detail="total" role="button" tabindex="0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-soft-primary text-primary me-3">
                            <i class="bi-file-earmark-text"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-0" style="font-size: 0.8rem;">Total Pengajuan</h6>
                        </div>
                    </div>
                    <h2 class="display-5 mb-1" style="font-weight: 700;">{{ number_format($totalPermohonan, 0, ',', '.') }}</h2>
                    <span class="badge bg-soft-success text-success badge-status">
                        <i class="bi-graph-up me-1"></i> {{ $todayCount }} Hari Ini
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-3">
            <div class="card card-hover-shadow dashboard-detail-card shadow-none border rounded-2 h-100" data-dashboard-detail="proses" role="button" tabindex="0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-soft-warning text-warning me-3">
                            <i class="bi-hourglass-split"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-0" style="font-size: 0.8rem;">Sedang Diproses</h6>
                        </div>
                    </div>
                    <h2 class="display-5 mb-1" style="font-weight: 700; color: #f5a623;">{{ number_format($statusProses, 0, ',', '.') }}</h2>
                    @if($totalPermohonan > 0)
                    <span class="text-muted" style="font-size: 0.8rem;">{{ round(($statusProses / $totalPermohonan) * 100, 1) }}% dari total</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-3">
            <div class="card card-hover-shadow dashboard-detail-card shadow-none border rounded-2 h-100" data-dashboard-detail="setuju" role="button" tabindex="0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-soft-info text-info me-3">
                            <i class="bi-check2-circle"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-0" style="font-size: 0.8rem;">Disetujui</h6>
                        </div>
                    </div>
                    <h2 class="display-5 mb-1" style="font-weight: 700; color: #00c9db;">{{ number_format($statusSetuju, 0, ',', '.') }}</h2>
                    @if($totalPermohonan > 0)
                    <span class="text-muted" style="font-size: 0.8rem;">{{ round(($statusSetuju / $totalPermohonan) * 100, 1) }}% dari total</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-3">
            <div class="card card-hover-shadow dashboard-detail-card shadow-none border rounded-2 h-100" data-dashboard-detail="selesai" role="button" tabindex="0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-soft-success text-success me-3">
                            <i class="bi-patch-check"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-0" style="font-size: 0.8rem;">Selesai</h6>
                        </div>
                    </div>
                    <h2 class="display-5 mb-1" style="font-weight: 700; color: #00c9a7;">{{ number_format($statusSelesai, 0, ',', '.') }}</h2>
                    @if($totalPermohonan > 0)
                    <span class="text-muted" style="font-size: 0.8rem;">{{ round(($statusSelesai / $totalPermohonan) * 100, 1) }}% dari total</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ============ STAT CARDS ROW 2 ============ --}}
    <div class="row gx-3 mb-2">
        <div class="col-sm-6 col-lg-4 mb-3">
            <div class="card card-hover-shadow dashboard-detail-card shadow-none border rounded-2 h-100" data-dashboard-detail="inovator" role="button" tabindex="0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-soft-dark text-dark me-3">
                            <i class="bi-people"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-0" style="font-size: 0.8rem;">Total Inovator</h6>
                        </div>
                    </div>
                    <h2 class="display-5 mb-0" style="font-weight: 700;">{{ number_format($totalInovator, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4 mb-3">
            <div class="card card-hover-shadow dashboard-detail-card shadow-none border rounded-2 h-100" data-dashboard-detail="kategori" role="button" tabindex="0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-soft-danger text-danger me-3">
                            <i class="bi-grid"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-0" style="font-size: 0.8rem;">Kategori Inovasi</h6>
                        </div>
                    </div>
                    <h2 class="display-5 mb-0" style="font-weight: 700;">{{ number_format($totalKategori, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4 mb-3">
            <div class="card card-hover-shadow dashboard-detail-card shadow-none border rounded-2 h-100" data-dashboard-detail="nilai" role="button" tabindex="0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-soft-info text-info me-3">
                            <i class="bi-bar-chart"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-0" style="font-size: 0.8rem;">Rata-rata Nilai</h6>
                        </div>
                    </div>
                    <h2 class="display-5 mb-0" style="font-weight: 700;">{{ number_format($avgNilai, 1, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ CHARTS SECTION ============ --}}
    <div class="row gx-3 mb-2">
        {{-- Doughnut Chart --}}
        <div class="col-lg-4 mb-3">
            <div class="card rounded-2 shadow-none border h-100">
                <div class="card-header card-header-content-between border-0 pb-0">
                    <h4 class="card-subtitle mb-0" style="font-size: 0.9rem; font-weight: 600;">
                        <i class="bi-pie-chart me-1 text-primary"></i> Status Inovasi
                    </h4>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="chart-container w-100">
                        <canvas id="statusDoughnutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="col-lg-4 mb-3">
            <div class="card rounded-2 shadow-none border h-100">
                <div class="card-header card-header-content-between border-0 pb-0">
                    <h4 class="card-subtitle mb-0" style="font-size: 0.9rem; font-weight: 600;">
                        <i class="bi-bar-chart-line me-1 text-warning"></i> Perbandingan Status
                    </h4>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="permohonanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Line Chart --}}
        <div class="col-lg-4 mb-3">
            <div class="card rounded-2 shadow-none border h-100">
                <div class="card-header card-header-content-between border-0 pb-0">
                    <h4 class="card-subtitle mb-0" style="font-size: 0.9rem; font-weight: 600;">
                        <i class="bi-graph-up me-1 text-success"></i> Tren Inovasi {{ $currentYear }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ TABLES SECTION ============ --}}
    <div class="row gx-3">
        {{-- Top 10 Inovator --}}
        <div class="col-lg-7 mb-3">
            <div class="card rounded-2 shadow-none border h-100">
                <div class="card-header card-header-content-between border-0">
                    <h4 class="card-subtitle mb-0" style="font-size: 0.9rem; font-weight: 600;">
                        <i class="bi-award me-1 text-warning"></i> Top 10 Inovator
                    </h4>
                    <span class="badge bg-soft-primary text-primary" style="font-size: 0.75rem;">{{ $totalInovator }} Total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-nowrap table-dashboard mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="ps-3" style="width: 50px;">#</th>
                                    <th>Nama Inovator</th>
                                    <th>OPD</th>
                                    <th class="text-center">Inovasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($groupedPermohonan as $i => $group)
                                @php $pemohon = $pemohonMap->get($group->id_pemohon_0); @endphp
                                @if($pemohon)
                                <tr>
                                    <td class="ps-3">
                                        @if($i < 3)
                                            <span class="rank-badge {{ $i == 0 ? 'bg-warning text-white' : ($i == 1 ? 'bg-secondary text-white' : 'bg-soft-warning text-warning') }}">{{ $i + 1 }}</span>
                                        @else
                                            <span class="text-muted">{{ $i + 1 }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="d-block fw-semibold" style="font-size: 0.85rem;">{{ $pemohon->name }}</span>
                                    </td>
                                    <td><span class="text-muted" style="font-size: 0.8rem;">{{ Str::limit($pemohon->unit_kerja, 40) }}</span></td>
                                    <td class="text-center">
                                        <span class="badge bg-soft-primary text-primary badge-status">{{ $group->jumlah }}</span>
                                    </td>
                                </tr>
                                @endif
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data inovator.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Inovasi Terbaru --}}
        <div class="col-lg-5 mb-3">
            <div class="card rounded-2 shadow-none border h-100">
                <div class="card-header card-header-content-between border-0">
                    <h4 class="card-subtitle mb-0" style="font-size: 0.9rem; font-weight: 600;">
                        <i class="bi-lightning me-1 text-info"></i> Inovasi Terbaru
                    </h4>
                    <span class="badge bg-soft-info text-info" style="font-size: 0.75rem;">5 Terbaru</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-dashboard mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="ps-3">Inovasi</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end pe-3">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentInovasi as $inovasi)
                                <tr>
                                    <td class="ps-3">
                                        <span class="d-block fw-semibold" style="font-size: 0.85rem;">{{ Str::limit($inovasi->label, 35) }}</span>
                                        @if($inovasi->pemohon1)
                                        <small class="text-muted">{{ Str::limit($inovasi->pemohon1->name, 25) }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @switch($inovasi->status)
                                            @case(0)
                                                <span class="badge bg-soft-warning text-warning badge-status">Proses</span>
                                                @break
                                            @case(1)
                                                <span class="badge bg-soft-info text-info badge-status">Disetujui</span>
                                                @break
                                            @case(2)
                                                <span class="badge bg-soft-primary text-primary badge-status">Validasi</span>
                                                @break
                                            @case(4)
                                                <span class="badge bg-soft-success text-success badge-status">Selesai</span>
                                                @break
                                            @default
                                                <span class="badge bg-soft-secondary text-secondary badge-status">-</span>
                                        @endswitch
                                    </td>
                                    <td class="text-end pe-3">
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($inovasi->created_at)->locale('id')->isoFormat('D MMM Y') }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Belum ada data inovasi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ KATEGORI & QUICK LINKS ============ --}}
    <div class="row gx-3 mb-3">
        {{-- Distribusi Kategori --}}
        <div class="col-lg-6 mb-3">
            <div class="card rounded-2 shadow-none border h-100">
                <div class="card-header card-header-content-between border-0">
                    <h4 class="card-subtitle mb-0" style="font-size: 0.9rem; font-weight: 600;">
                        <i class="bi-grid me-1 text-danger"></i> Distribusi Kategori Inovasi
                    </h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-dashboard mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="ps-3">Kategori</th>
                                    <th class="text-center">Jumlah</th>
                                    <th style="width: 40%;">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kategoriStats as $ki => $ks)
                                <tr>
                                    <td class="ps-3" style="font-size: 0.85rem;">{{ Str::limit($ks->label, 30) }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-soft-{{ $colors[$ki % count($colors)] }} text-{{ $colors[$ki % count($colors)] }} badge-status">{{ $ks->total }}</span>
                                    </td>
                                    <td>
                                        @php $persen = $totalPermohonan > 0 ? round(($ks->total / $totalPermohonan) * 100, 1) : 0; @endphp
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-thin flex-grow-1 me-2">
                                                <div class="progress-bar bg-{{ $colors[$ki % count($colors)] }}" style="width: {{ $persen }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $persen }}%</small>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Belum ada data kategori.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Validasi Chart --}}
        <div class="col-lg-6 mb-3">
            <div class="card rounded-2 shadow-none border h-100">
                <div class="card-header card-header-content-between border-0">
                    <h4 class="card-subtitle mb-0" style="font-size: 0.9rem; font-weight: 600;">
                        <i class="bi-shield-check me-1 text-primary"></i> Ringkasan Validasi
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-4">
                        <div class="col-6">
                            <div class="p-3 rounded-2" style="background: #f8f9fa;">
                                <h3 class="mb-1" style="font-weight: 700; color: #377dff;">{{ $statusValidasi }}</h3>
                                <small class="text-muted">Menunggu Validasi</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-2" style="background: #f8f9fa;">
                                <h3 class="mb-1" style="font-weight: 700; color: #00c9a7;">{{ $statusSelesai }}</h3>
                                <small class="text-muted">Tervalidasi</small>
                            </div>
                        </div>
                    </div>

                    @php
                        $totalVS = $statusValidasi + $statusSelesai;
                        $persenValidasi = $totalVS > 0 ? round(($statusSelesai / $totalVS) * 100, 1) : 0;
                    @endphp

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Tingkat Validasi</small>
                            <small class="fw-semibold">{{ $persenValidasi }}%</small>
                        </div>
                        <div class="progress" style="height: 10px; border-radius: 5px;">
                            <div class="progress-bar" style="width: {{ $persenValidasi }}%; background: linear-gradient(90deg, #00c9a7, #377dff); border-radius: 5px;"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        @php
                            $persenDisetujui = $totalPermohonan > 0 ? round(($statusSetuju / $totalPermohonan) * 100, 1) : 0;
                        @endphp
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Tingkat Persetujuan</small>
                            <small class="fw-semibold">{{ $persenDisetujui }}%</small>
                        </div>
                        <div class="progress" style="height: 10px; border-radius: 5px;">
                            <div class="progress-bar bg-info" style="width: {{ $persenDisetujui }}%; border-radius: 5px;"></div>
                        </div>
                    </div>

                    <div>
                        @php
                            $persenProses = $totalPermohonan > 0 ? round(($statusProses / $totalPermohonan) * 100, 1) : 0;
                        @endphp
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Masih Dalam Proses</small>
                            <small class="fw-semibold">{{ $persenProses }}%</small>
                        </div>
                        <div class="progress" style="height: 10px; border-radius: 5px;">
                            <div class="progress-bar bg-warning" style="width: {{ $persenProses }}%; border-radius: 5px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dashboardDetailModal" tabindex="-1" aria-labelledby="dashboardDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dashboardDetailModalLabel">Detail Dashboard</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-dashboard mb-0">
                            <thead class="thead-light" id="dashboardDetailHead"></thead>
                            <tbody id="dashboardDetailBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    (function () {
        var applications = @json($dashboardPermohonanJson);
        var categories = @json($kategoriStatsJson);
        var statusLabels = {
            0: 'Sedang Diproses',
            1: 'Disetujui',
            2: 'Dalam Validasi',
            3: 'Dikirim untuk Penilaian',
            4: 'Selesai',
            9: 'Ditolak'
        };
        var detailModal = null;
        var detailTitle = document.getElementById('dashboardDetailModalLabel');
        var detailHead = document.getElementById('dashboardDetailHead');
        var detailBody = document.getElementById('dashboardDetailBody');

        function getDetailModal() {
            if (!detailModal) {
                detailModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('dashboardDetailModal'));
            }

            return detailModal;
        }

        function escapeHtml(value) {
            return String(value === null || value === undefined ? '-' : value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function showApplications(title, items) {
            detailTitle.textContent = title + ' (' + items.length + ')';
            detailHead.innerHTML = '<tr><th>Inovasi</th><th>Inovator</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th class="text-end">Nilai</th></tr>';
            detailBody.innerHTML = items.length ? items.map(function (item) {
                return '<tr><td>' + escapeHtml(item.title) + '</td><td>' + escapeHtml(item.innovator) +
                    '</td><td>' + escapeHtml(item.category) + '</td><td>' + escapeHtml(statusLabels[item.status] || 'Status ' + item.status) +
                    '</td><td>' + escapeHtml(item.date) + '</td><td class="text-end">' + escapeHtml(item.score === null ? '-' : item.score) + '</td></tr>';
            }).join('') : '<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data.</td></tr>';
            getDetailModal().show();
        }

        function showInnovators() {
            var innovators = {};
            applications.forEach(function (item) {
                var key = item.innovator_id || item.innovator;
                if (!innovators[key]) innovators[key] = { name: item.innovator, total: 0 };
                innovators[key].total++;
            });
            var items = Object.keys(innovators).map(function (key) { return innovators[key]; })
                .sort(function (a, b) { return b.total - a.total; });
            detailTitle.textContent = 'Daftar Inovator (' + items.length + ')';
            detailHead.innerHTML = '<tr><th>Inovator</th><th class="text-center">Jumlah Inovasi</th></tr>';
            detailBody.innerHTML = items.length ? items.map(function (item) {
                return '<tr><td>' + escapeHtml(item.name) + '</td><td class="text-center">' + item.total + '</td></tr>';
            }).join('') : '<tr><td colspan="2" class="text-center text-muted py-4">Belum ada data.</td></tr>';
            getDetailModal().show();
        }

        function showCategories() {
            detailTitle.textContent = 'Daftar Kategori Inovasi (' + categories.length + ')';
            detailHead.innerHTML = '<tr><th>Kategori</th><th class="text-center">Jumlah Inovasi</th></tr>';
            detailBody.innerHTML = categories.length ? categories.map(function (item) {
                return '<tr><td>' + escapeHtml(item.label) + '</td><td class="text-center">' + item.total + '</td></tr>';
            }).join('') : '<tr><td colspan="2" class="text-center text-muted py-4">Belum ada data.</td></tr>';
            getDetailModal().show();
        }

        document.querySelectorAll('[data-dashboard-detail]').forEach(function (card) {
            function openDetail() {
                var type = card.getAttribute('data-dashboard-detail');
                if (type === 'inovator') return showInnovators();
                if (type === 'kategori') return showCategories();
                if (type === 'proses') return showApplications('Pengajuan Sedang Diproses', applications.filter(function (item) { return item.status === 0; }));
                if (type === 'setuju') return showApplications('Pengajuan Disetujui', applications.filter(function (item) { return item.status === 1; }));
                if (type === 'selesai') return showApplications('Pengajuan Selesai', applications.filter(function (item) { return item.status === 4; }));
                if (type === 'nilai') return showApplications('Rincian Nilai Inovasi', applications.filter(function (item) { return item.score !== null; }));
                return showApplications('Total Pengajuan', applications);
            }
            card.addEventListener('click', openDetail);
            card.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    openDetail();
                }
            });
        });
    })();
</script>
@endsection
