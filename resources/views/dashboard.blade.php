<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kinerja - Sistem Perkara</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2c3e50',
                        secondary: '#34495e',
                        accent: '#3498db',
                        success: '#27ae60',
                        warning: '#f39c12',
                        info: '#2980b9',
                        purple: '#8e44ad',
                        teal: '#16a085',
                        orange: '#e67e22',
                        'light-bg': '#f8f9fa',
                        panitera1: '#28a745',
                        panitera2: '#20c997',
                        panitera3: '#ffc107',
                        panitera4: '#fd7e14',
                        panitera5: '#dc3545',
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .progress-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border-radius: 12px;
            font-size: 0.9rem;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        .card-hover {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased pb-8">
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary to-secondary text-white py-10 px-6 rounded-xl shadow-lg mb-10 text-center animate-float">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">
                <i class="fas fa-tachometer-alt mr-3"></i>Dashboard Kinerja
            </h1>
            <p class="text-lg opacity-90">Sistem Monitoring Perkara Pengadilan</p>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-10 card-hover">
            <div class="bg-primary text-white py-4 px-6 flex items-center">
                <i class="fas fa-filter mr-3 text-xl"></i>
                <span class="text-xl font-semibold">Filter Periode</span>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('dashboard') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                        <div>
                            <label for="start_date" class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
                            <input type="date" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent" 
                                id="start_date" name="start_date" value="{{ request('start_date') }}">
                        </div>
                        <div>
                            <label for="end_date" class="block text-gray-700 font-medium mb-2">Tanggal Akhir</label>
                            <input type="date" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent" 
                                id="end_date" name="end_date" value="{{ request('end_date') }}">
                        </div>
                        <div class="flex flex-col md:flex-row gap-3">
                            <button type="submit" class="bg-primary hover:bg-secondary text-white px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-colors">
                                <i class="fas fa-search mr-2"></i> Filter Data
                            </button>
                            <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-colors">
                                <i class="fas fa-sync-alt mr-2"></i> Reset Filter
                            </a>
                            <a href="{{ route('perkaras.index') }}" class="bg-success hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-colors">
                                <i class="fas fa-book-medical mr-2"></i> Register Perkara
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <h3 class="text-xl font-semibold text-secondary mb-6 pb-2 border-b-2 border-accent">Ringkasan Kinerja</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Total Perkara -->
            <div class="bg-primary text-white p-6 rounded-xl shadow-md flex flex-col justify-between card-hover">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h5 class="text-lg font-semibold mb-2">Total Perkara</h5>
                        <h2 class="text-4xl font-bold">{{ $totalPerkara }}</h2>
                        <p class="mt-2 opacity-90">Seluruh periode</p>
                    </div>
                    <i class="fas fa-folder-open text-3xl opacity-70"></i>
                </div>
            </div>
            
            <!-- Perkara Putus -->
            <div class="bg-success text-white p-6 rounded-xl shadow-md flex flex-col justify-between card-hover">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h5 class="text-lg font-semibold mb-2">Perkara Putus</h5>
                        <h2 class="text-4xl font-bold">{{ $perkaraPutus }}</h2>
                        <p class="mt-2 opacity-90">{{ number_format($perkaraPutus / max($totalPerkara, 1) * 100, 1) }}%</p>
                    </div>
                    <i class="fas fa-check-circle text-3xl opacity-70"></i>
                </div>
            </div>
            
            <!-- Rata-rata Hari Hakim -->
            <div class="bg-warning text-white p-6 rounded-xl shadow-md flex flex-col justify-between card-hover">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h5 class="text-lg font-semibold mb-2">Rata-rata Hari Hakim</h5>
                        <h2 class="text-4xl font-bold">{{ number_format($avgHakim, 1) }} hari</h2>
                        <p class="mt-2 opacity-90">Registrasi sampai Putus</p>
                    </div>
                    <i class="fas fa-clock text-3xl opacity-70"></i>
                </div>
            </div>
            
            <!-- Rata-rata Hari Panitera -->
            <div class="bg-info text-white p-6 rounded-xl shadow-md flex flex-col justify-between card-hover">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h5 class="text-lg font-semibold mb-2">Rata-rata Hari Panitera</h5>
                        <h2 class="text-4xl font-bold">{{ number_format($avgPanitera, 1) }} hari</h2>
                        <p class="mt-2 opacity-90">Minutasi sampai Serah</p>
                    </div>
                    <i class="fas fa-hourglass-half text-3xl opacity-70"></i>
                </div>
            </div>
        </div>

        <!-- Kartu E-Court -->
        <h3 class="text-xl font-semibold text-secondary mb-6 pb-2 border-b-2 border-accent">Statistik E-Court</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Perkara E-Court -->
            <div class="bg-purple text-white p-6 rounded-xl shadow-md text-center card-hover">
                <h5 class="text-lg font-semibold mb-4">Perkara E-Court</h5>
                <h2 class="text-4xl font-bold mb-4">{{ $perkaraECourt }}</h2>
                <div class="h-6 bg-white bg-opacity-30 rounded-full mb-3 overflow-hidden">
                    <div class="h-full bg-success progress-bar" 
                         style="width: {{ number_format($perkaraECourt / max($totalPerkara, 1) * 100, 1) }}%">
                        {{ number_format($perkaraECourt / max($totalPerkara, 1) * 100, 1) }}%
                    </div>
                </div>
                <p class="opacity-90">Dari total perkara</p>
            </div>
            
            <!-- E-Court Putus -->
            <div class="bg-teal text-white p-6 rounded-xl shadow-md text-center card-hover">
                <h5 class="text-lg font-semibold mb-4">E-Court Putus</h5>
                <h2 class="text-4xl font-bold mb-4">{{ $ecourtPutus }}</h2>
                <div class="h-6 bg-white bg-opacity-30 rounded-full mb-3 overflow-hidden">
                    <div class="h-full bg-info progress-bar" 
                         style="width: {{ number_format($ecourtPutus / max($perkaraECourt, 1) * 100, 1) }}%">
                        {{ $perkaraECourt > 0 ? number_format($ecourtPutus / $perkaraECourt * 100, 1) : 0 }}%
                    </div>
                </div>
                <p class="opacity-90">Dari perkara E-Court</p>
            </div>
            
            <!-- E-Court Belum Putus -->
            <div class="bg-orange text-white p-6 rounded-xl shadow-md text-center card-hover">
                <h5 class="text-lg font-semibold mb-4">E-Court Belum Putus</h5>
                <h2 class="text-4xl font-bold mb-4">{{ $perkaraECourt - $ecourtPutus }}</h2>
                <div class="h-6 bg-white bg-opacity-30 rounded-full mb-3 overflow-hidden">
                    <div class="h-full bg-warning progress-bar" 
                         style="width: {{ number_format(($perkaraECourt - $ecourtPutus) / max($perkaraECourt, 1) * 100, 1) }}%">
                        {{ $perkaraECourt > 0 ? number_format(($perkaraECourt - $ecourtPutus) / $perkaraECourt * 100, 1) : 0 }}%
                    </div>
                </div>
                <p class="opacity-90">Dari perkara E-Court</p>
            </div>
        </div>

        <!-- Statistik Pengiriman Berkas -->
        <h3 class="text-xl font-semibold text-secondary mb-6 pb-2 border-b-2 border-accent">Statistik Pengiriman Berkas</h3>
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-12 card-hover">
            <div class="bg-info text-white py-4 px-6 flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span class="text-xl font-semibold">Lama Pengiriman Berkas</span>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Chart -->
                    <div class="bg-gray-50 p-5 rounded-lg">
                        <h6 class="text-lg font-semibold text-secondary mb-4 pb-2 border-b border-accent">Distribusi Waktu Pengiriman</h6>
                        <div class="simple-chart-container">
                            <canvas id="pengirimanChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Detail Kategori -->
                    <div class="bg-gray-50 p-5 rounded-lg">
                        <h6 class="text-lg font-semibold text-secondary mb-4 pb-2 border-b border-accent">Detail Kategori</h6>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex items-center">
                                    <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-medium mr-3">0-30</span>
                                    <span class="text-gray-700">hari</span>
                                </div>
                                <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-bold">{{ $statsPengiriman['0-30'] }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex items-center">
                                    <span class="bg-info text-white px-3 py-1 rounded-full text-sm font-medium mr-3">31-45</span>
                                    <span class="text-gray-700">hari</span>
                                </div>
                                <span class="bg-info text-white px-3 py-1 rounded-full text-sm font-bold">{{ $statsPengiriman['31-45'] }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex items-center">
                                    <span class="bg-warning text-gray-800 px-3 py-1 rounded-full text-sm font-medium mr-3">46-60</span>
                                    <span class="text-gray-700">hari</span>
                                </div>
                                <span class="bg-warning text-gray-800 px-3 py-1 rounded-full text-sm font-bold">{{ $statsPengiriman['46-60'] }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex items-center">
                                    <span class="bg-orange text-white px-3 py-1 rounded-full text-sm font-medium mr-3">61-90</span>
                                    <span class="text-gray-700">hari</span>
                                </div>
                                <span class="bg-orange text-white px-3 py-1 rounded-full text-sm font-bold">{{ $statsPengiriman['61-90'] }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex items-center">
                                    <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium mr-3">91-120</span>
                                    <span class="text-gray-700">hari</span>
                                </div>
                                <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-bold">{{ $statsPengiriman['91-120'] }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex items-center">
                                    <span class="bg-gray-800 text-white px-3 py-1 rounded-full text-sm font-medium mr-3">>121</span>
                                    <span class="text-gray-700">hari</span>
                                </div>
                                <span class="bg-gray-800 text-white px-3 py-1 rounded-full text-sm font-bold">{{ $statsPengiriman['121>'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kinerja Hakim dan Panitera -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Kinerja Hakim -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                <div class="bg-success text-white py-4 px-6 flex items-center">
                    <i class="fas fa-gavel mr-2"></i>
                    <span class="text-xl font-semibold">Kinerja Hakim</span>
                </div>
                <div class="p-6">
                    <canvas id="hakimChart"></canvas>
                </div>
            </div>
            
            <!-- Kinerja Panitera -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                <div class="bg-info text-white py-4 px-6 flex items-center">
                    <i class="fas fa-user-tie mr-2"></i>
                    <span class="text-xl font-semibold">Kinerja Panitera</span>
                </div>
                <div class="p-6">
                    <canvas id="paniteraChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart untuk Statistik Pengiriman Berkas
        document.addEventListener('DOMContentLoaded', function() {
            new Chart(document.getElementById('pengirimanChart'), {
                type: 'bar',
                data: {
                    labels: ['0-30', '31-45', '46-60', '61-90', '91-120', '>121'],
                    datasets: [{
                        data: [
                            {{ $statsPengiriman['0-30'] }},
                            {{ $statsPengiriman['31-45'] }},
                            {{ $statsPengiriman['46-60'] }},
                            {{ $statsPengiriman['61-90'] }},
                            {{ $statsPengiriman['91-120'] }},
                            {{ $statsPengiriman['121>'] }}
                        ],
                        backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#fd7e14', '#dc3545', '#343a40'],
                        borderWidth: 0,
                        borderRadius: 4,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' perkara';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                display: true,
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Chart untuk Kinerja Hakim
            const hakimCtx = document.getElementById('hakimChart').getContext('2d');
            new Chart(hakimCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($kinerjaHakim->pluck('perkara')) !!},
                    datasets: [{
                        label: 'Lama Proses (hari)',
                        data: {!! json_encode($kinerjaHakim->pluck('lama_hakim')) !!},
                        backgroundColor: {!! json_encode($kinerjaHakim->map(function($item) {
                            if ($item->lama_hakim === null) return '#6c757d';
                            return $item->lama_hakim <= 30 ? '#28a745' : ($item->lama_hakim <= 60 ? '#ffc107' : '#dc3545');
                        })) !!},
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Hari'
                            }
                        }
                    }
                }
            });

            // Chart untuk Kinerja Panitera
            const paniteraCtx = document.getElementById('paniteraChart').getContext('2d');
            new Chart(paniteraCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($kinerjaPanitera->pluck('perkara')) !!},
                    datasets: [{
                        label: 'Lama Proses (hari)',
                        data: {!! json_encode($kinerjaPanitera->pluck('lama_panitera')) !!},
                        backgroundColor: {!! json_encode($kinerjaPanitera->map(function($item) {
                            if ($item->lama_panitera === null) return '#6c757d';
                            if ($item->lama_panitera <= 2) return '#28a745';
                            if ($item->lama_panitera <= 5) return '#20c997';
                            if ($item->lama_panitera <= 9) return '#ffc107';
                            if ($item->lama_panitera <= 14) return '#fd7e14';
                            return '#dc3545';
                        })) !!},
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Hari'
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>