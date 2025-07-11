# AgroDisease - Sistem Pendataan Hama dan Penyakit Tanaman

<p align="center">
    <img src="public/logo_agrodisease.png" width="200" alt="AgroDisease Logo">
</p>

<p align="center">
    <strong>Tugas Operasi Database: ORM, HELPER, dan RAW SQL</strong><br>
    Sistem manajemen laporan hama dan penyakit tanaman berbasis Laravel
</p>

## 📋 Deskripsi Proyek

AgroDisease adalah aplikasi web yang dibangun menggunakan Laravel untuk mengelola laporan hama dan penyakit tanaman. Proyek ini dibuat sebagai implementasi tugas **Operasi Database** yang mendemonstrasikan penggunaan:

- **Eloquent ORM** - Object-Relational Mapping Laravel
- **Query Builder (Helper)** - Database helper Laravel
- **Raw SQL** - Query SQL mentah untuk operasi kompleks

## 🎯 Tujuan Pembelajaran

Proyek ini bertujuan untuk mendemonstrasikan pemahaman tentang:

1. **Eloquent ORM**: Penggunaan model, relationships, accessors, dan scopes.
2. **Query Builder**: Operasi database menggunakan DB facade Laravel
3. **Raw SQL**: Implementasi query SQL kompleks untuk statistik dan analisis data
4. **Database Migration**: Struktur database dan indexing
5. **Validation**: Validasi data input dengan custom messages

## 🚀 Fitur Utama

### 1. Manajemen Laporan Hama
- ✅ **Create** - Tambah laporan hama baru (Eloquent ORM)
- ✅ **Read** - Tampilkan daftar laporan dengan filter (Query Builder)
- ✅ **Update** - Edit laporan hama (Eloquent ORM)
- ✅ **Delete** - Hapus laporan hama (Eloquent ORM)

### 2. Statistik dan Analisis
- 📊 **Statistik Hama** - Analisis jumlah kasus per jenis hama (Raw SQL)
- 🌱 **Statistik Tanaman** - Analisis serangan per jenis tanaman (Raw SQL)
- 📅 **Statistik Bulanan** - Tren laporan per bulan (Raw SQL)
- 📈 **Dashboard Umum** - Total laporan, hama unik, tanaman unik (Raw SQL)

## 🛠️ Teknologi yang Digunakan

- **Framework**: Laravel 10.x
- **PHP**: ^8.1
- **Database**: MySQL/MariaDB
- **Frontend**: Blade Templates, Bootstrap
- **Package Manager**: Composer

## 📁 Struktur Database

### Tabel: `laporan_hama`
```sql
CREATE TABLE laporan_hama (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_hama VARCHAR(100) NOT NULL,
    jenis_tanaman VARCHAR(100) NOT NULL,
    gejala TEXT NOT NULL,
    tingkat_kerusakan ENUM('ringan', 'sedang', 'berat') NOT NULL,
    tanggal_lapor DATE NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_nama_hama (nama_hama),
    INDEX idx_jenis_tanaman (jenis_tanaman),
    INDEX idx_tingkat_kerusakan (tingkat_kerusakan),
    INDEX idx_tanggal_lapor (tanggal_lapor)
);
```

## 🔧 Implementasi Operasi Database

### 1. Eloquent ORM

#### Model: `LaporanHama.php`
```php
class LaporanHama extends Model
{
    protected $fillable = [
        'nama_hama', 'jenis_tanaman', 'gejala',
        'tingkat_kerusakan', 'tanggal_lapor'
    ];

    // Accessor untuk format tanggal
    public function getTanggalLaporFormattedAttribute()
    {
        return $this->tanggal_lapor ? $this->tanggal_lapor->format('d-m-Y') : '';
    }

    // Scope untuk filter
    public function scopeByJenisTanaman($query, $jenisTanaman)
    {
        return $query->where('jenis_tanaman', $jenisTanaman);
    }
}
```

#### Operasi CRUD dengan Eloquent:
```php
// CREATE - Menyimpan data baru
LaporanHama::create($validated);

// READ - Mengambil data dengan relasi
$laporanHama = LaporanHama::findOrFail($id);

// UPDATE - Memperbarui data
$laporanHama->update($validated);

// DELETE - Menghapus data
$laporanHama->delete();
```

### 2. Query Builder (Helper)

