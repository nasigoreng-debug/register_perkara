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
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-down': 'slideDown 0.3s ease-out',
                        'pulse-soft': 'pulseSoft 2s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            from: {
                                opacity: 0,
                                transform: 'translateY(10px)'
                            },
                            to: {
                                opacity: 1,
                                transform: 'translateY(0)'
                            }
                        },
                        slideDown: {
                            from: {
                                opacity: 0,
                                transform: 'translateY(-10px)'
                            },
                            to: {
                                opacity: 1,
                                transform: 'translateY(0)'
                            }
                        },
                        pulseSoft: {
                            '0%, 100%': {
                                opacity: 1
                            },
                            '50%': {
                                opacity: 0.8
                            }
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 font-sans antialiased p-5">
    <div class="container mx-auto mt-6 max-w-6xl">
        <!-- Main Card Container -->
        <div
            class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl animate-fade-in">

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white py-5 px-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">
                            <i class="fas fa-info-circle mr-2" aria-hidden="true"></i>Detail Perkara
                        </h1>
                        <div class="flex items-center text-blue-100">
                            <i class="fas fa-gavel mr-2"></i>
                            <span class="text-sm">{{ $perkara->perkara }}</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
                        <a href="{{ route('perkaras.edit', $perkara->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm flex items-center transition-all duration-200 transform hover:-translate-y-0.5 shadow-md hover:shadow-lg">
                            <i class="fas fa-edit mr-2" aria-hidden="true"></i> Edit
                        </a>
                        <a href="{{ route('perkaras.index') }}"
                            class="bg-white hover:bg-gray-100 text-gray-800 px-4 py-2 rounded-lg text-sm flex items-center transition-all duration-200 transform hover:-translate-y-0.5 shadow-md hover:shadow-lg">
                            <i class="fas fa-arrow-left mr-2" aria-hidden="true"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6">
                <!-- Header Info -->
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 p-4 bg-blue-50 rounded-lg">
                    <div>
                        <h2 class="text-primary font-bold text-lg">{{ $perkara->no_reg_pta }}</h2>
                        <p class="text-gray-600">{{ $perkara->no_put_pa }}</p>
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            @if ($perkara->tgl_putus)
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded-full flex items-center shadow-sm">
                                    <i class="fas fa-check-circle mr-1" aria-hidden="true"></i> PUTUS
                                </span>
                            @elseif($perkara->tgl_sidang)
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-1 rounded-full flex items-center shadow-sm">
                                    <i class="fas fa-clock mr-1" aria-hidden="true"></i> PROSES SIDANG
                                </span>
                            @elseif($perkara->tgl_phs)
                                <span
                                    class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-1 rounded-full flex items-center shadow-sm">
                                    <i class="fas fa-calendar-check mr-1" aria-hidden="true"></i> MENUNGGU SIDANG
                                </span>
                            @else
                                <span
                                    class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-1 rounded-full flex items-center shadow-sm">
                                    <i class="fas fa-hourglass mr-1" aria-hidden="true"></i> PROSES AWAL
                                </span>
                            @endif
                            <small class="text-gray-500 flex items-center">
                                <i class="fas fa-clock-history mr-1" aria-hidden="true"></i>Dibuat:
                                {{ $perkara->created_at ? $perkara->created_at->format('d/m/Y H:i') : '-' }}
                            </small>
                        </div>
                    </div>
                    <div class="mt-3 md:mt-0">
                        <form action="{{ route('perkaras.destroy', $perkara->id) }}" method="POST" class="inline"
                            id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm flex items-center transition-all duration-200 transform hover:-translate-y-0.5 shadow-md hover:shadow-lg"
                                onclick="confirmDelete()">
                                <i class="fas fa-trash mr-2" aria-hidden="true"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-8 bg-white p-4 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-tasks mr-2 text-blue-500" aria-hidden="true"></i>Status Perkara
                    </h3>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                        @php
                            $progress = 0;
                            if ($perkara->tgl_putus) {
                                $progress = 100;
                            } elseif ($perkara->tgl_sidang) {
                                $progress = 70;
                            } elseif ($perkara->tgl_phs) {
                                $progress = 50;
                            } elseif ($perkara->tgl_pmh) {
                                $progress = 30;
                            } elseif ($perkara->tgl_reg_pta) {
                                $progress = 10;
                            }
                        @endphp
                        <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500"
                            style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-600">
                        <span>Pendaftaran</span>
                        <span>Proses</span>
                        <span>Sidang</span>
                        <span>Putusan</span>
                    </div>
                </div>

                <!-- Timeline Progress Section -->
                <section class="mb-8 bg-white p-5 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-clock-history mr-2 text-blue-500" aria-hidden="true"></i>Timeline Proses
                    </h3>
                    <div class="relative">
                        <!-- Garis vertikal untuk timeline -->
                        <div class="absolute left-4 top-0 h-full w-0.5 bg-blue-200"></div>

                        <div class="space-y-8 pl-12">
                            @php $timelineSteps = 0; @endphp

                            @if ($perkara->tgl_reg_pta)
                                @php $timelineSteps++; @endphp
                                <div class="relative flex items-start group">
                                    <div
                                        class="absolute -left-8 mt-1.5 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 group-hover:bg-blue-200 transition-colors duration-200">
                                        <span class="text-blue-700 font-bold">{{ $timelineSteps }}</span>
                                    </div>
                                    <div
                                        class="min-w-0 flex-1 bg-blue-50 p-4 rounded-lg group-hover:bg-blue-100 transition-colors duration-200">
                                        <div>
                                            <div class="font-medium text-gray-900">Register</div>
                                            <div class="mt-1 text-sm text-gray-600">
                                                {{ $perkara->tgl_reg_pta ? $perkara->tgl_reg_pta->format('d/m/Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($perkara->tgl_pmh)
                                @php $timelineSteps++; @endphp
                                <div class="relative flex items-start group">
                                    <div
                                        class="absolute -left-8 mt-1.5 flex h-8 w-8 items-center justify-center rounded-full bg-green-100 group-hover:bg-green-200 transition-colors duration-200">
                                        <span class="text-green-700 font-bold">{{ $timelineSteps }}</span>
                                    </div>
                                    <div
                                        class="min-w-0 flex-1 bg-green-50 p-4 rounded-lg group-hover:bg-green-100 transition-colors duration-200">
                                        <div>
                                            <div class="font-medium text-gray-900">Penunjukkan Majelis Hakim</div>
                                            <div class="mt-1 text-sm text-gray-600">
                                                {{ $perkara->tgl_pmh ? $perkara->tgl_pmh->format('d/m/Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($perkara->tgl_ppp)
                                @php $timelineSteps++; @endphp
                                <div class="relative flex items-start group">
                                    <div
                                        class="absolute -left-8 mt-1.5 flex h-8 w-8 items-center justify-center rounded-full bg-cyan-100 group-hover:bg-cyan-200 transition-colors duration-200">
                                        <span class="text-cyan-700 font-bold">{{ $timelineSteps }}</span>
                                    </div>
                                    <div
                                        class="min-w-0 flex-1 bg-cyan-50 p-4 rounded-lg group-hover:bg-cyan-100 transition-colors duration-200">
                                        <div>
                                            <div class="font-medium text-gray-900">Penunjukkan Panitera Pengganti</div>
                                            <div class="mt-1 text-sm text-gray-600">
                                                {{ $perkara->tgl_ppp ? $perkara->tgl_ppp->format('d/m/Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($perkara->tgl_phs)
                                @php $timelineSteps++; @endphp
                                <div class="relative flex items-start group">
                                    <div
                                        class="absolute -left-8 mt-1.5 flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100 group-hover:bg-yellow-200 transition-colors duration-200">
                                        <span class="text-yellow-700 font-bold">{{ $timelineSteps }}</span>
                                    </div>
                                    <div
                                        class="min-w-0 flex-1 bg-yellow-50 p-4 rounded-lg group-hover:bg-yellow-100 transition-colors duration-200">
                                        <div>
                                            <div class="font-medium text-gray-900">Penetapan Hari Sidang</div>
                                            <div class="mt-1 text-sm text-gray-600">
                                                {{ $perkara->tgl_phs ? $perkara->tgl_phs->format('d/m/Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($perkara->tgl_sidang)
                                @php $timelineSteps++; @endphp
                                <div class="relative flex items-start group">
                                    <div
                                        class="absolute -left-8 mt-1.5 flex h-8 w-8 items-center justify-center rounded-full bg-red-100 group-hover:bg-red-200 transition-colors duration-200">
                                        <span class="text-red-700 font-bold">{{ $timelineSteps }}</span>
                                    </div>
                                    <div
                                        class="min-w-0 flex-1 bg-red-50 p-4 rounded-lg group-hover:bg-red-100 transition-colors duration-200">
                                        <div>
                                            <div class="font-medium text-gray-900">Sidang</div>
                                            <div class="mt-1 text-sm text-gray-600">
                                                {{ $perkara->tgl_sidang ? $perkara->tgl_sidang->format('d/m/Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($perkara->tgl_sela)
                                @php $timelineSteps++; @endphp
                                <div class="relative flex items-start group">
                                    <div
                                        class="absolute -left-8 mt-1.5 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 group-hover:bg-blue-200 transition-colors duration-200">
                                        <span class="text-blue-700 font-bold">{{ $timelineSteps }}</span>
                                    </div>
                                    <div
                                        class="min-w-0 flex-1 bg-blue-50 p-4 rounded-lg group-hover:bg-blue-100 transition-colors duration-200">
                                        <div>
                                            <div class="font-medium text-gray-900">Putus Sela</div>
                                            <div class="mt-1 text-sm text-gray-600">
                                                {{ $perkara->tgl_sela ? $perkara->tgl_sela->format('d/m/Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($perkara->tgl_putus)
                                @php $timelineSteps++; @endphp
                                <div class="relative flex items-start group">
                                    <div
                                        class="absolute -left-8 mt-1.5 flex h-8 w-8 items-center justify-center rounded-full bg-green-100 group-hover:bg-green-200 transition-colors duration-200">
                                        <span class="text-green-700 font-bold">{{ $timelineSteps }}</span>
                                    </div>
                                    <div
                                        class="min-w-0 flex-1 bg-green-50 p-4 rounded-lg group-hover:bg-green-100 transition-colors duration-200">
                                        <div>
                                            <div class="font-medium text-gray-900">Putusan</div>
                                            <div class="mt-1 text-sm text-gray-600">
                                                {{ $perkara->tgl_putus ? $perkara->tgl_putus->format('d/m/Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($perkara->tgl_minut)
                                @php $timelineSteps++; @endphp
                                <div class="relative flex items-start group">
                                    <div
                                        class="absolute -left-8 mt-1.5 flex h-8 w-8 items-center justify-center rounded-full bg-cyan-100 group-hover:bg-cyan-200 transition-colors duration-200">
                                        <span class="text-cyan-700 font-bold">{{ $timelineSteps }}</span>
                                    </div>
                                    <div
                                        class="min-w-0 flex-1 bg-cyan-50 p-4 rounded-lg group-hover:bg-cyan-100 transition-colors duration-200">
                                        <div>
                                            <div class="font-medium text-gray-900">Minutasi</div>
                                            <div class="mt-1 text-sm text-gray-600">
                                                {{ $perkara->tgl_minut ? $perkara->tgl_minut->format('d/m/Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($perkara->tgl_serah)
                                @php $timelineSteps++; @endphp
                                <div class="relative flex items-start group">
                                    <div
                                        class="absolute -left-8 mt-1.5 flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100 group-hover:bg-yellow-200 transition-colors duration-200">
                                        <span class="text-yellow-700 font-bold">{{ $timelineSteps }}</span>
                                    </div>
                                    <div
                                        class="min-w-0 flex-1 bg-yellow-50 p-4 rounded-lg group-hover:bg-yellow-100 transition-colors duration-200">
                                        <div>
                                            <div class="font-medium text-gray-900">Penyerahan Berkas</div>
                                            <div class="mt-1 text-sm text-gray-600">
                                                {{ $perkara->tgl_serah ? $perkara->tgl_serah->format('d/m/Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($perkara->tgl_kirim_pta)
                                @php $timelineSteps++; @endphp
                                <div class="relative flex items-start group">
                                    <div
                                        class="absolute -left-8 mt-1.5 flex h-8 w-8 items-center justify-center rounded-full bg-red-100 group-hover:bg-red-200 transition-colors duration-200">
                                        <span class="text-red-700 font-bold">{{ $timelineSteps }}</span>
                                    </div>
                                    <div
                                        class="min-w-0 flex-1 bg-red-50 p-4 rounded-lg group-hover:bg-red-100 transition-colors duration-200">
                                        <div>
                                            <div class="font-medium text-gray-900">Kirim ke Satker</div>
                                            <div class="mt-1 text-sm text-gray-600">
                                                {{ $perkara->tgl_kirim_pta ? $perkara->tgl_kirim_pta->format('d/m/Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                <!-- Detail Information Section with Tabs -->
                <section class="mb-8 bg-white rounded-lg shadow-sm overflow-hidden">
                    <!-- Tab Headers -->
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <button id="tab-identitas"
                                class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600 flex items-center justify-center gap-2"
                                onclick="switchTab('identitas')">
                                <i class="fas fa-building"></i>
                                <span>Identitas Perkara</span>
                            </button>
                            <button id="tab-majelis"
                                class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center gap-2"
                                onclick="switchTab('majelis')">
                                <i class="fas fa-users"></i>
                                <span>Majelis Hakim</span>
                            </button>
                            <button id="tab-pta"
                                class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center gap-2"
                                onclick="switchTab('pta')">
                                <i class="fas fa-house"></i>
                                <span>Penerimaan PTA</span>
                            </button>
                            <button id="tab-sidang"
                                class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center gap-2"
                                onclick="switchTab('sidang')">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Proses Sidang</span>
                            </button>
                            <button id="tab-administrasi"
                                class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center gap-2"
                                onclick="switchTab('administrasi')">
                                <i class="fas fa-file-alt"></i>
                                <span>Administrasi</span>
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Contents -->
                    <div class="p-6">
                        <!-- Identitas Perkara Tab -->
                        <div id="content-identitas" class="tab-content">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Nomor Perkara PA:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->no_reg_pa ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Jenis Perkara:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->jenis_perkara ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Tanggal Putus PA:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_put_pa ? $perkara->tgl_put_pa->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Tanggal Akta Banding:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_akta_banding ? $perkara->tgl_akta_banding->format('d/m/Y') : '-' }}</span>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Tanggal Surat PA:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_srt_pa ? $perkara->tgl_srt_pa->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">No. Surat PA:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->no_srt_pa ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Pembanding:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->pembanding ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Terbanding:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->terbanding ?: '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Majelis Hakim Tab -->
                        <div id="content-majelis" class="tab-content hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Hakim Ketua:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->hakim_ketua ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Hakim Anggota 1:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->hakim_anggota1 ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Hakim Anggota 2:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->hakim_anggota2 ?: '-' }}</span>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Panitera Pengganti:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->panitera_pengganti ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Penunjukkan Majelis Hakim:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_pmh ? $perkara->tgl_pmh->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Penunjukkan Panitera Pengganti:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_ppp ? $perkara->tgl_ppp->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Diterima Ketua Majelis:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_trm_km ? $perkara->tgl_trm_km->format('d/m/Y') : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PTA Tab -->
                        <div id="content-pta" class="tab-content hidden">
                            <div class="grid grid-cols-1 gap-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Tanggal Terima PTA:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_trm_pta ? $perkara->tgl_trm_pta->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">No. Register PTA:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->no_reg_pta ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Tanggal Register PTA:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_reg_pta ? $perkara->tgl_reg_pta->format('d/m/Y') : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidang Tab -->
                        <div id="content-sidang" class="tab-content hidden">
                            <div class="grid grid-cols-1 gap-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Penetapan Hari Sidang:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_phs ? $perkara->tgl_phs->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Tanggal Sidang:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_sidang ? $perkara->tgl_sidang->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Tanggal Putus Sela:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_sela ? $perkara->tgl_sela->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Tanggal Putus:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_putus ? $perkara->tgl_putus->format('d/m/Y') : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Administrasi Tab -->
                        <div id="content-administrasi" class="tab-content hidden">
                            <div class="grid grid-cols-1 gap-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Tanggal Minutasi:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_minut ? $perkara->tgl_minut->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Tanggal Serah:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_serah ? $perkara->tgl_serah->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Tanggal Surat:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_srt_pta ? $perkara->tgl_srt_pta->format('d/m/Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Tanggal Kirim:</span>
                                        <span
                                            class="text-gray-600 bg-white px-3 py-1 rounded-md shadow-sm">{{ $perkara->tgl_kirim_pta ? $perkara->tgl_kirim_pta->format('d/m/Y') : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Action Buttons -->
                <div class="flex flex-wrap justify-end gap-3 mt-8 pt-5 border-t border-gray-200">
                    <a href="{{ route('perkaras.edit', $perkara->id) }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2.5 rounded-lg font-medium flex items-center transition-all duration-200 transform hover:-translate-y-0.5 shadow-md hover:shadow-lg">
                        <i class="fas fa-edit mr-2" aria-hidden="true"></i> Edit Data
                    </a>
                    <a href="{{ route('perkaras.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg font-medium flex items-center transition-all duration-200 transform hover:-translate-y-0.5 shadow-md hover:shadow-lg">
                        <i class="fas fa-list mr-2" aria-hidden="true"></i> Daftar Perkara
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk interaktivitas -->
    <script>
        // Fungsi untuk konfirmasi penghapusan
        function confirmDelete() {
            if (confirm('Apakah Anda yakin ingin menghapus data perkara ini? Tindakan ini tidak dapat dibatalkan.')) {
                document.getElementById('deleteForm').submit();
            }
        }

        // Fungsi untuk beralih tab
        function switchTab(tabName) {
            // Sembunyikan semua konten tab
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Tampilkan tab yang dipilih
            document.getElementById('content-' + tabName).classList.remove('hidden');

            // Perbarui tampilan tab header
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-blue-500', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700',
                    'hover:border-gray-300');
            });

            // Aktifkan tab yang dipilih
            document.getElementById('tab-' + tabName).classList.add('border-blue-500', 'text-blue-600');
            document.getElementById('tab-' + tabName).classList.remove('border-transparent', 'text-gray-500',
                'hover:text-gray-700', 'hover:border-gray-300');
        }

        // Animasi untuk elemen timeline saat scroll
        document.addEventListener('DOMContentLoaded', function() {
            const timelineItems = document.querySelectorAll('.relative.flex.items-start.group');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateX(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            timelineItems.forEach((item, index) => {
                item.style.opacity = 0;
                item.style.transform = 'translateX(-20px)';
                item.style.transition =
                    `opacity 0.5s ease ${index * 0.1}s, transform 0.5s ease ${index * 0.1}s`;
                observer.observe(item);
            });
        });
    </script>
</body>

</html>
