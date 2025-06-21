<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'AgroDisease - Sistem Pendataan Hama dan Penyakit Tanaman')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Chart.js untuk statistik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="icon" href="{{ asset('logo_agrodisease.png') }}" type="image/png">
    
    <style>
        .navbar-brand {
            font-weight: bold;
            color:rgb(255, 255, 255) !important;
        }
        .card-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #218838, #1ea085);
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }
        .badge-ringan {
            background-color: #28a745;
        }
        .badge-sedang {
            background-color: #ffc107;
        }
        .badge-berat {
            background-color: #dc3545;
        }
        .footer {
            background-color: #343a40;
            color: white;
            margin-top: 50px;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('laporan.index') }}">
                <i class="bi bi-bug-fill me-2"></i>AgroDisease
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}" 
                           href="{{ route('laporan.index') }}">
                            <i class="bi bi-list-ul me-1"></i>Daftar Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('laporan.create') ? 'active' : '' }}" 
                           href="{{ route('laporan.create') }}">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('laporan.statistik') ? 'active' : '' }}" 
                           href="{{ route('laporan.statistik') }}">
                            <i class="bi bi-bar-chart me-1"></i>Statistik
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-bug-fill me-2"></i>AgroDisease</h5>
                    <p class="mb-0">Sistem Pendataan Hama dan Penyakit Tanaman</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">© {{ date('Y') }} AgroDisease</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>