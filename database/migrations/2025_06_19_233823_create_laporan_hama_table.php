<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_hama', function (Blueprint $table) {
            $table->id();
            $table->string('nama_hama', 100);
            $table->string('jenis_tanaman', 100);
            $table->text('gejala');
            $table->enum('tingkat_kerusakan', ['ringan', 'sedang', 'berat']);
            $table->date('tanggal_lapor');
            $table->timestamps();

            // Indexes untuk performa query
            $table->index('nama_hama');
            $table->index('jenis_tanaman');
            $table->index('tingkat_kerusakan');
            $table->index('tanggal_lapor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_hama');
    }
};