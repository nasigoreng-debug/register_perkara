<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Perkara - Sistem Manajemen Perkara</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0d6efd',
                        secondary: '#6c757d',
                        success: '#198754',
                        info: '#0dcaf0',
                        warning: '#ffc107',
                        danger: '#dc3545',
                        light: '#f8f9fa',
                        dark: '#212529',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.4s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Custom utilities untuk status badge */
        .status-badge {
            display: inline-block;
            text-align: center;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            min-width: 110px;
        }
        
        /* Styling untuk tabel responsif */
        @media (max-width: 1024px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table-responsive table {
                min-width: 800px;
            }
            
            .stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }
        
        @media (max-width: 640px) {
            .stat-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
            
            .filter-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
        }
        
        /* Styling untuk row yang dapat diklik */
        .clickable-row {
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .clickable-row:hover {
            background-color: #f0f9ff !important;
        }
        
        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased pb-8">
    <div class="container mx-auto px-4 mt-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 border-b-2 border-primary pb-2 mb-4 md:mb-0 flex items-center">
                    <i class="fas fa-file-alt mr-2"></i>Daftar Perkara
                </h1>
                
                <div class="flex items-center space-x-4">
                    <small class="text-gray-600 text-sm">Selamat datang, {{ auth()->user()->name }}</small>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-sm flex items-center">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Dashboard dan Info Total -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-3 sm:space-y-0">
                <a href="/" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                
                <div>
                    <span class="bg-gray-500 text-white px-3 py-1.5 rounded-full text-sm flex items-center">
                        <i class="fas fa-clipboard-list mr-1"></i> Total: {{ $perkaras->total() }} perkara
                    </span>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded flex items-center animate-fade-in" role="alert">
                    <i class="fas fa-check-circle text-green-500 mr-2 text-lg"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="ml-auto text-green-700 hover:text-green-900" aria-label="Tutup" onclick="closeAlert()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Statistik Perkara -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-5 mb-6 border-l-4 border-primary shadow-sm">
                <h5 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>Statistik Perkara
                </h5>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 stat-grid">
                    <div class="bg-primary text-white px-4 py-3 rounded-lg shadow flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                        <i class="fas fa-check-circle mr-2"></i> Putus: {{ $putus_count }}
                    </div>
                    <div class="bg-yellow-400 text-gray-900 px-4 py-3 rounded-lg shadow flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                        <i class="fas fa-clock mr-2"></i> Proses Sidang: {{ $proses_sidang_count }}
                    </div>
                    <div class="bg-cyan-500 text-white px-4 py-3 rounded-lg shadow flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                        <i class="fas fa-hourglass-half mr-2"></i> Menunggu Sidang: {{ $menunggu_sidang_count }}
                    </div>
                    <div class="bg-gray-500 text-white px-4 py-3 rounded-lg shadow flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                        <i class="fas fa-cog mr-2"></i> Proses Awal: {{ $proses_awal_count }}
                    </div>
                    
                    <div class="bg-red-500 text-white px-4 py-3 rounded-lg shadow flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Belum Putus: {{ $belum_putus_count }}
                    </div>
                    <div class="bg-green-500 text-white px-4 py-3 rounded-lg shadow flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                        <i class="fas fa-percent mr-2"></i> Progress: {{ $perkaras->total() > 0 ? round(($putus_count / $perkaras->total()) * 100, 1) : 0 }}%
                    </div>
                    <div class="bg-gray-800 text-white px-4 py-3 rounded-lg shadow flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                        <i class="fas fa-bolt mr-2"></i> Rata/Bulan: {{ $rata_per_bulan }}
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-gray-50 rounded-xl p-5 mb-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                    <h5 class="text-lg font-semibold mb-2 sm:mb-0 flex items-center">
                        <i class="fas fa-filter mr-2"></i>Filter & Pencarian
                    </h5>
                    <a href="#" class="text-primary hover:underline font-medium flex items-center" id="resetFilters">
                        <i class="fas fa-sync-alt mr-1"></i> Reset Filter
                    </a>
                </div>
                
                <form method="GET" action="{{ route('perkaras.index') }}" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 filter-grid">
                        <div class="lg:col-span-2">
                            <label class="block font-medium text-gray-700 mb-1">Cari No. Perkara, Satker, atau Pihak</label>
                            <div class="flex">
                                <input type="text" name="search" class="flex-grow rounded-l-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" 
                                       placeholder="Masukkan kata kunci..." 
                                       value="{{ request('search') }}"
                                       id="searchInput">
                                <button type="submit" class="bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded-r-lg flex items-center" id="searchButton">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if(request()->has('search'))
                                    <a href="{{ route('perkaras.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 ml-1 rounded-lg flex items-center">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Status Perkara</label>
                            <select name="status" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Semua Status</option>
                                <option value="putus" {{ request('status') == 'putus' ? 'selected' : '' }}>Putus</option>
                                <option value="proses_sidang" {{ request('status') == 'proses_sidang' ? 'selected' : '' }}>Proses Sidang</option>
                                <option value="menunggu_sidang" {{ request('status') == 'menunggu_sidang' ? 'selected' : '' }}>Menunggu Sidang</option>
                                <option value="proses_awal" {{ request('status') == 'proses_awal' ? 'selected' : '' }}>Proses Awal</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Jenis Perkara</label>
                            <select name="jenis_perkara" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Semua Jenis</option>
                                <option value="Asal Usul Anak" {{ request('jenis_perkara') == 'Asal Usul Anak' ? 'selected' : '' }}>Asal Usul Anak</option>
                                <option value="Cerai Gugat" {{ request('jenis_perkara') == 'Cerai Gugat' ? 'selected' : '' }}>Cerai Gugat</option>
                                <option value="Cerai Talak" {{ request('jenis_perkara') == 'Cerai Talak' ? 'selected' : '' }}>Cerai Talak</option>
                                <option value="Dispensasi Kawin" {{ request('jenis_perkara') == 'Dispensasi Kawin' ? 'selected' : '' }}>Dispensasi Kawin</option>
                                <option value="Ekonomi Syariah" {{ request('jenis_perkara') == 'Ekonomi Syariah' ? 'selected' : '' }}>Ekonomi Syariah</option>
                                <option value="Harta Bersama" {{ request('jenis_perkara') == 'Harta Bersama' ? 'selected' : '' }}>Harta Bersama</option>
                                <option value="Hibah" {{ request('jenis_perkara') == 'Hibah' ? 'selected' : '' }}>Hibah</option>
                                <option value="Isbath Nikah" {{ request('jenis_perkara') == 'Isbath Nikah' ? 'selected' : '' }}>Isbath Nikah</option>
                                <option value="Izin Poligami" {{ request('jenis_perkara') == 'Izin Poligami' ? 'selected' : '' }}>Izin Poligami</option>
                                <option value="Kewarisan" {{ request('jenis_perkara') == 'Kewarisan' ? 'selected' : '' }}>Kewarisan</option>
                                <option value="P3HP/Penetapan Ahli Waris" {{ request('jenis_perkara') == 'P3HP/Penetapan Ahli Waris' ? 'selected' : '' }}>P3HP/Penetapan Ahli Waris</option>
                                <option value="Pembatalan Perkawinan" {{ request('jenis_perkara') == 'Pembatalan Perkawinan' ? 'selected' : '' }}>Pembatalan Perkawinan</option>
                                <option value="Pengesahan Anak/Pengangkatan Anak" {{ request('jenis_perkara') == 'Pengesahan Anak/Pengangkatan Anak' ? 'selected' : '' }}>Pengesahan Anak/Pengangkatan Anak</option>
                                <option value="Perwalian" {{ request('jenis_perkara') == 'Perwalian' ? 'selected' : '' }}>Perwalian</option>
                                <option value="Wakaf" {{ request('jenis_perkara') == 'Wakaf' ? 'selected' : '' }}>Wakaf</option>
                                <option value="Wasiat" {{ request('jenis_perkara') == 'Wasiat' ? 'selected' : '' }}>Wasiat</option>
                                <option value="Zakat/Infaq/Shodaqoh" {{ request('jenis_perkara') == 'Zakat/Infaq/Shodaqoh' ? 'selected' : '' }}>Zakat/Infaq/Shodaqoh</option>
                                <option value="Lain-lain" {{ request('jenis_perkara') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Keterangan</label>
                            <select name="keterangan_filter" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Semua Keterangan</option>
                                <option value="e-court" {{ request('keterangan_filter') == 'e-court' ? 'selected' : '' }}>E-Court</option>
                                <option value="non e-court" {{ request('keterangan_filter') == 'non e-court' ? 'selected' : '' }}>Non E-Court</option>
                            </select>
                        </div>
                        
                        <div class="md:col-span-2 lg:col-span-4 flex flex-col sm:flex-row justify-between items-start sm:items-end space-y-3 sm:space-y-0">
                            <a href="{{ route('perkaras.create') }}" class="bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i> Tambah
                            </a>
                            
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-700 text-sm">Items per page:</span>
                                <select name="perPage" id="perPage" class="rounded-lg border border-gray-300 px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Simpan parameter tersembunyi -->
                    @if(request()->has('perPage'))
                        <input type="hidden" name="perPage" value="{{ request('perPage') }}">
                    @endif
                </form>
            </div>

            @if($perkaras->count() > 0)
                <div class="table-responsive overflow-x-auto rounded-lg shadow">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left font-semibold w-16">#</th>
                                <th class="py-3 px-4 text-left font-semibold">No. Perkara</th>
                                <th class="py-3 px-4 text-left font-semibold">Satker</th>
                                <th class="py-3 px-4 text-left font-semibold">Jenis</th>
                                <th class="py-3 px-4 text-left font-semibold">Tgl. Register</th>
                                <th class="py-3 px-4 text-left font-semibold">Tgl. Putus</th>
                                <th class="py-3 px-4 text-left font-semibold">Status</th>
                                <th class="py-3 px-4 text-left font-semibold">Keterangan</th>
                                <th class="py-3 px-4 text-center font-semibold w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $startNumber = ($perkaras->currentPage() - 1) * $perkaras->perPage() + 1;
                            @endphp
                            @foreach($perkaras as $perkara)
                                <tr class="hover:bg-blue-50 transition-colors duration-150 animate-fade-in clickable-row" data-href="{{ route('perkaras.show', $perkara->id) }}">
                                    <td class="py-3 px-4 font-bold text-gray-600">{{ $startNumber + $loop->index }}</td>
                                    <td class="py-3 px-4">
                                        <strong class="text-blue-600">{{ $perkara->no_reg_pta }}</strong>
                                        @if($perkara->no_put_pa)
                                            <br><small class="text-gray-500">{{ $perkara->no_put_pa }}</small>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($perkara->satker)
                                            <span class="text-gray-800">{{ $perkara->satker }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($perkara->jenis_perkara)
                                            <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $perkara->jenis_perkara }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($perkara->tgl_reg_pta)
                                            <span class="text-gray-800">{{ $perkara->tgl_reg_pta->format('d/m/Y') }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($perkara->tgl_putus)
                                            <span class="text-green-600 font-semibold">{{ $perkara->tgl_putus->format('d/m/Y') }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($perkara->tgl_putus)
                                            <span class="status-badge bg-green-100 text-green-800">Putus</span>
                                        @elseif($perkara->tgl_sidang)
                                            <span class="status-badge bg-yellow-100 text-yellow-800">Proses Sidang</span>
                                        @elseif($perkara->tgl_phs)
                                            <span class="status-badge bg-blue-100 text-blue-800">Menunggu Sidang</span>
                                        @else
                                            <span class="status-badge bg-gray-100 text-gray-800">Proses Awal</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($perkara->keterangan)
                                            @if(strtolower($perkara->keterangan) == 'e-court')
                                                <span class="status-badge bg-blue-100 text-blue-800">E-Court</span>
                                            @elseif(strtolower($perkara->keterangan) == 'non e-court')
                                                <span class="status-badge bg-gray-100 text-gray-800">Non E-Court</span>
                                            @else
                                                <span class="status-badge bg-gray-100 text-gray-800 text-truncate-2">{{ $perkara->keterangan }}</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex justify-center space-x-1">
                                            <a href="{{ route('perkaras.show', $perkara->id) }}" 
                                               class="bg-blue-500 hover:bg-blue-600 text-white w-8 h-8 rounded flex items-center justify-center transition-transform duration-200 hover:scale-105" title="Lihat Detail">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>
                                            <a href="{{ route('perkaras.edit', $perkara->id) }}" 
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white w-8 h-8 rounded flex items-center justify-center transition-transform duration-200 hover:scale-105" title="Edit">
                                                <i class="fas fa-pencil-alt text-xs"></i>
                                            </a>
                                            <form action="{{ route('perkaras.destroy', $perkara->id) }}" 
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded flex items-center justify-center transition-transform duration-200 hover:scale-105" 
                                                        title="Hapus"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus perkara {{ $perkara->no_reg_pta }}?')">
                                                    <i class="fas fa-trash text-xs"></i>
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
                <div class="mt-6">
                    <nav class="flex flex-col items-center">
                        <ul class="flex flex-wrap space-x-1 mb-3">
                            {{-- Previous Page Link --}}
                            @if ($perkaras->onFirstPage())
                                <li class="disabled">
                                    <span class="bg-gray-200 text-gray-500 px-3 py-2 rounded">&laquo;</span>
                                </li>
                            @else
                                <li>
                                    <a class="bg-white text-primary hover:bg-blue-100 px-3 py-2 rounded border border-gray-300" href="{{ $perkaras->previousPageUrl() }}&perPage={{ $perkaras->perPage() }}{{ request('search') ? '&search='.request('search') : '' }}{{ request('status') ? '&status='.request('status') : '' }}{{ request('keterangan_filter') ? '&keterangan_filter='.request('keterangan_filter') : '' }}{{ request('jenis_perkara') ? '&jenis_perkara='.request('jenis_perkara') : '' }}" rel="prev">&laquo;</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $start = max(1, $perkaras->currentPage() - 2);
                                $end = min($start + 4, $perkaras->lastPage());
                                $start = max(1, $end - 4);
                            @endphp
                            
                            @if($start > 1)
                                <li>
                                    <a class="bg-white text-primary hover:bg-blue-100 px-3 py-2 rounded border border-gray-300" href="{{ $perkaras->url(1) }}&perPage={{ $perkaras->perPage() }}{{ request('search') ? '&search='.request('search') : '' }}{{ request('status') ? '&status='.request('status') : '' }}{{ request('keterangan_filter') ? '&keterangan_filter='.request('keterangan_filter') : '' }}{{ request('jenis_perkara') ? '&jenis_perkara='.request('jenis_perkara') : '' }}">1</a>
                                </li>
                                @if($start > 2)
                                    <li class="disabled">
                                        <span class="bg-gray-200 text-gray-500 px-3 py-2 rounded">...</span>
                                    </li>
                                @endif
                            @endif
                            
                            @for ($page = $start; $page <= $end; $page++)
                                @if ($page == $perkaras->currentPage())
                                    <li class="active" aria-current="page">
                                        <span class="bg-primary text-white px-3 py-2 rounded">{{ $page }}</span>
                                    </li>
                                @else
                                    <li>
                                        <a class="bg-white text-primary hover:bg-blue-100 px-3 py-2 rounded border border-gray-300" href="{{ $perkaras->url($page) }}&perPage={{ $perkaras->perPage() }}{{ request('search') ? '&search='.request('search') : '' }}{{ request('status') ? '&status='.request('status') : '' }}{{ request('keterangan_filter') ? '&keterangan_filter='.request('keterangan_filter') : '' }}{{ request('jenis_perkara') ? '&jenis_perkara='.request('jenis_perkara') : '' }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endfor
                            
                            @if($end < $perkaras->lastPage())
                                @if($end < $perkaras->lastPage() - 1)
                                    <li class="disabled">
                                        <span class="bg-gray-200 text-gray-500 px-3 py-2 rounded">...</span>
                                    </li>
                                @endif
                                <li>
                                    <a class="bg-white text-primary hover:bg-blue-100 px-3 py-2 rounded border border-gray-300" href="{{ $perkaras->url($perkaras->lastPage()) }}&perPage={{ $perkaras->perPage() }}{{ request('search') ? '&search='.request('search') : '' }}{{ request('status') ? '&status='.request('status') : '' }}{{ request('keterangan_filter') ? '&keterangan_filter='.request('keterangan_filter') : '' }}{{ request('jenis_perkara') ? '&jenis_perkara='.request('jenis_perkara') : '' }}">{{ $perkaras->lastPage() }}</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($perkaras->hasMorePages())
                                <li>
                                    <a class="bg-white text-primary hover:bg-blue-100 px-3 py-2 rounded border border-gray-300" href="{{ $perkaras->nextPageUrl() }}&perPage={{ $perkaras->perPage() }}{{ request('search') ? '&search='.request('search') : '' }}{{ request('status') ? '&status='.request('status') : '' }}{{ request('keterangan_filter') ? '&keterangan_filter='.request('keterangan_filter') : '' }}{{ request('jenis_perkara') ? '&jenis_perkara='.request('jenis_perkara') : '' }}" rel="next">&raquo;</a>
                                </li>
                            @else
                                <li class="disabled">
                                    <span class="bg-gray-200 text-gray-500 px-3 py-2 rounded">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                        
                        <div class="text-center text-gray-600">
                            <p class="mb-1">Menampilkan {{ $perkaras->firstItem() }} - {{ $perkaras->lastItem() }} dari {{ $perkaras->total() }} perkara</p>
                            <small class="text-gray-500">Halaman {{ $perkaras->currentPage() }} dari {{ $perkaras->lastPage() }}</small>
                        </div>
                    </nav>
                </div>
            @else
                <div class="bg-blue-50 border-l-4 border-blue-500 p-8 text-center rounded-lg shadow">
                    <i class="fas fa-info-circle text-blue-500 text-5xl mb-4"></i> 
                    <h4 class="text-blue-700 text-xl font-semibold mb-4">
                        @if(request()->has('search') || request()->has('status') || request()->has('keterangan_filter') || request()->has('jenis_perkara'))
                            Tidak ditemukan perkara dengan filter yang dipilih.
                        @else
                            Belum ada data perkara.
                        @endif
                    </h4>
                    <div class="mt-5 space-x-3">
                        <a href="{{ route('perkaras.create') }}" class="bg-primary hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg inline-flex items-center">
                            <i class="fas fa-plus-circle mr-2"></i> Tambah Perkara Baru
                        </a>
                        @if(request()->has('search') || request()->has('status') || request()->has('keterangan_filter') || request()->has('jenis_perkara'))
                            <a href="{{ route('perkaras.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-lg inline-flex items-center">
                                <i class="fas fa-times-circle mr-2"></i> Hapus Filter
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Reset filters
        document.getElementById('resetFilters').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = "{{ route('perkaras.index') }}";
        });
        
        // Clickable rows
        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function() {
                window.location.href = this.dataset.href;
            });
        });
        
        // Prevent click when clicking on buttons inside the row
        document.querySelectorAll('.clickable-row a, .clickable-row button, .clickable-row form').forEach(element => {
            element.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
        
        // Auto submit form when filter changes
        document.querySelectorAll('select[name="status"], select[name="jenis_perkara"], select[name="keterangan_filter"], select[name="perPage"]').forEach(select => {
            select.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });
        
        // Loading indicator for search
        document.getElementById('filterForm').addEventListener('submit', function() {
            const searchButton = document.getElementById('searchButton');
            searchButton.innerHTML = '<div class="loading-spinner"></div>';
            searchButton.disabled = true;
        });
        
        // Enter key to submit search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('filterForm').submit();
            }
        });
    </script>
</body>
</html>