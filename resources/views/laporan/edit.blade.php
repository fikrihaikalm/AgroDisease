@extends('layouts.app')

@section('title', 'Edit Laporan Hama - AgroDisease')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-pencil me-2"></i>Edit Laporan Hama dan Penyakit
                </h4>
            </div>
            
            <div class="card-body">
                <form action="{{ route('laporan.update', $laporanHama->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_hama" class="form-label">
                                    Nama Hama/Penyakit <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nama_hama') is-invalid @enderror" 
                                       id="nama_hama" 
                                       name="nama_hama" 
                                       value="{{ old('nama_hama', $laporanHama->nama_hama) }}"
                                       placeholder="Contoh: Wereng Batang Coklat">
                                @error('nama_hama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_tanaman" class="form-label">
                                    Jenis Tanaman <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('jenis_tanaman') is-invalid @enderror" 
                                       id="jenis_tanaman" 
                                       name="jenis_tanaman" 
                                       value="{{ old('jenis_tanaman', $laporanHama->jenis_tanaman) }}"
                                       placeholder="Contoh: Padi, Jagung, Cabai">
                                @error('jenis_tanaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="gejala" class="form-label">
                            Gejala yang Diamati <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('gejala') is-invalid @enderror" 
                                  id="gejala" 
                                  name="gejala" 
                                  rows="4"
                                  placeholder="Deskripsikan gejala yang terlihat pada tanaman">{{ old('gejala', $laporanHama->gejala) }}</textarea>
                        @error('gejala')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tingkat_kerusakan" class="form-label">
                                    Tingkat Kerusakan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('tingkat_kerusakan') is-invalid @enderror" 
                                        id="tingkat_kerusakan" 
                                        name="tingkat_kerusakan">
                                    <option value="">-- Pilih Tingkat Kerusakan --</option>
                                    <option value="ringan" 
                                            {{ old('tingkat_kerusakan', $laporanHama->tingkat_kerusakan) == 'ringan' ? 'selected' : '' }}>
                                        Ringan (< 25%)
                                    </option>
                                    <option value="sedang" 
                                            {{ old('tingkat_kerusakan', $laporanHama->tingkat_kerusakan) == 'sedang' ? 'selected' : '' }}>
                                        Sedang (25% - 50%)
                                    </option>
                                    <option value="berat" 
                                            {{ old('tingkat_kerusakan', $laporanHama->tingkat_kerusakan) == 'berat' ? 'selected' : '' }}>
                                        Berat (> 50%)
                                    </option>
                                </select>
                                @error('tingkat_kerusakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_lapor" class="form-label">
                                    Tanggal Laporan <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('tanggal_lapor') is-invalid @enderror" 
                                       id="tanggal_lapor" 
                                       name="tanggal_lapor" 
                                       value="{{ old('tanggal_lapor', $laporanHama->tanggal_lapor->format('Y-m-d')) }}"
                                       max="{{ date('Y-m-d') }}">
                                @error('tanggal_lapor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Terakhir diperbarui: {{ $laporanHama->updated_at->format('d-m-Y H:i') }}
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i>Perbarui Laporan
                        </button>
                        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Current Data Preview -->
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card border-secondary">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0"><i class="bi bi-eye me-2"></i>Data Saat Ini</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nama Hama:</strong> {{ $laporanHama->nama_hama }}</p>
                        <p><strong>Jenis Tanaman:</strong> {{ $laporanHama->jenis_tanaman }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tingkat Kerusakan:</strong> 
                            <span class="badge badge-{{ $laporanHama->tingkat_kerusakan }}">
                                {{ ucfirst($laporanHama->tingkat_kerusakan) }}
                            </span>
                        </p>
                        <p><strong>Tanggal Lapor:</strong> {{ $laporanHama->tanggal_lapor->format('d-m-Y') }}</p>
                    </div>
                </div>
                <p><strong>Gejala:</strong></p>
                <p class="text-muted">{{ $laporanHama->gejala }}</p>
            </div>
        </div>
    </div>
</div>
@endsection