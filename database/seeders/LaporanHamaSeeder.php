<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanHamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laporanHama = [
            [
                'nama_hama' => 'Wereng Batang Coklat',
                'jenis_tanaman' => 'Padi',
                'gejala' => 'Daun menguning, tanaman kerdil, dan terdapat bercak coklat pada batang',
                'tingkat_kerusakan' => 'sedang',
                'tanggal_lapor' => Carbon::parse('2025-01-15'),
                'created_at' => Carbon::parse('2025-01-10 10:00:00'),
                'updated_at' => Carbon::parse('2025-01-10 10:00:00'),
            ],
            [
                'nama_hama' => 'Bercak Daun Coklat',
                'jenis_tanaman' => 'Padi',
                'gejala' => 'Bercak oval berwarna coklat pada daun dengan tepi kuning',
                'tingkat_kerusakan' => 'ringan',
                'tanggal_lapor' => Carbon::parse('2025-02-05'),
                'created_at' => Carbon::parse('2025-02-01 11:40:00'),
                'updated_at' => Carbon::parse('2025-02-01 11:40:00'),
            ],
            [
                'nama_hama' => 'Penggerek Batang',
                'jenis_tanaman' => 'Padi',
                'gejala' => 'Batang berlubang, tanaman layu, dan terdapat serbuk gergaji di sekitar lubang',
                'tingkat_kerusakan' => 'berat',
                'tanggal_lapor' => Carbon::parse('2025-03-20'),
                'created_at' => Carbon::parse('2025-03-15 08:45:00'),
                'updated_at' => Carbon::parse('2025-03-15 08:45:00'),
            ],
            [
                'nama_hama' => 'Hawar Daun',
                'jenis_tanaman' => 'Padi',
                'gejala' => 'Bercak basah berwarna hijau keabu-abuan pada daun',
                'tingkat_kerusakan' => 'sedang',
                'tanggal_lapor' => Carbon::parse('2025-04-10'),
                'created_at' => Carbon::parse('2025-04-05 12:00:00'),
                'updated_at' => Carbon::parse('2025-04-05 12:00:00'),
            ],
            [
                'nama_hama' => 'Wereng Batang Coklat',
                'jenis_tanaman' => 'Padi',
                'gejala' => 'Tanaman menguning dari bawah, pertumbuhan terhambat, dan malai tidak keluar',
                'tingkat_kerusakan' => 'berat',
                'tanggal_lapor' => Carbon::parse('2025-05-01'),
                'created_at' => Carbon::parse('2025-04-28 16:30:00'),
                'updated_at' => Carbon::parse('2025-04-28 16:30:00'),
            ],

            // Jagung
            [
                'nama_hama' => 'Ulat Grayak',
                'jenis_tanaman' => 'Jagung',
                'gejala' => 'Daun berlubang-lubang, terdapat kotoran ulat, dan tanaman tampak gundul',
                'tingkat_kerusakan' => 'berat',
                'tanggal_lapor' => Carbon::parse('2025-01-20'),
                'created_at' => Carbon::parse('2025-01-18 09:30:00'),
                'updated_at' => Carbon::parse('2025-01-18 09:30:00'),
            ],
            [
                'nama_hama' => 'Karat Daun',
                'jenis_tanaman' => 'Jagung',
                'gejala' => 'Bercak oranye/kuning pada daun, menyebar cepat',
                'tingkat_kerusakan' => 'sedang',
                'tanggal_lapor' => Carbon::parse('2025-03-01'),
                'created_at' => Carbon::parse('2025-02-25 11:00:00'),
                'updated_at' => Carbon::parse('2025-02-25 11:00:00'),
            ],
            [
                'nama_hama' => 'Busuk Pelepah',
                'jenis_tanaman' => 'Jagung',
                'gejala' => 'Pelepah daun membusuk, berbau, tanaman mudah rebah',
                'tingkat_kerusakan' => 'berat',
                'tanggal_lapor' => Carbon::parse('2025-04-18'),
                'created_at' => Carbon::parse('2025-04-15 14:00:00'),
                'updated_at' => Carbon::parse('2025-04-15 14:00:00'),
            ],
            [
                'nama_hama' => 'Penggerek Tongkol',
                'jenis_tanaman' => 'Jagung',
                'gejala' => 'Adanya lubang pada tongkol, biji rusak',
                'tingkat_kerusakan' => 'sedang',
                'tanggal_lapor' => Carbon::parse('2025-05-12'),
                'created_at' => Carbon::parse('2025-05-08 10:30:00'),
                'updated_at' => Carbon::parse('2025-05-08 10:30:00'),
            ],

            // Sawi
            [
                'nama_hama' => 'Ulat Jengkal',
                'jenis_tanaman' => 'Sawi',
                'gejala' => 'Daun berlubang besar, ulat berwarna hijau kecoklatan',
                'tingkat_kerusakan' => 'sedang',
                'tanggal_lapor' => Carbon::parse('2025-01-25'),
                'created_at' => Carbon::parse('2025-01-20 08:30:00'),
                'updated_at' => Carbon::parse('2025-01-20 08:30:00'),
            ],
            [
                'nama_hama' => 'Kutu Daun',
                'jenis_tanaman' => 'Sawi',
                'gejala' => 'Daun keriting, menguning, terdapat serangga kecil di bawah daun',
                'tingkat_kerusakan' => 'ringan',
                'tanggal_lapor' => Carbon::parse('2025-03-10'),
                'created_at' => Carbon::parse('2025-03-05 09:00:00'),
                'updated_at' => Carbon::parse('2025-03-05 09:00:00'),
            ],
            [
                'nama_hama' => 'Bercak Alternaria',
                'jenis_tanaman' => 'Sawi',
                'gejala' => 'Bercak konsentris berwarna gelap pada daun',
                'tingkat_kerusakan' => 'sedang',
                'tanggal_lapor' => Carbon::parse('2025-05-05'),
                'created_at' => Carbon::parse('2025-05-01 11:15:00'),
                'updated_at' => Carbon::parse('2025-05-01 11:15:00'),
            ],

            // Tomat
            [
                'nama_hama' => 'Trips',
                'jenis_tanaman' => 'Tomat',
                'gejala' => 'Daun berbercak perak, menggulung, dan pertumbuhan terhambat',
                'tingkat_kerusakan' => 'sedang',
                'tanggal_lapor' => Carbon::parse('2025-02-10'),
                'created_at' => Carbon::parse('2025-02-05 11:00:00'),
                'updated_at' => Carbon::parse('2025-02-05 11:00:00'),
            ],
            [
                'nama_hama' => 'Ulat Buah',
                'jenis_tanaman' => 'Tomat',
                'gejala' => 'Buah berlubang, busuk, dan terdapat ulat di dalam buah',
                'tingkat_kerusakan' => 'berat',
                'tanggal_lapor' => Carbon::parse('2025-03-15'),
                'created_at' => Carbon::parse('2025-03-10 13:00:00'),
                'updated_at' => Carbon::parse('2025-03-10 13:00:00'),
            ],
            [
                'nama_hama' => 'Layum Fusarium',
                'jenis_tanaman' => 'Tomat',
                'gejala' => 'Tanaman layu dari bawah, pembuluh batang coklat',
                'tingkat_kerusakan' => 'berat',
                'tanggal_lapor' => Carbon::parse('2025-04-22'),
                'created_at' => Carbon::parse('2025-04-18 10:40:00'),
                'updated_at' => Carbon::parse('2025-04-18 10:40:00'),
            ],

            // Cabai
            [
                'nama_hama' => 'Kutu Daun',
                'jenis_tanaman' => 'Cabai',
                'gejala' => 'Daun keriting, menguning, dan terdapat serangga kecil di bawah daun',
                'tingkat_kerusakan' => 'ringan',
                'tanggal_lapor' => Carbon::parse('2025-01-01'),
                'created_at' => Carbon::parse('2025-01-01 14:15:00'),
                'updated_at' => Carbon::parse('2025-01-01 14:15:00'),
            ],
            [
                'nama_hama' => 'Kutu Kebul',
                'jenis_tanaman' => 'Cabai',
                'gejala' => 'Daun menguning, keriting, dan serangga putih kecil di bawah daun',
                'tingkat_kerusakan' => 'sedang',
                'tanggal_lapor' => Carbon::parse('2025-02-28'),
                'created_at' => Carbon::parse('2025-02-25 15:00:00'),
                'updated_at' => Carbon::parse('2025-02-25 15:00:00'),
            ],
            [
                'nama_hama' => 'Antraknosa',
                'jenis_tanaman' => 'Cabai',
                'gejala' => 'Bercak cekung hitam pada buah, buah membusuk',
                'tingkat_kerusakan' => 'berat',
                'tanggal_lapor' => Carbon::parse('2025-04-05'),
                'created_at' => Carbon::parse('2025-04-01 10:00:00'),
                'updated_at' => Carbon::parse('2025-04-01 10:00:00'),
            ],
            [
                'nama_hama' => 'Virus Kuning',
                'jenis_tanaman' => 'Cabai',
                'gejala' => 'Daun menguning total, keriting parah, pertumbuhan sangat terhambat',
                'tingkat_kerusakan' => 'berat',
                'tanggal_lapor' => Carbon::parse('2025-05-18'),
                'created_at' => Carbon::parse('2025-05-15 09:55:00'),
                'updated_at' => Carbon::parse('2025-05-15 09:55:00'),
            ],
        ];

        DB::table('laporan_hama')->insert($laporanHama);
    }
}