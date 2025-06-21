@extends('layouts.app')

@section('title', 'Tambah Laporan Hama - AgroDisease')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Laporan Hama dan Penyakit
                </h4>
            </div>
            
            <div class="card-body">
                <form action="{{ route('laporan.store') }}" method="POST">
                    @csrf
                    
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
                                       value="{{ old('nama_hama') }}"
                                       placeholder="Contoh: Wereng Batang Coklat">
                                @error('nama_hama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_tanaman" class="form-label">
                                    Jenis Tanaman <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('jenis_tanaman') is-invalid @enderror" 
                                       id="jenis_tanaman" 
                                       name="jenis_tanaman" 
                                       value="{{ old('jenis_tanaman') }}"
                                       placeholder="Contoh: Padi, Jagung, Cabai">
                                @error('jenis_tanaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> -->

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_tanaman" class="form-label">
                                    Jenis Tanaman <span class="text-danger">*</span>
                                </label>
                                {{-- Ganti input type="text" dengan select dropdown ini --}}
                                <select class="form-control @error('jenis_tanaman') is-invalid @enderror"
                                        id="jenis_tanaman"
                                        name="jenis_tanaman">
                                    <option value="">Pilih Jenis Tanaman</option>
                                    @php
                                        $jenisTanamanList = ['Padi', 'Jagung', 'Cabai', 'Tomat', 'Sawi', 'Terong', 'Kentang', 'Mangga', 'Bawang Merah', 'Singkong', 'Jahe', 'Kopi', 'Jeruk', 'Mentimun'];
                                        sort($jenisTanamanList); // Opsional: untuk mengurutkan abjad
                                    @endphp
                                    @foreach($jenisTanamanList as $tanaman)
                                        <option value="{{ $tanaman }}" {{ old('jenis_tanaman') == $tanaman ? 'selected' : '' }}>
                                            {{ $tanaman }}
                                        </option>
                                    @endforeach
                                </select>
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
                                  placeholder="Deskripsikan gejala yang terlihat pada tanaman, seperti perubahan warna daun, kerusakan batang, dll.">{{ old('gejala') }}</textarea>
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
                                    <option value="ringan" {{ old('tingkat_kerusakan') == 'ringan' ? 'selected' : '' }}>
                                        Ringan (< 25%)
                                    </option>
                                    <option value="sedang" {{ old('tingkat_kerusakan') == 'sedang' ? 'selected' : '' }}>
                                        Sedang (25% - 50%)
                                    </option>
                                    <option value="berat" {{ old('tingkat_kerusakan') == 'berat' ? 'selected' : '' }}>
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
                                       value="{{ old('tanggal_lapor', date('Y-m-d')) }}"
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
                            Semua field yang bertanda <span class="text-danger">*</span> wajib diisi
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i>Simpan Laporan
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

<!-- Tips Card -->
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Tips Pengisian Laporan</h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li><strong>Nama Hama:</strong> Gunakan nama yang spesifik dan mudah dikenali</li>
                    <li><strong>Gejala:</strong> Deskripsikan secara detail apa yang terlihat pada tanaman</li>
                    <li><strong>Tingkat Kerusakan:</strong> Perkirakan persentase kerusakan pada tanaman</li>
                    <li><strong>Tanggal:</strong> Gunakan tanggal saat pertama kali gejala ditemukan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
