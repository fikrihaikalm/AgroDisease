<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LaporanHama extends Model
{
    use HasFactory;

    protected $table = 'laporan_hama';

    protected $fillable = [
        'nama_hama',
        'jenis_tanaman',
        'gejala',
        'tingkat_kerusakan',
        'tanggal_lapor'
    ];

    protected $casts = [
        'tanggal_lapor' => 'date',
    ];

    // Accessor untuk format tanggal Indonesia
    public function getTanggalLaporFormattedAttribute()
    {
        return $this->tanggal_lapor ? $this->tanggal_lapor->format('d-m-Y') : '';
    }

    // Accessor untuk format created_at
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->format('d-m-Y H:i') : '';
    }

    // Scope untuk filter berdasarkan jenis tanaman
    public function scopeByJenisTanaman($query, $jenisTanaman)
    {
        return $query->where('jenis_tanaman', $jenisTanaman);
    }

    // Scope untuk filter berdasarkan tingkat kerusakan
    public function scopeByTingkatKerusakan($query, $tingkatKerusakan)
    {
        return $query->where('tingkat_kerusakan', $tingkatKerusakan);
    }
}