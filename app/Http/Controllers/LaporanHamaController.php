<?php

namespace App\Http\Controllers;

use App\Models\LaporanHama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LaporanHamaController extends Controller
{
    /**
     * Menggunakan Query Builder (DB Helper)
     */
    public function index(Request $request)
    {
        // Menggunakan Query Builder untuk menampilkan data
        $query = DB::table('laporan_hama')
            ->select('*')
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan jenis tanaman jika ada
        if ($request->filled('jenis_tanaman')) {
            $query->where('jenis_tanaman', $request->jenis_tanaman);
        }

        $laporanHama = $query->paginate(10);

        // Mendapatkan daftar jenis tanaman untuk filter
        $jenisTanaman = DB::table('laporan_hama')
            ->select('jenis_tanaman')
            ->distinct()
            ->orderBy('jenis_tanaman')
            ->pluck('jenis_tanaman');

        return view('laporan.index', compact('laporanHama', 'jenisTanaman'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    /**
     * Menggunakan Eloquent ORM
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_hama' => 'required|string|max:100|min:3',
            'jenis_tanaman' => 'required|string|max:100|min:3',
            'gejala' => 'required|string|min:10',
            'tingkat_kerusakan' => ['required', Rule::in(['ringan', 'sedang', 'berat'])],
            'tanggal_lapor' => 'required|date|before_or_equal:today'
        ], [
            'nama_hama.required' => 'Nama hama wajib diisi',
            'nama_hama.min' => 'Nama hama minimal 3 karakter',
            'nama_hama.max' => 'Nama hama maksimal 100 karakter',
            'jenis_tanaman.required' => 'Jenis tanaman wajib diisi',
            'jenis_tanaman.min' => 'Jenis tanaman minimal 3 karakter',
            'jenis_tanaman.max' => 'Jenis tanaman maksimal 100 karakter',
            'gejala.required' => 'Gejala wajib diisi',
            'gejala.min' => 'Gejala minimal 10 karakter',
            'tingkat_kerusakan.required' => 'Tingkat kerusakan wajib dipilih',
            'tingkat_kerusakan.in' => 'Tingkat kerusakan harus salah satu: ringan, sedang, berat',
            'tanggal_lapor.required' => 'Tanggal lapor wajib diisi',
            'tanggal_lapor.date' => 'Format tanggal tidak valid',
            'tanggal_lapor.before_or_equal' => 'Tanggal lapor tidak boleh lebih dari hari ini'
        ]);

        // Menggunakan Eloquent ORM untuk menyimpan data
        LaporanHama::create($validated);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan hama berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Menggunakan Eloquent ORM untuk mengambil data
        $laporanHama = LaporanHama::findOrFail($id);
        
        return view('laporan.edit', compact('laporanHama'));
    }

    /**
     * Menggunakan Eloquent ORM
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_hama' => 'required|string|max:100|min:3',
            'jenis_tanaman' => 'required|string|max:100|min:3',
            'gejala' => 'required|string|min:10',
            'tingkat_kerusakan' => ['required', Rule::in(['ringan', 'sedang', 'berat'])],
            'tanggal_lapor' => 'required|date|before_or_equal:today'
        ], [
            'nama_hama.required' => 'Nama hama wajib diisi',
            'nama_hama.min' => 'Nama hama minimal 3 karakter',
            'nama_hama.max' => 'Nama hama maksimal 100 karakter',
            'jenis_tanaman.required' => 'Jenis tanaman wajib diisi',
            'jenis_tanaman.min' => 'Jenis tanaman minimal 3 karakter',
            'jenis_tanaman.max' => 'Jenis tanaman maksimal 100 karakter',
            'gejala.required' => 'Gejala wajib diisi',
            'gejala.min' => 'Gejala minimal 10 karakter',
            'tingkat_kerusakan.required' => 'Tingkat kerusakan wajib dipilih',
            'tingkat_kerusakan.in' => 'Tingkat kerusakan harus salah satu: ringan, sedang, berat',
            'tanggal_lapor.required' => 'Tanggal lapor wajib diisi',
            'tanggal_lapor.date' => 'Format tanggal tidak valid',
            'tanggal_lapor.before_or_equal' => 'Tanggal lapor tidak boleh lebih dari hari ini'
        ]);

        // Menggunakan Eloquent ORM untuk update data
        $laporanHama = LaporanHama::findOrFail($id);
        $laporanHama->update($validated);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan hama berhasil diperbarui!');
    }

    /**
     * Menggunakan Eloquent ORM
     */
    public function destroy($id)
    {
        // Menggunakan Eloquent ORM untuk menghapus data
        $laporanHama = LaporanHama::findOrFail($id);
        $laporanHama->delete();

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan hama berhasil dihapus!');
    }

    /**
     * Menggunakan DB Raw SQL
     */
    public function statistik()
    {
        // Menggunakan DB Raw untuk statistik jumlah serangan per nama hama
        $statistikHama = DB::select("
            SELECT 
                nama_hama, 
                COUNT(*) as jumlah_kasus,
                AVG(CASE 
                    WHEN tingkat_kerusakan = 'ringan' THEN 1 
                    WHEN tingkat_kerusakan = 'sedang' THEN 2 
                    WHEN tingkat_kerusakan = 'berat' THEN 3 
                END) as rata_rata_kerusakan
            FROM laporan_hama 
            GROUP BY nama_hama 
            ORDER BY jumlah_kasus DESC
        ");

        // Statistik berdasarkan jenis tanaman
        $statistikTanaman = DB::select("
            SELECT 
                jenis_tanaman, 
                COUNT(*) as jumlah_kasus,
                COUNT(CASE WHEN tingkat_kerusakan = 'berat' THEN 1 END) as kasus_berat
            FROM laporan_hama 
            GROUP BY jenis_tanaman 
            ORDER BY jumlah_kasus DESC
        ");

        // Statistik berdasarkan bulan
        $statistikBulan = DB::select("
            SELECT 
                MONTH(tanggal_lapor) as bulan,
                YEAR(tanggal_lapor) as tahun,
                COUNT(*) as jumlah_kasus
            FROM laporan_hama 
            WHERE tanggal_lapor >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
            GROUP BY YEAR(tanggal_lapor), MONTH(tanggal_lapor)
            ORDER BY tahun DESC, bulan DESC
        ");

        // Total statistik umum
        $totalLaporan = DB::selectOne("SELECT COUNT(*) as total FROM laporan_hama")->total;
        $totalHamaUnik = DB::selectOne("SELECT COUNT(DISTINCT nama_hama) as total FROM laporan_hama")->total;
        $totalTanamanUnik = DB::selectOne("SELECT COUNT(DISTINCT jenis_tanaman) as total FROM laporan_hama")->total;

        return view('laporan.statistik', compact(
            'statistikHama', 
            'statistikTanaman', 
            'statistikBulan',
            'totalLaporan',
            'totalHamaUnik',
            'totalTanamanUnik'
        ));
    }
}