#### Penggunaan DB Facade:
```php
// Menampilkan data dengan filter dan pagination
$query = DB::table('laporan_hama')
    ->select('*')
    ->orderBy('created_at', 'desc');

if ($request->filled('jenis_tanaman')) {
    $query->where('jenis_tanaman', $request->jenis_tanaman);
}

$laporanHama = $query->paginate(10);

// Mendapatkan data unik untuk filter
$jenisTanaman = DB::table('laporan_hama')
    ->select('jenis_tanaman')
    ->distinct()
    ->orderBy('jenis_tanaman')
    ->pluck('jenis_tanaman');
```

### 3. Raw SQL

#### Statistik Kompleks dengan Raw SQL:
```php
// Statistik per nama hama dengan rata-rata tingkat kerusakan
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

// Tren bulanan (12 bulan terakhir)
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
```

## 📊 Fitur Validasi

### Custom Validation Rules:
```php
$validated = $request->validate([
    'nama_hama' => 'required|string|max:100|min:3',
    'jenis_tanaman' => 'required|string|max:100|min:3',
    'gejala' => 'required|string|min:10',
    'tingkat_kerusakan' => ['required', Rule::in(['ringan', 'sedang', 'berat'])],
    'tanggal_lapor' => 'required|date|before_or_equal:today'
], [
    'nama_hama.required' => 'Nama hama wajib diisi',
    'nama_hama.min' => 'Nama hama minimal 3 karakter',
    'tingkat_kerusakan.in' => 'Tingkat kerusakan harus: ringan, sedang, atau berat',
    'tanggal_lapor.before_or_equal' => 'Tanggal lapor tidak boleh lebih dari hari ini'
]);
```

## 🚀 Instalasi dan Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd AgroDisease
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agrodisease
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Migration
```bash
# Jalankan migration untuk membuat tabel
php artisan migrate
```

### 6. Jalankan Aplikasi
```bash
# Development server
php artisan serve

# Compile assets (opsional)
npm run dev
```

Aplikasi akan berjalan di: `http://localhost:8000`

## 📖 Cara Penggunaan

### 1. Halaman Utama - Daftar Laporan
- URL: `/` atau `/laporan`
- Menampilkan semua laporan hama dengan pagination
- Filter berdasarkan jenis tanaman
- Implementasi: **Query Builder (DB Helper)**

### 2. Tambah Laporan Baru
- URL: `/laporan/create`
- Form input data laporan hama
- Validasi lengkap dengan custom messages
- Implementasi: **Eloquent ORM**

### 3. Edit Laporan
- URL: `/laporan/{id}/edit`
- Form edit data laporan yang sudah ada
- Implementasi: **Eloquent ORM**

### 4. Hapus Laporan
- Tombol delete di halaman daftar laporan
- Implementasi: **Eloquent ORM**

### 5. Statistik dan Analisis
- URL: `/laporan-statistik`
- Dashboard statistik lengkap
- Implementasi: **Raw SQL**

## 🎯 Demonstrasi Operasi Database

### Eloquent ORM (Object-Relational Mapping)
- ✅ **Model Definition**: Definisi model dengan fillable, casts, accessors
- ✅ **CRUD Operations**: Create, Read, Update, Delete menggunakan Eloquent
- ✅ **Scopes**: Local scopes untuk query yang dapat digunakan kembali
- ✅ **Accessors**: Format data otomatis (tanggal Indonesia)

### Query Builder (Helper)
- ✅ **Complex Queries**: Query dengan join, where, order by
- ✅ **Pagination**: Pagination otomatis dengan Laravel
- ✅ **Filtering**: Filter dinamis berdasarkan input user
- ✅ **Aggregation**: Count, distinct, pluck operations

### Raw SQL
- ✅ **Complex Analytics**: Query statistik dengan GROUP BY, CASE WHEN
- ✅ **Date Functions**: Penggunaan fungsi tanggal MySQL
- ✅ **Subqueries**: Query kompleks dengan multiple conditions
- ✅ **Performance**: Query yang dioptimasi dengan indexing

## 📁 Struktur File Penting

```
app/
├── Http/Controllers/
│   └── LaporanHamaController.php    # Controller utama (ORM, Helper, Raw SQL)
├── Models/
│   └── LaporanHama.php              # Model Eloquent dengan accessors & scopes
database/
├── migrations/
│   └── 2025_06_19_233823_create_laporan_hama_table.php  # Database schema
resources/views/laporan/
├── index.blade.php                  # Daftar laporan (Query Builder)
├── create.blade.php                 # Form tambah (Eloquent ORM)
├── edit.blade.php                   # Form edit (Eloquent ORM)
└── statistik.blade.php              # Dashboard statistik (Raw SQL)
routes/
└── web.php                          # Route definitions
```

