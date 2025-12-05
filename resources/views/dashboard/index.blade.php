<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | BLUD SMKN 1 CIAMIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(135deg, #4A90E2, #1A365D); }
        .stat-card { 
            background: white; 
            border-radius: 12px; 
            padding: 25px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
        }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
        .stat-icon { font-size: 2.5rem; margin-bottom: 15px; color: #4A90E2; }
        .stat-number { font-size: 2.2rem; font-weight: 700; color: #1A365D; }
        .sidebar { min-height: calc(100vh - 56px); background: #343a40; padding-top: 20px; }
        .sidebar a { 
            color: #adb5bd; 
            text-decoration: none; 
            padding: 12px 20px; 
            display: block; 
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .sidebar a:hover, .sidebar a.active { 
            background: rgba(74, 144, 226, 0.2); 
            color: white; 
            padding-left: 25px; 
        }
        .welcome-card {
            background: linear-gradient(135deg, #4A90E2, #1A365D);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/iconsmea.png') }}" alt="Logo" style="height: 35px; margin-right: 10px;">
                <strong>Admin Panel - BLUD SMKN 1 CIAMIS</strong>
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user me-1"></i> 
                    {{ auth()->guard('admin')->user()->name ?? 'Administrator' }}
                </span>
                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar">
                    <a href="{{ route('admin.dashboard') }}" class="active">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.tefas.index') }}">
                        <i class="fas fa-school"></i> TEFA Jurusan
                    </a>
                    <a href="{{ route('admin.products.index') }}">
                        <i class="fas fa-box-open"></i> Produk
                    </a>
                    <a href="{{ route('admin.services.index') }}">
                        <i class="fas fa-handshake"></i> Layanan Sewa
                    </a>
                    <a href="{{ route('admin.contacts.index') }}">
                        <i class="fas fa-envelope"></i> Pesan Masuk
                        <span class="badge bg-danger float-end">{{ $stats['contact_count'] ?? 0 }}</span>
                    </a>
                   <a href="#">
                        <i class="fas fa-user"></i> Profil
                    </a>
                    <a href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog"></i> Pengaturan
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="mt-4">
                        <i class="fas fa-external-link-alt"></i> Lihat Website
                    </a>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Welcome Card -->
                <div class="welcome-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2">Selamat Datang, Admin!</h2>
                            <p class="mb-0">Anda login sebagai administrator BLUD SMKN 1 CIAMIS</p>
                            <small><i class="fas fa-clock me-1"></i> {{ date('l, d F Y H:i') }}</small>
                        </div>
                        <div class="col-md-4 text-end">
                            <i class="fas fa-cogs fa-4x opacity-50"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="stat-card text-center">
                            <div class="stat-icon">
                                <i class="fas fa-school"></i>
                            </div>
                            <div class="stat-number">{{ $stats['tefa_count'] ?? 0 }}</div>
                            <div class="stat-label">TEFA Jurusan</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="stat-card text-center">
                            <div class="stat-icon">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div class="stat-number">{{ $stats['product_count'] ?? 0 }}</div>
                            <div class="stat-label">Total Produk</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="stat-card text-center">
                            <div class="stat-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div class="stat-number">{{ $stats['service_count'] ?? 0 }}</div>
                            <div class="stat-label">Layanan Sewa</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="stat-card text-center">
                            <div class="stat-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="stat-number">{{ $stats['contact_count'] ?? 0 }}</div>
                            <div class="stat-label">Pesan Masuk</div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="stat-card">
                            <h5 class="mb-3"><i class="fas fa-bolt me-2 text-warning"></i> Aksi Cepat</h5>
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ route('admin.tefas.index') }}" class="btn btn-primary w-100 mb-2">
                                        <i class="fas fa-plus me-1"></i> Tambah TEFA
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-success w-100 mb-2">
                                        <i class="fas fa-plus me-1"></i> Tambah Produk
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-info w-100">
                                        <i class="fas fa-eye me-1"></i> Lihat Pesan
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary w-100">
                                        <i class="fas fa-cog me-1"></i> Pengaturan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="stat-card">
                            <h5 class="mb-3"><i class="fas fa-chart-line me-2 text-success"></i> Informasi</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-circle text-primary me-2"></i>
                                    Total TEFA: <strong>{{ $stats['tefa_count'] ?? 0 }}</strong>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-circle text-success me-2"></i>
                                    Total Produk: <strong>{{ $stats['product_count'] ?? 0 }}</strong>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-circle text-warning me-2"></i>
                                    Pesan Masuk: <strong>{{ $stats['contact_count'] ?? 0 }}</strong>
                                </li>
                                <li>
                                    <i class="fas fa-circle text-info me-2"></i>
                                    Layanan Sewa: <strong>{{ $stats['service_count'] ?? 0 }}</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Footer Note -->
                <div class="text-center text-muted mt-4">
                    <small>
                        <i class="fas fa-info-circle me-1"></i>
                        Sistem Admin BLUD SMKN 1 CIAMIS • {{ date('Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            document.querySelector('.fa-clock').parentNode.innerHTML = 
                '<i class="fas fa-clock me-1"></i> ' + now.toLocaleDateString('id-ID', options);
        }
        setInterval(updateTime, 60000);
        document.addEventListener('DOMContentLoaded', updateTime);
    </script>
</body>
</html>