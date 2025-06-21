@extends('layouts.app')

@section('title', 'Daftar Laporan Hama - AgroDisease')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0">
                            <i class="bi bi-list-ul me-2"></i>Daftar Laporan Hama dan Penyakit
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('laporan.create') }}" class="btn btn-light">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Laporan
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="jenis_tanaman" class="form-label">Filter Jenis Tanaman</label>
                            <select name="jenis_tanaman" id="jenis_tanaman" class="form-select">
                                <option value="">-- Semua Jenis Tanaman --</option>
                                @foreach($jenisTanaman as $jenis)
                                    <option value="{{ $jenis }}" 
                                            {{ request('jenis_tanaman') == $jenis ? 'selected' : '' }}>
                                        {{ $jenis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-success me-2">
                                    <i class="bi bi-funnel me-1"></i>Filter
                                </button>
                                <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Data Table -->
                @if($laporanHama->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Nama Hama</th>
                                    <th width="15%">Jenis Tanaman</th>
                                    <th width="30%">Gejala</th>
                                    <th width="12%">Tingkat Kerusakan</th>
                                    <th width="12%">Tanggal Lapor</th>
                                    <th width="11%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporanHama as $index => $laporan)
                                    <tr>
                                        <td>{{ $laporanHama->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $laporan->nama_hama }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $laporan->jenis_tanaman }}</span>
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($laporan->gejala, 80) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $laporan->tingkat_kerusakan }}">
                                                {{ ucfirst($laporan->tingkat_kerusakan) }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ \Carbon\Carbon::parse($laporan->tanggal_lapor)->format('d-m-Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('laporan.edit', $laporan->id) }}" 
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('laporan.destroy', $laporan->id) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">
                                Menampilkan {{ $laporanHama->firstItem() }} - {{ $laporanHama->lastItem() }} 
                                dari {{ $laporanHama->total() }} data
                            </small>
                        </div>
                        <div>
                            {{ $laporanHama->appends(request()->query())->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">Belum ada data laporan</h5>
                        <p class="text-muted">Silakan tambah laporan hama atau penyakit tanaman</p>
                        <a href="{{ route('laporan.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Laporan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Info Cards -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-0">Total Laporan</h6>
                        <h3 class="mb-0">{{ $laporanHama->total() }}</h3>
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
                        <h6 class="card-title mb-0">Jenis Tanaman</h6>
                        <h3 class="mb-0">{{ $jenisTanaman->count() }}</h3>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-tree display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-0">Lihat Statistik</h6>
                        <small>Analisis data lengkap</small>
                    </div>
                    <div class="ms-3">
                        <a href="{{ route('laporan.statistik') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-bar-chart me-1"></i>Buka
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection