@extends('layouts.app')

@section('title', 'Statistik Serangan Hama - AgroDisease')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-bar-chart me-2"></i>Statistik Serangan Hama dan Penyakit
                </h4>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-0">Total Laporan</h6>
                        <h2 class="mb-0">{{ $totalLaporan }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-file-text display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-0">Jenis Hama</h6>
                        <h2 class="mb-0">{{ $totalHamaUnik }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-bug display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-0">Jenis Tanaman</h6>
                        <h2 class="mb-0">{{ $totalTanamanUnik }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-tree display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mt-4">
    <!-- Statistik Hama -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-bug me-2"></i>Jumlah Kasus per Jenis Hama
                </h5>
            </div>
            <div class="card-body">
                <canvas id="chartHama" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Statistik Tanaman -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-tree me-2"></i>Jumlah Kasus per Jenis Tanaman
                </h5>
            </div>
            <div class="card-body">
                <canvas id="chartTanaman" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="row mt-4">
    <!-- Tabel Statistik Hama -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-table me-2"></i>Detail Statistik Hama
                </h5>
            </div>
            <div class="card-body">
                @if(count($statistikHama) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama Hama</th>
                                    <th class="text-center">Jumlah Kasus</th>
                                    <th class="text-center">Rata-rata Kerusakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistikHama as $hama)
                                    <tr>
                                        <td>{{ $hama->nama_hama }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $hama->jumlah_kasus }}</span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $rataRata = round($hama->rata_rata_kerusakan, 1);
                                                $tingkat = $rataRata <= 1.5 ? 'ringan' : ($rataRata <= 2.5 ? 'sedang' : 'berat');
                                            @endphp
                                            <span class="badge badge-{{ $tingkat }}">
                                                {{ ucfirst($tingkat) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada data statistik hama</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabel Statistik Tanaman -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-table me-2"></i>Detail Statistik Tanaman
                </h5>
            </div>
            <div class="card-body">
                @if(count($statistikTanaman) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Jenis Tanaman</th>
                                    <th class="text-center">Total Kasus</th>
                                    <th class="text-center">Kasus Berat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistikTanaman as $tanaman)
                                    <tr>
                                        <td>{{ $tanaman->jenis_tanaman }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $tanaman->jumlah_kasus }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($tanaman->kasus_berat > 0)
                                                <span class="badge bg-danger">{{ $tanaman->kasus_berat }}</span>
                                            @else
                                                <span class="badge bg-success">0</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada data statistik tanaman</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Trend Bulanan -->
@if(count($statistikBulan) > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up me-2"></i>Trend Laporan 12 Bulan Terakhir
                </h5>
            </div>
            <div class="card-body">
                <canvas id="chartTrend" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Action Buttons -->
<div class="row mt-4">
    <div class="col-12 text-center">
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary me-2">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Laporan
        </a>
        <a href="{{ route('laporan.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i>Tambah Laporan Baru
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Data untuk Chart Hama
const dataHama = {
    labels: [
        @foreach($statistikHama as $hama)
            '{{ $hama->nama_hama }}',
        @endforeach
    ],
    datasets: [{
        label: 'Jumlah Kasus',
        data: [
            @foreach($statistikHama as $hama)
                {{ $hama->jumlah_kasus }},
            @endforeach
        ],
        backgroundColor: [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
        ],
        borderWidth: 1
    }]
};

// Chart Hama
const ctxHama = document.getElementById('chartHama').getContext('2d');
new Chart(ctxHama, {
    type: 'doughnut',
    data: dataHama,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Data untuk Chart Tanaman
const dataTanaman = {
    labels: [
        @foreach($statistikTanaman as $tanaman)
            '{{ $tanaman->jenis_tanaman }}',
        @endforeach
    ],
    datasets: [{
        label: 'Jumlah Kasus',
        data: [
            @foreach($statistikTanaman as $tanaman)
                {{ $tanaman->jumlah_kasus }},
            @endforeach
        ],
        backgroundColor: '#36A2EB',
        borderColor: '#36A2EB',
        borderWidth: 1
    }]
};

// Chart Tanaman
const ctxTanaman = document.getElementById('chartTanaman').getContext('2d');
new Chart(ctxTanaman, {
    type: 'bar',
    data: dataTanaman,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

@if(count($statistikBulan) > 0)
// Data untuk Chart Trend
const dataTrend = {
    labels: [
        @foreach($statistikBulan as $bulan)
            '{{ date("M Y", mktime(0, 0, 0, $bulan->bulan, 1, $bulan->tahun)) }}',
        @endforeach
    ],
    datasets: [{
        label: 'Jumlah Laporan',
        data: [
            @foreach($statistikBulan as $bulan)
                {{ $bulan->jumlah_kasus }},
            @endforeach
        ],
        borderColor: '#28a745',
        backgroundColor: 'rgba(40, 167, 69, 0.1)',
        tension: 0.4,
        fill: true
    }]
};

// Chart Trend
const ctxTrend = document.getElementById('chartTrend').getContext('2d');
new Chart(ctxTrend, {
    type: 'line',
    data: dataTrend,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
@endif
</script>
@endpush