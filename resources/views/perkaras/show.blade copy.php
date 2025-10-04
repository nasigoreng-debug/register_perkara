<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail informasi perkara {{ $perkara->perkara }}">
    <meta name="author" content="Sistem Informasi Perkara">
    <title>Detail Perkara - {{ $perkara->perkara }}</title>
    
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
                        danger: '#dc3545',
                        warning: '#ffc107',
                        info: '#0dcaf0',
                        light: '#f8f9fa',
                        dark: '#212529',
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .timeline-badge {
            position: absolute;
            left: -2rem;
            top: 0;
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
        }
        
        .timeline-content {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 0.375rem;
            border-left: 3px solid #0d6efd;
        }
        
        /* Animations */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(10px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        /* Card Hover Effect */
        .card-hover {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased p-5">
    <div class="container mx-auto mt-6 max-w-6xl">
        <!-- Main Card Container -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover animate-fade-in">
            
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white py-5 px-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <h1 class="text-xl font-bold mb-3 md:mb-0">
                        <i class="fas fa-info-circle mr-2" aria-hidden="true"></i>Detail Perkara 
                    </h1>
                    <div class="flex flex-wrap gap-2 mt-2 md:mt-0">
                        <a href="{{ route('perkaras.edit', $perkara->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-sm flex items-center transition-colors">
                            <i class="fas fa-edit mr-1" aria-hidden="true"></i> Edit
                        </a>
                        <a href="{{ route('perkaras.index') }}" class="bg-white hover:bg-gray-100 text-gray-800 px-3 py-1.5 rounded-lg text-sm flex items-center transition-colors">
                            <i class="fas fa-arrow-left mr-1" aria-hidden="true"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Content Section -->
            <div class="p-6">
                <!-- Header Info -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h2 class="text-primary font-bold">{{ $perkara->no_reg_pta }}</h2>
                        <p class="text-gray-600">{{ $perkara->no_put_pa }}</p>
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            @if($perkara->tgl_putus)
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full flex items-center">
                                    <i class="fas fa-check-circle mr-1" aria-hidden="true"></i> PUTUS
                                </span>
                            @elseif($perkara->tgl_sidang)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full flex items-center">
                                    <i class="fas fa-clock mr-1" aria-hidden="true"></i> PROSES SIDANG
                                </span>
                            @elseif($perkara->tgl_phs)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full flex items-center">
                                    <i class="fas fa-calendar-check mr-1" aria-hidden="true"></i> MENUNGGU SIDANG
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full flex items-center">
                                    <i class="fas fa-hourglass mr-1" aria-hidden="true"></i> PROSES AWAL
                                </span>
                            @endif
                            <small class="text-gray-500 flex items-center">
                                <i class="fas fa-clock-history mr-1" aria-hidden="true"></i>Dibuat: {{ $perkara->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                    <div class="mt-3 md:mt-0">
                        <form action="{{ route('perkaras.destroy', $perkara->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm flex items-center transition-colors"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus perkara ini?')">
                                <i class="fas fa-trash mr-1" aria-hidden="true"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Timeline Progress Section -->
                <section class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4 flex items-center">
                        <i class="fas fa-clock-history mr-2" aria-hidden="true"></i>Timeline Proses
                    </h3>
                    <div class="timeline">
                        @if($perkara->tgl_reg_pta)
                        <div class="timeline-item">
                            <span class="timeline-badge bg-primary">1</span>
                            <div class="timeline-content">
                                <strong class="text-gray-800">Register</strong>
                                <p class="text-gray-600 text-sm mt-1">{{ $perkara->tgl_reg_pta->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($perkara->tgl_pmh)
                        <div class="timeline-item">
                            <span class="timeline-badge bg-success">2</span>
                            <div class="timeline-content">
                                <strong class="text-gray-800">Penunjukkan Majelis Hakim</strong>
                                <p class="text-gray-600 text-sm mt-1">{{ $perkara->tgl_pmh->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($perkara->tgl_ppp)
                        <div class="timeline-item">
                            <span class="timeline-badge bg-info">3</span>
                            <div class="timeline-content">
                                <strong class="text-gray-800">Penunjukkan Panitera Pengganti</strong>
                                <p class="text-gray-600 text-sm mt-1">{{ $perkara->tgl_ppp->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($perkara->tgl_phs)
                        <div class="timeline-item">
                            <span class="timeline-badge bg-warning text-white">4</span>
                            <div class="timeline-content">
                                <strong class="text-gray-800">Penetapan Hari Sidang</strong>
                                <p class="text-gray-600 text-sm mt-1">{{ $perkara->tgl_phs->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($perkara->tgl_sidang)
                        <div class="timeline-item">
                            <span class="timeline-badge bg-danger">5</span>
                            <div class="timeline-content">
                                <strong class="text-gray-800">Sidang</strong>
                                <p class="text-gray-600 text-sm mt-1">{{ $perkara->tgl_sidang->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($perkara->tgl_sela)
                        <div class="timeline-item">
                            <span class="timeline-badge bg-primary">6</span>
                            <div class="timeline-content">
                                <strong class="text-gray-800">Putus Sela</strong>
                                <p class="text-gray-600 text-sm mt-1">{{ $perkara->tgl_sela->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($perkara->tgl_putus)
                        <div class="timeline-item">
                            <span class="timeline-badge bg-success">7</span>
                            <div class="timeline-content">
                                <strong class="text-gray-800">Putusan</strong>
                                <p class="text-gray-600 text-sm mt-1">{{ $perkara->tgl_putus->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($perkara->tgl_minut)
                        <div class="timeline-item">
                            <span class="timeline-badge bg-info">8</span>
                            <div class="timeline-content">
                                <strong class="text-gray-800">Minutasi</strong>
                                <p class="text-gray-600 text-sm mt-1">{{ $perkara->tgl_minut->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($perkara->tgl_serah)
                        <div class="timeline-item">
                            <span class="timeline-badge bg-warning">9</span>
                            <div class="timeline-content">
                                <strong class="text-gray-800">Penyerahan Berkas</strong>
                                <p class="text-gray-600 text-sm mt-1">{{ $perkara->tgl_serah->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($perkara->tgl_kirim_pta)
                        <div class="timeline-item">
                            <span class="timeline-badge bg-danger">10</span>
                            <div class="timeline-content">
                                <strong class="text-gray-800">Kirim ke Satker</strong>
                                <p class="text-gray-600 text-sm mt-1">{{ $perkara->tgl_kirim_pta->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </section>

                <!-- Detail Information Section -->
                <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div>
                        <!-- Informasi PA -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
                            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                                <h4 class="font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-building mr-2" aria-hidden="true"></i>Identitas Perkara
                                </h4>
                            </div>
                            <div class="p-4 space-y-3">
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Nomor Perkara PA:</span>
                                    <span class="text-gray-600 badge">{{ $perkara->no_reg_pa ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Jenis Perkara:</span>
                                    <span class="text-gray-600">{{ $perkara->jenis_perkara ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Tanggal Putus PA:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_put_pa ? $perkara->tgl_put_pa->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Tanggal Akta Banding:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_akta_banding ? $perkara->tgl_akta_banding->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Tanggal Surat PA:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_srt_pa ? $perkara->tgl_srt_pa->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">No. Surat PA:</span>
                                    <span class="text-gray-600">{{ $perkara->no_srt_pa ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Pembanding:</span>
                                    <span class="text-gray-600">{{ $perkara->pembanding ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Terbanding:</span>
                                    <span class="text-gray-600">{{ $perkara->terbanding ?: '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Majelis Hakim & Panitera -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
                            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                                <h4 class="font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-users mr-2" aria-hidden="true"></i>Majelis Hakim & Panitera
                                </h4>
                            </div>
                            <div class="p-4 space-y-3">
                                <!-- Field HKM Ketua -->
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Hakim Ketua:</span>
                                    <span class="text-gray-600">{{ $perkara->hakim_ketua ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Hakim Anggota 1:</span>
                                    <span class="text-gray-600">{{ $perkara->hakim_anggota1 ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Hakim Anggota 2:</span>
                                    <span class="text-gray-600">{{ $perkara->hakim_anggota2 ?: '-' }}</span>
                                </div>
                                <!-- Field Panitera -->
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Panitera Pengganti:</span>
                                    <span class="text-gray-600">{{ $perkara->panitera_p ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Penunjukkan Majelis Hakim:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_pmh ? $perkara->tgl_pmh->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Penunjukkan Panitera Pengganti:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_ppp ? $perkara->tgl_ppp->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Diterima Ketua Majelis:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_trm_km ? $perkara->tgl_trm_km->format('d/m/Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div>
                        <!-- Informasi PTA -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
                            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                                <h4 class="font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-house mr-2" aria-hidden="true"></i>Penerimaan & Registrasi di PTA
                                </h4>
                            </div>
                            <div class="p-4 space-y-3">
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Tanggal Terima PTA:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_trm_pta ? $perkara->tgl_trm_pta->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">No. Register PTA:</span>
                                    <span class="text-gray-600">{{ $perkara->no_reg_pta ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Tanggal Register PTA:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_reg_pta ? $perkara->tgl_reg_pta->format('d/m/Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Proses Sidang -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
                            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                                <h4 class="font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-calendar-alt mr-2" aria-hidden="true"></i>Proses Sidang
                                </h4>
                            </div>
                            <div class="p-4 space-y-3">
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Penetapan Hari Sidang:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_phs ? $perkara->tgl_phs->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Tanggal Sidang:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_sidang ? $perkara->tgl_sidang->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Tanggal Putus Sela:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_sela ? $perkara->tgl_sela->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Tanggal Putus:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_putus ? $perkara->tgl_putus->format('d/m/Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Administrasi -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
                            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                                <h4 class="font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-file-alt mr-2" aria-hidden="true"></i>Administrasi Pasca Putusan
                                </h4>
                            </div>
                            <div class="p-4 space-y-3">
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Tanggal Minutasi:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_minut ? $perkara->tgl_minut->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Tanggal Serah:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_serah ? $perkara->tgl_serah->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Tanggal Surat:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_srt_pta ? $perkara->tgl_srt_pta->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Tanggal Kirim:</span>
                                    <span class="text-gray-600">{{ $perkara->tgl_kirim_pta ? $perkara->tgl_kirim_pta->format('d/m/Y') : '-' }}</span>
                                </div>
                            </div>  
                        </div>
                    </div>
                </section>

                <!-- Action Buttons -->
                <div class="flex flex-wrap justify-end gap-3 mt-8 pt-5 border-t border-gray-200">
                    <a href="{{ route('perkaras.edit', $perkara->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium flex items-center transition-colors">
                        <i class="fas fa-edit mr-2" aria-hidden="true"></i> Edit Data
                    </a>
                    <a href="{{ route('perkaras.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium flex items-center transition-colors">
                        <i class="fas fa-list mr-2" aria-hidden="true"></i> Daftar Perkara
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>