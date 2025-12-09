<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Perkara - {{ $perkara->no_reg_pta }}</title>
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
        .required-field::after {
            content: "*";
            color: #dc3545;
            margin-left: 4px;
        }

        /* Gaya untuk field yang sudah terisi */
        .field-filled {
            background-color: #f0fff4 !important;
            border-left: 4px solid #28a745 !important;
        }

        /* Gaya untuk field yang masih kosong */
        .field-empty {
            background-color: #fff8f8 !important;
            border-left: 4px solid #dc3545 !important;
        }

        /* Gaya untuk field yang sedang diisi */
        .form-control:focus {
            background-color: #f0f8ff !important;
            border-left: 4px solid #0d6efd !important;
        }

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

        .card-hover {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .section-toggle {
            cursor: pointer;
            user-select: none;
        }

        .section-content {
            transition: max-height 0.3s ease-out;
            overflow: hidden;
        }

        .collapsed {
            max-height: 0;
        }

        .expanded {
            max-height: 2000px;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased p-5">
    <div class="container mx-auto mt-6 max-w-6xl">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
            <!-- Header -->
            <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 py-5 px-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <h4 class="text-xl font-bold mb-3 md:mb-0">
                        <i class="fas fa-edit mr-2"></i> Edit Perkara
                    </h4>
                    <a href="{{ route('perkaras.index') }}"
                        class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm flex items-center transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="p-6">
                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-primary p-4 mb-6 rounded-lg">
                    <h5 class="font-bold text-gray-800 mb-1">No. Perkara: <strong>{{ $perkara->no_reg_pta }}</strong>
                    </h5>
                    <p class="text-gray-600 mb-0">Terakhir diupdate:
                        @if ($perkara->updated_at)
                            {{ $perkara->updated_at->format('d/m/Y H:i') }}
                        @else
                            <span class="text-gray-500">Belum pernah diupdate</span>
                        @endif
                    </p>
                    <p class="text-gray-600 mt-2 text-sm">
                        <i class="fas fa-info-circle mr-1"></i>
                        Field dengan latar hijau sudah terisi, field dengan latar merah masih kosong.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded animate-fade-in">
                        <h5 class="font-bold mb-2 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Terdapat kesalahan:
                        </h5>
                        <ul class="list-disc list-inside pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div
                        class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded animate-fade-in flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" class="text-green-700 hover:text-green-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <form action="{{ route('perkaras.update', $perkara->id) }}" method="POST" id="perkaraForm">
                    @csrf
                    @method('PUT')

                    <!-- Informasi Umum Perkara -->
                    <div class="mb-6">
                        <div
                            class="section-toggle flex items-center justify-between text-lg font-semibold text-primary border-b-2 border-primary pb-2 mb-4 mt-6">
                            <span><i class="fas fa-info-circle mr-2"></i> Informasi Umum Perkara</span>
                            <i class="fas fa-chevron-down transition-transform"></i>
                        </div>
                        <div class="section-content expanded">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <!-- Satker -->
                                <div>
                                    <label for="satker" class="block text-gray-700 font-medium mb-2">
                                        <span class="required-field">Satker</span>
                                    </label>
                                    <select name="satker"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled @error('satker') border-red-500 @enderror"
                                        id="satker" required>
                                        <option value="">Pilih Satker</option>
                                        <option value="Bandung"
                                            {{ old('satker', $perkara->satker) == 'Bandung' ? 'selected' : '' }}>Bandung
                                        </option>
                                        <option value="Bekasi"
                                            {{ old('satker', $perkara->satker) == 'Bekasi' ? 'selected' : '' }}>Bekasi
                                        </option>
                                        <option value="Bogor"
                                            {{ old('satker', $perkara->satker) == 'Bogor' ? 'selected' : '' }}>Bogor
                                        </option>
                                        <option value="Ciamis"
                                            {{ old('satker', $perkara->satker) == 'Ciamis' ? 'selected' : '' }}>Ciamis
                                        </option>
                                        <option value="Cianjur"
                                            {{ old('satker', $perkara->satker) == 'Cianjur' ? 'selected' : '' }}>
                                            Cianjur</option>
                                        <option value="Cibadak"
                                            {{ old('satker', $perkara->satker) == 'Cibadak' ? 'selected' : '' }}>
                                            Cibadak</option>
                                        <option value="Cibinong"
                                            {{ old('satker', $perkara->satker) == 'Cibinong' ? 'selected' : '' }}>
                                            Cibinong</option>
                                        <option value="Cikarang"
                                            {{ old('satker', $perkara->satker) == 'Cikarang' ? 'selected' : '' }}>
                                            Cikarang</option>
                                        <option value="Cirebon"
                                            {{ old('satker', $perkara->satker) == 'Cirebon' ? 'selected' : '' }}>
                                            Cirebon</option>
                                        <option value="Depok"
                                            {{ old('satker', $perkara->satker) == 'Depok' ? 'selected' : '' }}>Depok
                                        </option>
                                        <option value="Garut"
                                            {{ old('satker', $perkara->satker) == 'Garut' ? 'selected' : '' }}>Garut
                                        </option>
                                        <option value="Indramayu"
                                            {{ old('satker', $perkara->satker) == 'Indramayu' ? 'selected' : '' }}>
                                            Indramayu</option>
                                        <option value="Karawang"
                                            {{ old('satker', $perkara->satker) == 'Karawang' ? 'selected' : '' }}>
                                            Karawang</option>
                                        <option value="Kota Banjar"
                                            {{ old('satker', $perkara->satker) == 'Kota Banjar' ? 'selected' : '' }}>
                                            Kota Banjar</option>
                                        <option value="Kota Cimahi"
                                            {{ old('satker', $perkara->satker) == 'Kota Cimahi' ? 'selected' : '' }}>
                                            Kota Cimahi</option>
                                        <option value="Kota Tasikmalaya"
                                            {{ old('satker', $perkara->satker) == 'Kota Tasikmalaya' ? 'selected' : '' }}>
                                            Kota Tasikmalaya</option>
                                        <option value="Kuningan"
                                            {{ old('satker', $perkara->satker) == 'Kuningan' ? 'selected' : '' }}>
                                            Kuningan</option>
                                        <option value="Majalengka"
                                            {{ old('satker', $perkara->satker) == 'Majalengka' ? 'selected' : '' }}>
                                            Majalengka</option>
                                        <option value="Ngamprah"
                                            {{ old('satker', $perkara->satker) == 'Ngamprah' ? 'selected' : '' }}>
                                            Ngamprah</option>
                                        <option value="Purwakarta"
                                            {{ old('satker', $perkara->satker) == 'Purwakarta' ? 'selected' : '' }}>
                                            Purwakarta</option>
                                        <option value="Soreang"
                                            {{ old('satker', $perkara->satker) == 'Soreang' ? 'selected' : '' }}>
                                            Soreang</option>
                                        <option value="Subang"
                                            {{ old('satker', $perkara->satker) == 'Subang' ? 'selected' : '' }}>Subang
                                        </option>
                                        <option value="Sukabumi"
                                            {{ old('satker', $perkara->satker) == 'Sukabumi' ? 'selected' : '' }}>
                                            Sukabumi</option>
                                        <option value="Sumber"
                                            {{ old('satker', $perkara->satker) == 'Sumber' ? 'selected' : '' }}>Sumber
                                        </option>
                                        <option value="Sumedang"
                                            {{ old('satker', $perkara->satker) == 'Sumedang' ? 'selected' : '' }}>
                                            Sumedang</option>
                                        <option value="Tasikmalaya"
                                            {{ old('satker', $perkara->satker) == 'Tasikmalaya' ? 'selected' : '' }}>
                                            Tasikmalaya</option>
                                    </select>
                                    @error('satker')
                                        <p class="text-red-500 text-xs mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Jenis Perkara -->
                                <div>
                                    <label for="jenis_perkara" class="block text-gray-700 font-medium mb-2">
                                        <span class="required-field">Jenis Perkara</span>
                                    </label>
                                    <select name="jenis_perkara"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled @error('jenis_perkara') border-red-500 @enderror"
                                        id="jenis_perkara" required>
                                        <option value="">Pilih Jenis Perkara</option>
                                        <option value="Asal Usul Anak"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Asal Usul Anak' ? 'selected' : '' }}>
                                            Asal Usul Anak</option>
                                        <option value="Cerai Gugat"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Cerai Gugat' ? 'selected' : '' }}>
                                            Cerai Gugat</option>
                                        <option value="Cerai Talak"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Cerai Talak' ? 'selected' : '' }}>
                                            Cerai Talak</option>
                                        <option value="Dispensasi Kawin"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Dispensasi Kawin' ? 'selected' : '' }}>
                                            Dispensasi Kawin</option>
                                        <option value="Ekonomi Syariah"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Ekonomi Syariah' ? 'selected' : '' }}>
                                            Ekonomi Syariah</option>
                                        <option value="Harta Bersama"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Harta Bersama' ? 'selected' : '' }}>
                                            Harta Bersama</option>
                                        <option value="Hibah"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Hibah' ? 'selected' : '' }}>
                                            Hibah</option>
                                        <option value="Isbath Nikah"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Isbath Nikah' ? 'selected' : '' }}>
                                            Isbath Nikah</option>
                                        <option value="Izin Poligami"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Izin Poligami' ? 'selected' : '' }}>
                                            Izin Poligami</option>
                                        <option value="Kewarisan"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Kewarisan' ? 'selected' : '' }}>
                                            Kewarisan</option>
                                        <option value="P3HP/Penetapan Ahli Waris"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'P3HP/Penetapan Ahli Waris' ? 'selected' : '' }}>
                                            P3HP/Penetapan Ahli Waris</option>
                                        <option value="Pembatalan Perkawinan"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Pembatalan Perkawinan' ? 'selected' : '' }}>
                                            Pembatalan Perkawinan</option>
                                        <option value="Pengesahan Anak/Pengangkatan Anak"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Pengesahan Anak/Pengangkatan Anak' ? 'selected' : '' }}>
                                            Pengesahan Anak/Pengangkatan Anak</option>
                                        <option value="Perwalian"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Perwalian' ? 'selected' : '' }}>
                                            Perwalian</option>
                                        <option value="Wakaf"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Wakaf' ? 'selected' : '' }}>
                                            Wakaf</option>
                                        <option value="Wasiat"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Wasiat' ? 'selected' : '' }}>
                                            Wasiat</option>
                                        <option value="Zakat/Infaq/Shodaqoh"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Zakat/Infaq/Shodaqoh' ? 'selected' : '' }}>
                                            Zakat/Infaq/Shodaqoh</option>
                                        <option value="Lain-lain"
                                            {{ old('jenis_perkara', $perkara->jenis_perkara) == 'Lain-lain' ? 'selected' : '' }}>
                                            Lain-lain</option>
                                    </select>
                                    @error('jenis_perkara')
                                        <p class="text-red-500 text-xs mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Nomor Register PTA -->
                                <div>
                                    <label for="no_reg_pta" class="block text-gray-700 font-medium mb-2">
                                        <span class="required-field">Nomor Register PTA</span>
                                    </label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled @error('no_reg_pta') border-red-500 @enderror"
                                        id="no_reg_pta" name="no_reg_pta"
                                        value="{{ old('no_reg_pta', $perkara->no_reg_pta) }}"
                                        placeholder="Contoh: 123/Pdt.G/2025/PTA.Bdg" required>
                                    <small class="text-gray-500 mt-1 block">Format:
                                        Nomor/Jenis/Tahun/Pengadilan</small>
                                    @error('no_reg_pta')
                                        <p class="text-red-500 text-xs mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Keterangan -->
                                <div>
                                    <label for="keterangan" class="block text-gray-700 font-medium mb-2">
                                        <span class="required-field">Keterangan</span>
                                    </label>
                                    <select name="keterangan"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled @error('keterangan') border-red-500 @enderror"
                                        id="keterangan" required>
                                        <option value="">Pilih Keterangan</option>
                                        <option value="e-court"
                                            {{ old('keterangan', $perkara->keterangan) == 'e-court' ? 'selected' : '' }}>
                                            e-Court</option>
                                        <option value="non e-court"
                                            {{ old('keterangan', $perkara->keterangan) == 'non e-court' ? 'selected' : '' }}>
                                            Non e-Court</option>
                                    </select>
                                    @error('keterangan')
                                        <p class="text-red-500 text-xs mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pihak -->
                    <div class="mb-6">
                        <div
                            class="section-toggle flex items-center justify-between text-lg font-semibold text-primary border-b-2 border-primary pb-2 mb-4 mt-8">
                            <span><i class="fas fa-users mr-2"></i> Informasi Pihak</span>
                            <i class="fas fa-chevron-down transition-transform"></i>
                        </div>
                        <div class="section-content expanded">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label for="pembanding"
                                        class="block text-gray-700 font-medium mb-2">Pembanding</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="pembanding" name="pembanding"
                                        value="{{ old('pembanding', $perkara->pembanding) }}"
                                        placeholder="Nama Pembanding">
                                </div>

                                <div>
                                    <label for="terbanding"
                                        class="block text-gray-700 font-medium mb-2">Terbanding</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="terbanding" name="terbanding"
                                        value="{{ old('terbanding', $perkara->terbanding) }}"
                                        placeholder="Nama Terbanding">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pengadilan Tingkat Pertama (PA) -->
                    <div class="mb-6">
                        <div
                            class="section-toggle flex items-center justify-between text-lg font-semibold text-primary border-b-2 border-primary pb-2 mb-4 mt-8">
                            <span><i class="fas fa-gavel mr-2"></i> Informasi Pengadilan Tingkat Pertama (PA)</span>
                            <i class="fas fa-chevron-down transition-transform"></i>
                        </div>
                        <div class="section-content expanded">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label for="no_reg_pa" class="block text-gray-700 font-medium mb-2">
                                        <span class="required-field">Nomor Putusan PA</span>
                                    </label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="no_reg_pa" name="no_reg_pa"
                                        value="{{ old('no_reg_pa', $perkara->no_reg_pa) }}"
                                        placeholder="Contoh: 123/Pdt.G/2025/PA.Badg" required>
                                    <small class="text-gray-500 mt-1 block">Format:
                                        Nomor/Jenis/Tahun/Pengadilan</small>
                                </div>

                                <div>
                                    <label for="tgl_put_pa" class="block text-gray-700 font-medium mb-2">Tanggal
                                        Putusan PA</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_put_pa" name="tgl_put_pa"
                                        value="{{ old('tgl_put_pa', $perkara->tgl_put_pa ? $perkara->tgl_put_pa->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="tgl_akta_banding" class="block text-gray-700 font-medium mb-2">Tanggal
                                        Akta Banding</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_akta_banding" name="tgl_akta_banding"
                                        value="{{ old('tgl_akta_banding', $perkara->tgl_akta_banding ? $perkara->tgl_akta_banding->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="no_srt_pa" class="block text-gray-700 font-medium mb-2">Nomor Surat
                                        PA</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="no_srt_pa" name="no_srt_pa"
                                        value="{{ old('no_srt_pa', $perkara->no_srt_pa) }}"
                                        placeholder="Contoh: 001/PDT/PA/2023">
                                </div>

                                <div>
                                    <label for="tgl_srt_pa" class="block text-gray-700 font-medium mb-2">Tanggal Surat
                                        PA</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_srt_pa" name="tgl_srt_pa"
                                        value="{{ old('tgl_srt_pa', $perkara->tgl_srt_pa ? $perkara->tgl_srt_pa->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="alamat_pa" class="block text-gray-700 font-medium mb-2">Alamat
                                        PA</label>
                                    <textarea
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="alamat_pa" name="alamat_pa" rows="2" placeholder="Alamat Pengadilan Agama">{{ old('alamat_pa', $perkara->alamat_pa) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pengadilan Tinggi Agama (PTA) -->
                    <div class="mb-6">
                        <div
                            class="section-toggle flex items-center justify-between text-lg font-semibold text-primary border-b-2 border-primary pb-2 mb-4 mt-8">
                            <span><i class="fas fa-scale-balanced mr-2"></i> Informasi Pengadilan Tinggi Agama
                                (PTA)</span>
                            <i class="fas fa-chevron-down transition-transform"></i>
                        </div>
                        <div class="section-content expanded">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label for="tgl_trm_pta" class="block text-gray-700 font-medium mb-2">Tanggal
                                        Terima PTA</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_trm_pta" name="tgl_trm_pta"
                                        value="{{ old('tgl_trm_pta', $perkara->tgl_trm_pta ? $perkara->tgl_trm_pta->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="tgl_reg_pta" class="block text-gray-700 font-medium mb-2">Tanggal
                                        Register PTA</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_reg_pta" name="tgl_reg_pta"
                                        value="{{ old('tgl_reg_pta', $perkara->tgl_reg_pta ? $perkara->tgl_reg_pta->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="tgl_srt_pta" class="block text-gray-700 font-medium mb-2">Tanggal
                                        Surat PTA</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_srt_pta" name="tgl_srt_pta"
                                        value="{{ old('tgl_srt_pta', $perkara->tgl_srt_pta ? $perkara->tgl_srt_pta->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="tgl_kirim_pta" class="block text-gray-700 font-medium mb-2">Tanggal
                                        Kirim PTA</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_kirim_pta" name="tgl_kirim_pta"
                                        value="{{ old('tgl_kirim_pta', $perkara->tgl_kirim_pta ? $perkara->tgl_kirim_pta->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Majelis Hakim dan Panitera -->
                    <div class="mb-6">
                        <div
                            class="section-toggle flex items-center justify-between text-lg font-semibold text-primary border-b-2 border-primary pb-2 mb-4 mt-8">
                            <span><i class="fas fa-user-tie mr-2"></i> Majelis Hakim dan Panitera</span>
                            <i class="fas fa-chevron-down transition-transform"></i>
                        </div>
                        <div class="section-content expanded">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label for="hakim_ketua" class="block text-gray-700 font-medium mb-2">Hakim
                                        Ketua</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="hakim_ketua" name="hakim_ketua"
                                        value="{{ old('hakim_ketua', $perkara->hakim_ketua) }}"
                                        placeholder="Nama Hakim Ketua">
                                </div>

                                <div>
                                    <label for="hakim_anggota1" class="block text-gray-700 font-medium mb-2">Hakim
                                        Anggota 1</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="hakim_anggota1" name="hakim_anggota1"
                                        value="{{ old('hakim_anggota1', $perkara->hakim_anggota1) }}"
                                        placeholder="Nama Hakim Anggota 1">
                                </div>

                                <div>
                                    <label for="hakim_anggota2" class="block text-gray-700 font-medium mb-2">Hakim
                                        Anggota 2</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="hakim_anggota2" name="hakim_anggota2"
                                        value="{{ old('hakim_anggota2', $perkara->hakim_anggota2) }}"
                                        placeholder="Nama Hakim Anggota 2">
                                </div>

                                <div>
                                    <label for="panitera_pengganti"
                                        class="block text-gray-700 font-medium mb-2">Panitera Pengganti</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="panitera_pengganti" name="panitera_pengganti"
                                        value="{{ old('panitera_pengganti', $perkara->panitera_pengganti) }}"
                                        placeholder="Nama Panitera Pengganti">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jadwal dan Penunjukkan -->
                    <div class="mb-6">
                        <div
                            class="section-toggle flex items-center justify-between text-lg font-semibold text-primary border-b-2 border-primary pb-2 mb-4 mt-8">
                            <span><i class="fas fa-calendar-days mr-2"></i> Jadwal dan Penunjukkan</span>
                            <i class="fas fa-chevron-down transition-transform"></i>
                        </div>
                        <div class="section-content expanded">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label for="tgl_pmh" class="block text-gray-700 font-medium mb-2">Penunjukkan
                                        Majelis Hakim</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_pmh" name="tgl_pmh"
                                        value="{{ old('tgl_pmh', $perkara->tgl_pmh ? $perkara->tgl_pmh->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="tgl_ppp" class="block text-gray-700 font-medium mb-2">Penunjukkan
                                        Panitera Pengganti</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_ppp" name="tgl_ppp"
                                        value="{{ old('tgl_ppp', $perkara->tgl_ppp ? $perkara->tgl_ppp->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="tgl_trm_km" class="block text-gray-700 font-medium mb-2">Terima Berkas
                                        Ketua Majelis </label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_trm_km" name="tgl_trm_km"
                                        value="{{ old('tgl_trm_km', $perkara->tgl_trm_km ? $perkara->tgl_trm_km->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="tgl_phs" class="block text-gray-700 font-medium mb-2">Penetapan Hari
                                        Sidang</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_phs" name="tgl_phs"
                                        value="{{ old('tgl_phs', $perkara->tgl_phs ? $perkara->tgl_phs->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="tgl_sidang" class="block text-gray-700 font-medium mb-2">
                                        <strong>Tanggal Sidang</strong>
                                    </label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_sidang" name="tgl_sidang"
                                        value="{{ old('tgl_sidang', $perkara->tgl_sidang ? $perkara->tgl_sidang->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="tgl_sela" class="block text-gray-700 font-medium mb-2">Tanggal
                                        Sela</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_sela" name="tgl_sela"
                                        value="{{ old('tgl_sela', $perkara->tgl_sela ? $perkara->tgl_sela->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Putusan dan Administrasi -->
                    <div class="mb-6">
                        <div
                            class="section-toggle flex items-center justify-between text-lg font-semibold text-primary border-b-2 border-primary pb-2 mb-4 mt-8">
                            <span><i class="fas fa-gavel mr-2"></i> Putusan dan Administrasi</span>
                            <i class="fas fa-chevron-down transition-transform"></i>
                        </div>
                        <div class="section-content expanded">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label for="tgl_putus" class="block text-gray-700 font-medium mb-2">Tanggal
                                        Putusan</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_putus" name="tgl_putus"
                                        value="{{ old('tgl_putus', $perkara->tgl_putus ? $perkara->tgl_putus->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="status_put" class="block text-gray-700 font-medium mb-2">Status
                                        Putusan</label>
                                    <select
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="status_put" name="status_put">
                                        <option value="" selected disabled>Pilih status...</option>
                                        <option value="Dikabulkan"
                                            {{ old('status_put', $perkara->status_put) == 'Dikabulkan' ? 'selected' : '' }}>
                                            Dikabulkan</option>
                                        <option value="Ditolak"
                                            {{ old('status_put', $perkara->status_put) == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                        <option value="Dicabut"
                                            {{ old('status_put', $perkara->status_put) == 'Dicabut' ? 'selected' : '' }}>
                                            Dicabut</option>
                                        <option value="Tidak Dapat Diterima"
                                            {{ old('status_put', $perkara->status_put) == 'Tidak Dapat Diterima' ? 'selected' : '' }}>
                                            Tidak Dapat Diterima</option>
                                        <option value="Digugurkan"
                                            {{ old('status_put', $perkara->status_put) == 'Digugurkan' ? 'selected' : '' }}>
                                            Digugurkan</option>
                                        <option value="Dicoret"
                                            {{ old('status_put', $perkara->status_put) == 'Dicoret' ? 'selected' : '' }}>
                                            Dicoret</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="tgl_minut" class="block text-gray-700 font-medium mb-2">Tanggal
                                        Minutasi</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_minut" name="tgl_minut"
                                        value="{{ old('tgl_minut', $perkara->tgl_minut ? $perkara->tgl_minut->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="tgl_serah" class="block text-gray-700 font-medium mb-2">Tanggal
                                        Serah</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_serah" name="tgl_serah"
                                        value="{{ old('tgl_serah', $perkara->tgl_serah ? $perkara->tgl_serah->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="tgl_surat" class="block text-gray-700 font-medium mb-2">Tanggal
                                        Surat</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_surat" name="tgl_surat"
                                        value="{{ old('tgl_surat', $perkara->tgl_surat ? $perkara->tgl_surat->format('Y-m-d') : '') }}">
                                </div>

                                <div>
                                    <label for="tgl_kirim" class="block text-gray-700 font-medium mb-2">Tanggal
                                        Kirim</label>
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tgl_kirim" name="tgl_kirim"
                                        value="{{ old('tgl_kirim', $perkara->tgl_kirim ? $perkara->tgl_kirim->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tembusan -->
                    <div class="mb-6">
                        <div
                            class="section-toggle flex items-center justify-between text-lg font-semibold text-primary border-b-2 border-primary pb-2 mb-4 mt-8">
                            <span><i class="fas fa-envelope mr-2"></i> Tembusan</span>
                            <i class="fas fa-chevron-down transition-transform"></i>
                        </div>
                        <div class="section-content expanded">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label for="tembusan" class="block text-gray-700 font-medium mb-2">Tembusan
                                        1</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tembusan" name="tembusan"
                                        value="{{ old('tembusan', $perkara->tembusan) }}"
                                        placeholder="Nama Penerima Tembusan">
                                </div>

                                <div>
                                    <label for="almt_tembusan" class="block text-gray-700 font-medium mb-2">Alamat
                                        Tembusan 1</label>
                                    <textarea
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="almt_tembusan" name="almt_tembusan" rows="2" placeholder="Alamat Tembusan">{{ old('almt_tembusan', $perkara->almt_tembusan) }}</textarea>
                                </div>

                                <div>
                                    <label for="tembusan1" class="block text-gray-700 font-medium mb-2">Tembusan
                                        2</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tembusan1" name="tembusan1"
                                        value="{{ old('tembusan1', $perkara->tembusan1) }}"
                                        placeholder="Nama Penerima Tembusan">
                                </div>

                                <div>
                                    <label for="almt_tembusan1" class="block text-gray-700 font-medium mb-2">Alamat
                                        Tembusan 2</label>
                                    <textarea
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="almt_tembusan1" name="almt_tembusan1" rows="2" placeholder="Alamat Tembusan">{{ old('almt_tembusan1', $perkara->almt_tembusan1) }}</textarea>
                                </div>

                                <div>
                                    <label for="tembusan2" class="block text-gray-700 font-medium mb-2">Tembusan
                                        3</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tembusan2" name="tembusan2"
                                        value="{{ old('tembusan2', $perkara->tembusan2) }}"
                                        placeholder="Nama Penerima Tembusan">
                                </div>

                                <div>
                                    <label for="almt_tembusan2" class="block text-gray-700 font-medium mb-2">Alamat
                                        Tembusan 3</label>
                                    <textarea
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="almt_tembusan2" name="almt_tembusan2" rows="2" placeholder="Alamat Tembusan">{{ old('almt_tembusan2', $perkara->almt_tembusan2) }}</textarea>
                                </div>

                                <div>
                                    <label for="tembusan3" class="block text-gray-700 font-medium mb-2">Tembusan
                                        4</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tembusan3" name="tembusan3"
                                        value="{{ old('tembusan3', $perkara->tembusan3) }}"
                                        placeholder="Nama Penerima Tembusan">
                                </div>

                                <div>
                                    <label for="almt_tembusan3" class="block text-gray-700 font-medium mb-2">Alamat
                                        Tembusan 4</label>
                                    <textarea
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="almt_tembusan3" name="almt_tembusan3" rows="2" placeholder="Alamat Tembusan">{{ old('almt_tembusan3', $perkara->almt_tembusan3) }}</textarea>
                                </div>

                                <div>
                                    <label for="tembusan4" class="block text-gray-700 font-medium mb-2">Tembusan
                                        5</label>
                                    <input type="text"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="tembusan4" name="tembusan4"
                                        value="{{ old('tembusan4', $perkara->tembusan4) }}"
                                        placeholder="Nama Penerima Tembusan">
                                </div>

                                <div>
                                    <label for="almt_tembusan4" class="block text-gray-700 font-medium mb-2">Alamat
                                        Tembusan 5</label>
                                    <textarea
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent check-filled"
                                        id="almt_tembusan4" name="almt_tembusan4" rows="2" placeholder="Alamat Tembusan">{{ old('almt_tembusan4', $perkara->almt_tembusan4) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col md:flex-row justify-end gap-3 mt-8 pt-5 border-t border-gray-200">
                        <a href="{{ route('perkaras.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-colors">
                            <i class="fas fa-times-circle mr-2"></i> Batal
                        </a>
                        <button type="submit"
                            class="bg-primary hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-colors">
                            <i class="fas fa-check-circle mr-2"></i> Update Perkara
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk mengecek apakah field terisi
            function checkFieldFilled(field) {
                if (field.tagName === 'SELECT') {
                    return field.value !== '';
                } else if (field.type === 'date') {
                    return field.value !== '';
                } else if (field.tagName === 'TEXTAREA') {
                    return field.value.trim() !== '';
                } else {
                    return field.value.trim() !== '';
                }
            }

            // Fungsi untuk mengupdate tampilan field
            function updateFieldAppearance(field) {
                if (checkFieldFilled(field)) {
                    field.classList.add('field-filled');
                    field.classList.remove('field-empty');
                } else {
                    field.classList.add('field-empty');
                    field.classList.remove('field-filled');
                }
            }

            // Inisialisasi tampilan semua field
            const fields = document.querySelectorAll('.check-filled');
            fields.forEach(function(field) {
                updateFieldAppearance(field);

                // Tambahkan event listener untuk perubahan nilai
                field.addEventListener('change', function() {
                    updateFieldAppearance(this);
                });

                field.addEventListener('input', function() {
                    updateFieldAppearance(this);
                });
            });

            // Handle alert dismiss
            const alertDismissButtons = document.querySelectorAll('[aria-label="Close"]');
            alertDismissButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.parentElement.style.display = 'none';
                });
            });

            // Section toggle functionality
            const sectionToggles = document.querySelectorAll('.section-toggle');
            sectionToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('.fa-chevron-down');

                    if (content.classList.contains('expanded')) {
                        content.classList.remove('expanded');
                        content.classList.add('collapsed');
                        icon.classList.add('rotate-180');
                    } else {
                        content.classList.remove('collapsed');
                        content.classList.add('expanded');
                        icon.classList.remove('rotate-180');
                    }
                });
            });
        });
    </script>
</body>

</html>