## 🔍 Contoh Data dan Testing

### Sample Data untuk Testing:
```sql
INSERT INTO laporan_hama (nama_hama, jenis_tanaman, gejala, tingkat_kerusakan, tanggal_lapor, created_at, updated_at) VALUES
('Ulat Grayak', 'Jagung', 'Daun berlubang-lubang, tanaman layu', 'sedang', '2024-01-15', NOW(), NOW()),
('Wereng Batang Coklat', 'Padi', 'Batang menguning, tanaman kerdil', 'berat', '2024-01-20', NOW(), NOW()),
('Kutu Daun', 'Cabai', 'Daun keriting, pertumbuhan terhambat', 'ringan', '2024-02-10', NOW(), NOW()),
('Penggerek Batang', 'Tebu', 'Batang berlubang, tanaman roboh', 'berat', '2024-02-15', NOW(), NOW()),
('Trips', 'Tomat', 'Bercak perak pada daun, buah cacat', 'sedang', '2024-03-05', NOW(), NOW());
```

### Testing Operasi Database:

#### 1. Test Eloquent ORM:
```bash
# Test create
POST /laporan dengan data form

# Test read
GET /laporan/{id}/edit

# Test update
PUT /laporan/{id} dengan data form

# Test delete
DELETE /laporan/{id}
```

#### 2. Test Query Builder:
```bash
# Test filtering
GET /laporan?jenis_tanaman=Padi

# Test pagination
GET /laporan?page=2
```

#### 3. Test Raw SQL:
```bash
# Test statistik
GET /laporan-statistik
```

## 📈 Fitur Statistik yang Diimplementasikan

### 1. Statistik Hama (Raw SQL)
- Jumlah kasus per jenis hama
- Rata-rata tingkat kerusakan
- Ranking hama paling berbahaya

### 2. Statistik Tanaman (Raw SQL)
- Jumlah serangan per jenis tanaman
- Jumlah kasus dengan tingkat kerusakan berat
- Tanaman paling rentan

### 3. Tren Bulanan (Raw SQL)
- Grafik tren laporan 12 bulan terakhir
- Analisis pola musiman serangan hama

### 4. Dashboard Umum (Raw SQL)
- Total laporan keseluruhan
- Jumlah jenis hama unik
- Jumlah jenis tanaman yang terdampak

## 🎓 Pembelajaran yang Dicapai

### Eloquent ORM:
- [x] Model relationships dan mass assignment
- [x] Accessors untuk format data
- [x] Local scopes untuk query reusable
- [x] Eloquent CRUD operations

### Query Builder:
- [x] Fluent interface untuk building queries
- [x] Dynamic filtering berdasarkan input
- [x] Pagination dengan Laravel helper
- [x] Aggregate functions (count, distinct, pluck)

### Raw SQL:
- [x] Complex analytical queries
- [x] GROUP BY dengan multiple conditions
- [x] CASE WHEN untuk conditional logic
- [x] Date functions untuk time-based analysis
- [x] Subqueries dan advanced SQL techniques

## 🛡️ Security dan Best Practices

- ✅ **Mass Assignment Protection**: Menggunakan `$fillable` di model
- ✅ **SQL Injection Prevention**: Parameter binding di raw queries
- ✅ **Input Validation**: Comprehensive validation rules
- ✅ **CSRF Protection**: Laravel CSRF middleware
- ✅ **Database Indexing**: Index pada kolom yang sering di-query

## 📝 Kesimpulan

Proyek AgroDisease ini berhasil mendemonstrasikan implementasi lengkap operasi database menggunakan tiga pendekatan berbeda:

1. **Eloquent ORM** untuk operasi CRUD standar dengan fitur OOP
2. **Query Builder** untuk query yang lebih fleksibel dengan syntax yang clean
3. **Raw SQL** untuk query kompleks dan analisis statistik yang membutuhkan performa optimal

Setiap pendekatan memiliki kelebihan dan use case yang tepat, dan proyek ini menunjukkan kapan dan bagaimana menggunakan masing-masing metode secara efektif.

## 📞 Informasi Tambahan

- **Framework**: Laravel 10.x
- **PHP Version**: ^8.1
- **Database**: MySQL
- **Tugas**: Operasi Database (ORM, Helper, Raw SQL)

---

<p align="center">
    <strong>Dibuat untuk memenuhi tugas Operasi Database</strong><br>
    Demonstrasi penggunaan Eloquent ORM, Query Builder, dan Raw SQL
</p>
