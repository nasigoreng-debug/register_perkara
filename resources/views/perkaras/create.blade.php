<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Perkara Baru</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0d6efd',
                        filled: '#dcfce7',    // Warna hijau muda untuk field terisi
                        'filled-border': '#22c55e', // Warna hijau untuk border field terisi
                        empty: '#fee2e2',     // Warna merah muda untuk field kosong
                        'empty-border': '#ef4444'   // Warna merah untuk border field kosong
                    }
                }
            }
        }
    </script>
    <style>
        .form-field {
            transition: all 0.3s ease;
        }
        .filled {
            background-color: #dcfce7;
            border-color: #22c55e;
        }
        .empty {
            background-color: #fee2e2;
            border-color: #ef4444;
        }
        .section-title {
            position: relative;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: #0d6efd;
            border-radius: 3px;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-center">
            <div class="w-full max-w-6xl">
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                    <div class="bg-primary text-white p-5">
                        <h4 class="text-2xl font-bold mb-0 flex items-center">
                            <i class="fas fa-plus-circle mr-3"></i> Tambah Perkara Baru
                        </h4>
                    </div>

                    <div class="p-6">
                        @if($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                            <p class="font-bold mb-2"><i class="fas fa-exclamation-circle mr-2"></i> Terdapat kesalahan dalam pengisian form:</p>
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('perkaras.store') }}" method="POST" id="perkaraForm">
                            @csrf

                            <!-- Informasi Dasar Perkara -->
                            <div class="bg-gray-50 rounded-lg p-6 mb-6 border border-gray-200">
                                <h5 class="text-primary mb-5 text-xl font-semibold section-title pb-2">
                                    <i class="fas fa-info-circle mr-2"></i> Informasi Perkara
                                </h5>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                                    <div class="mb-5">
                                        <label for="satker" class="block text-sm font-medium text-gray-700 mb-2 after:content-['_*'] after:text-red-500">Satker</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('satker') border-red-500 @enderror" 
                                               id="satker" name="satker" value="{{ old('satker') }}" required maxlength="100">
                                        @error('satker')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="no_reg_pa" class="block text-sm font-medium text-gray-700 mb-2 after:content-['_*'] after:text-red-500">No. Putusan PA</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('no_reg_pa') border-red-500 @enderror" 
                                               id="no_reg_pa" name="no_reg_pa" value="{{ old('no_reg_pa') }}" required maxlength="255">
                                        @error('no_reg_pa')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tgl_put_pa" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Putusan PA</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_put_pa') border-red-500 @enderror" 
                                               id="tgl_put_pa" name="tgl_put_pa" value="{{ old('tgl_put_pa') }}">
                                        @error('tgl_put_pa')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tgl_akta_banding" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akta Banding</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_akta_banding') border-red-500 @enderror" 
                                               id="tgl_akta_banding" name="tgl_akta_banding" value="{{ old('tgl_akta_banding') }}">
                                        @error('tgl_akta_banding')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="no_srt_pa" class="block text-sm font-medium text-gray-700 mb-2">No. Surat PA</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('no_srt_pa') border-red-500 @enderror" 
                                               id="no_srt_pa" name="no_srt_pa" value="{{ old('no_srt_pa') }}" maxlength="100">
                                        @error('no_srt_pa')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tgl_srt_pa" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Surat PA</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_srt_pa') border-red-500 @enderror" 
                                               id="tgl_srt_pa" name="tgl_srt_pa" value="{{ old('tgl_srt_pa') }}">
                                        @error('tgl_srt_pa')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="jenis_perkara" class="block text-sm font-medium text-gray-700 mb-2 after:content-['_*'] after:text-red-500">Jenis Perkara</label>
                                        <select class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('jenis_perkara') border-red-500 @enderror" 
                                                id="jenis_perkara" name="jenis_perkara" required>
                                            <option value="">Pilih Jenis Perkara</option>
                                            <option value="Asal Usul Anak" {{ old('jenis_perkara') == 'Asal Usul Anak' ? 'selected' : '' }}>Asal Usul Anak</option>
                                            <option value="Cerai Gugat" {{ old('jenis_perkara') == 'Cerai Gugat' ? 'selected' : '' }}>Cerai Gugat</option>
                                            <option value="Cerai Talak" {{ old('jenis_perkara') == 'Cerai Talak' ? 'selected' : '' }}>Cerai Talak</option>
                                            <option value="Dispensasi Kawin" {{ old('jenis_perkara') == 'Dispensasi Kawin' ? 'selected' : '' }}>Dispensasi Kawin</option>
                                            <option value="Ekonomi Syariah" {{ old('jenis_perkara') == 'Ekonomi Syariah' ? 'selected' : '' }}>Ekonomi Syariah</option>
                                            <option value="Harta Bersama" {{ old('jenis_perkara') == 'Harta Bersama' ? 'selected' : '' }}>Harta Bersama</option>
                                            <option value="Hibah" {{ old('jenis_perkara') == 'Hibah' ? 'selected' : '' }}>Hibah</option>
                                            <option value="Isbath Nikah" {{ old('jenis_perkara') == 'Isbath Nikah' ? 'selected' : '' }}>Isbath Nikah</option>
                                            <option value="Izin Poligami" {{ old('jenis_perkara') == 'Izin Poligami' ? 'selected' : '' }}>Izin Poligami</option>
                                            <option value="Kewarisan" {{ old('jenis_perkara') == 'Kewarisan' ? 'selected' : '' }}>Kewarisan</option>
                                            <option value="P3HP/Penetapan Ahli Waris" {{ old('jenis_perkara') == 'P3HP/Penetapan Ahli Waris' ? 'selected' : '' }}>P3HP/Penetapan Ahli Waris</option>
                                            <option value="Pembatalan Perkawinan" {{ old('jenis_perkara') == 'Pembatalan Perkawinan' ? 'selected' : '' }}>Pembatalan Perkawinan</option>
                                            <option value="Pengesahan Anak/Pengangkatan Anak" {{ old('jenis_perkara') == 'Pengesahan Anak/Pengangkatan Anak' ? 'selected' : '' }}>Pengesahan Anak/Pengangkatan Anak</option>
                                            <option value="Perwalian" {{ old('jenis_perkara') == 'Perwalian' ? 'selected' : '' }}>Perwalian</option>
                                            <option value="Wakaf" {{ old('jenis_perkara') == 'Wakaf' ? 'selected' : '' }}>Wakaf</option>
                                            <option value="Wasiat" {{ old('jenis_perkara') == 'Wasiat' ? 'selected' : '' }}>Wasiat</option>
                                            <option value="Zakat/Infaq/Shodaqoh" {{ old('jenis_perkara') == 'Zakat/Infaq/Shodaqoh' ? 'selected' : '' }}>Zakat/Infaq/Shodaqoh</option>
                                            <option value="Lain-lain" {{ old('jenis_perkara') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                        </select>
                                        @error('jenis_perkara')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2 after:content-['_*'] after:text-red-500">Keterangan</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('keterangan') border-red-500 @enderror" 
                                               id="keterangan" name="keterangan" value="{{ old('keterangan') }}" required maxlength="100">
                                        @error('keterangan')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="pembanding" class="block text-sm font-medium text-gray-700 mb-2">Pembanding</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('pembanding') border-red-500 @enderror" 
                                               id="pembanding" name="pembanding" value="{{ old('pembanding') }}" maxlength="255">
                                        @error('pembanding')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="terbanding" class="block text-sm font-medium text-gray-700 mb-2">Terbanding</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('terbanding') border-red-500 @enderror" 
                                               id="terbanding" name="terbanding" value="{{ old('terbanding') }}" maxlength="255">
                                        @error('terbanding')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Penerimaan & Registrasi di PTA -->
                            <div class="bg-gray-50 rounded-lg p-6 mb-6 border border-gray-200">
                                <h5 class="text-primary mb-5 text-xl font-semibold section-title pb-2">
                                    <i class="fas fa-calendar-alt mr-2"></i> Penerimaan & Registrasi di PTA
                                </h5>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                                    <div class="mb-5">
                                        <label for="tgl_trm_pta" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Terima PTA</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_trm_pta') border-red-500 @enderror" 
                                               id="tgl_trm_pta" name="tgl_trm_pta" value="{{ old('tgl_trm_pta') }}">
                                        @error('tgl_trm_pta')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="no_reg_pta" class="block text-sm font-medium text-gray-700 mb-2 after:content-['_*'] after:text-red-500">No. Registrasi PTA</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('no_reg_pta') border-red-500 @enderror" 
                                               id="no_reg_pta" name="no_reg_pta" value="{{ old('no_reg_pta') }}" required maxlength="255">
                                        @error('no_reg_pta')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tgl_reg_pta" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Registrasi PTA</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_reg_pta') border-red-500 @enderror" 
                                               id="tgl_reg_pta" name="tgl_reg_pta" value="{{ old('tgl_reg_pta') }}">
                                        @error('tgl_reg_pta')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Hakim dan Panitera -->
                            <div class="bg-gray-50 rounded-lg p-6 mb-6 border border-gray-200">
                                <h5 class="text-primary mb-5 text-xl font-semibold section-title pb-2">
                                    <i class="fas fa-gavel mr-2"></i> Hakim dan Panitera Pengganti
                                </h5>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                                    <div class="mb-5">
                                        <label for="tgl_pmh" class="block text-sm font-medium text-gray-700 mb-2">Tanggal PMH</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_pmh') border-red-500 @enderror" 
                                               id="tgl_pmh" name="tgl_pmh" value="{{ old('tgl_pmh') }}">
                                        @error('tgl_pmh')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="hakim_ketua" class="block text-sm font-medium text-gray-700 mb-2">Hakim Ketua</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('hakim_ketua') border-red-500 @enderror" 
                                               id="hakim_ketua" name="hakim_ketua" value="{{ old('hakim_ketua') }}" maxlength="255">
                                        @error('hakim_ketua')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="hakim_anggota1" class="block text-sm font-medium text-gray-700 mb-2">Hakim Anggota 1</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('hakim_anggota1') border-red-500 @enderror" 
                                               id="hakim_anggota1" name="hakim_anggota1" value="{{ old('hakim_anggota1') }}" maxlength="255">
                                        @error('hakim_anggota1')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="hakim_anggota2" class="block text-sm font-medium text-gray-700 mb-2">Hakim Anggota 2</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('hakim_anggota2') border-red-500 @enderror" 
                                               id="hakim_anggota2" name="hakim_anggota2" value="{{ old('hakim_anggota2') }}" maxlength="255">
                                        @error('hakim_anggota2')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tgl_ppp" class="block text-sm font-medium text-gray-700 mb-2">Tanggal PPP</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_ppp') border-red-500 @enderror" 
                                               id="tgl_ppp" name="tgl_ppp" value="{{ old('tgl_ppp') }}">
                                        @error('tgl_ppp')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="panitera_pengganti" class="block text-sm font-medium text-gray-700 mb-2">Panitera Pengganti</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('panitera_pengganti') border-red-500 @enderror" 
                                               id="panitera_pengganti" name="panitera_pengganti" value="{{ old('panitera_pengganti') }}" maxlength="255">
                                        @error('panitera_pengganti')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Prose Sidang -->
                            <div class="bg-gray-50 rounded-lg p-6 mb-6 border border-gray-200">
                                <h5 class="text-primary mb-5 text-xl font-semibold section-title pb-2">
                                    <i class="fas fa-calendar-alt mr-2"></i> Proses Sidang
                                </h5>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                                    <div class="mb-5">
                                        <label for="tgl_trm_km" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Terima KM</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_trm_km') border-red-500 @enderror" 
                                               id="tgl_trm_km" name="tgl_trm_km" value="{{ old('tgl_trm_km') }}">
                                        @error('tgl_trm_km')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tgl_phs" class="block text-sm font-medium text-gray-700 mb-2">Tanggal PHS</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_phs') border-red-500 @enderror" 
                                               id="tgl_phs" name="tgl_phs" value="{{ old('tgl_phs') }}">
                                        @error('tgl_phs')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tgl_sidang" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sidang</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_sidang') border-red-500 @enderror" 
                                               id="tgl_sidang" name="tgl_sidang" value="{{ old('tgl_sidang') }}">
                                        @error('tgl_sidang')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tgl_sela" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sela</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_sela') border-red-500 @enderror" 
                                               id="tgl_sela" name="tgl_sela" value="{{ old('tgl_sela') }}">
                                        @error('tgl_sela')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tgl_putus" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Putus</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_putus') border-red-500 @enderror" 
                                               id="tgl_putus" name="tgl_putus" value="{{ old('tgl_putus') }}">
                                        @error('tgl_putus')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-5">
                                        <label for="status_put" class="block text-sm font-medium text-gray-700 mb-2">Status Putusan</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('status_put') border-red-500 @enderror" 
                                               id="status_put" name="status_put" value="{{ old('status_put') }}" maxlength="100">
                                        @error('status_put')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Administrasi Pasca Putusan -->
                            <div class="bg-gray-50 rounded-lg p-6 mb-6 border border-gray-200">
                                <h5 class="text-primary mb-5 text-xl font-semibold section-title pb-2">
                                    <i class="fas fa-file-alt mr-2"></i> Administrasi Pasca Putusan
                                </h5>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                                    <div class="mb-5">
                                        <label for="tgl_minut" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Minut</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_minut') border-red-500 @enderror" 
                                               id="tgl_minut" name="tgl_minut" value="{{ old('tgl_minut') }}">
                                        @error('tgl_minut')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tgl_serah" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Serah</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_serah') border-red-500 @enderror" 
                                               id="tgl_serah" name="tgl_serah" value="{{ old('tgl_serah') }}">
                                        @error('tgl_serah')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tgl_srt_pta" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Surat PTA</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_srt_pta') border-red-500 @enderror" 
                                               id="tgl_srt_pta" name="tgl_srt_pta" value="{{ old('tgl_srt_pta') }}">
                                        @error('tgl_srt_pta')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tgl_kirim_pta" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kirim PTA</label>
                                        <input type="date" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tgl_kirim_pta') border-red-500 @enderror" 
                                               id="tgl_kirim_pta" name="tgl_kirim_pta" value="{{ old('tgl_kirim_pta') }}">
                                        @error('tgl_kirim_pta')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Alamat -->
                            <div class="bg-gray-50 rounded-lg p-6 mb-6 border border-gray-200">
                                <h5 class="text-primary mb-5 text-xl font-semibold section-title pb-2">
                                    <i class="fas fa-envelope mr-2"></i> Alamat dan tembusan
                                </h5>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="mb-5 md:col-span-2">
                                        <label for="alamat_pa" class="block text-sm font-medium text-gray-700 mb-2">Alamat PA</label>
                                        <textarea class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('alamat_pa') border-red-500 @enderror" 
                                                  id="alamat_pa" name="alamat_pa" rows="2" maxlength="500">{{ old('alamat_pa') }}</textarea>
                                        @error('alamat_pa')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-5">
                                        <label for="tembusan" class="block text-sm font-medium text-gray-700 mb-2">Tembusan 1</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tembusan') border-red-500 @enderror" 
                                               id="tembusan" name="tembusan" value="{{ old('tembusan') }}" maxlength="255">
                                        @error('tembusan')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="almt_tembusan" class="block text-sm font-medium text-gray-700 mb-2">Alamat Tembusan 1</label>
                                        <textarea class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('almt_tembusan') border-red-500 @enderror" 
                                                  id="almt_tembusan" name="almt_tembusan" rows="2" maxlength="500">{{ old('almt_tembusan') }}</textarea>
                                        @error('almt_tembusan')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tembusan1" class="block text-sm font-medium text-gray-700 mb-2">Tembusan 2</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tembusan1') border-red-500 @enderror" 
                                               id="tembusan1" name="tembusan1" value="{{ old('tembusan1') }}" maxlength="255">
                                        @error('tembusan1')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="almt_tembusan1" class="block text-sm font-medium text-gray-700 mb-2">Alamat Tembusan 2</label>
                                        <textarea class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('almt_tembusan1') border-red-500 @enderror" 
                                                  id="almt_tembusan1" name="almt_tembusan1" rows="2" maxlength="500">{{ old('almt_tembusan1') }}</textarea>
                                        @error('almt_tembusan1')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tembusan2" class="block text-sm font-medium text-gray-700 mb-2">Tembusan 3</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tembusan2') border-red-500 @enderror" 
                                               id="tembusan2" name="tembusan2" value="{{ old('tembusan2') }}" maxlength="255">
                                        @error('tembusan2')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="almt_tembusan2" class="block text-sm font-medium text-gray-700 mb-2">Alamat Tembusan 3</label>
                                        <textarea class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('almt_tembusan2') border-red-500 @enderror" 
                                                  id="almt_tembusan2" name="almt_tembusan2" rows="2" maxlength="500">{{ old('almt_tembusan2') }}</textarea>
                                        @error('almt_tembusan2')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="tembusan3" class="block text-sm font-medium text-gray-700 mb-2">Tembusan 4</label>
                                        <input type="text" class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('tembusan3') border-red-500 @enderror" 
                                               id="tembusan3" name="tembusan3" value="{{ old('tembusan3') }}" maxlength="255">
                                        @error('tembusan3')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="almt_tembusan3" class="block text-sm font-medium text-gray-700 mb-2">Alamat Tembusan 4</label>
                                        <textarea class="w-full px-4 py-2.5 border-2 rounded-lg form-field @error('almt_tembusan3') border-red-500 @enderror" 
                                                  id="almt_tembusan3" name="almt_tembusan3" rows="2" maxlength="500">{{ old('almt_tembusan3') }}</textarea>
                                        @error('almt_tembusan3')
                                            <p class="text-red-500 text-xs mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="flex flex-wrap gap-3">
                                    <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-lg flex items-center transition-colors duration-300 shadow-md">
                                        <i class="fas fa-save mr-2"></i> Simpan Perkara
                                    </button>
                                    <a href="{{ route('perkaras.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2.5 px-5 rounded-lg flex items-center transition-colors duration-300 shadow-md">
                                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set max date untuk semua input date ke hari ini
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            const dateInputs = document.querySelectorAll('input[type="date"]');
            
            dateInputs.forEach(input => {
                input.setAttribute('max', today);
            });

            // Fungsi untuk mengecek dan mengupdate status field
            function updateFieldStatus() {
                const allInputs = document.querySelectorAll('input, textarea, select');
                
                allInputs.forEach(input => {
                    // Skip tombol submit dan field dengan tipe tertentu
                    if (input.type === 'submit' || input.type === 'button') return;
                    
                    // Cek apakah field memiliki nilai
                    let hasValue = false;
                    
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        hasValue = input.checked;
                    } else if (input.tagName === 'SELECT') {
                        hasValue = input.value !== '';
                    } else {
                        hasValue = input.value.trim() !== '';
                    }
                    
                    // Update kelas berdasarkan status
                    if (hasValue) {
                        input.classList.add('filled');
                        input.classList.remove('empty');
                    } else {
                        input.classList.add('empty');
                        input.classList.remove('filled');
                    }
                });
            }

            // Jalankan saat halaman dimuat
            updateFieldStatus();

            // Tambahkan event listener untuk semua input
            const form = document.getElementById('perkaraForm');
            form.addEventListener('input', updateFieldStatus);
            form.addEventListener('change', updateFieldStatus);
            
            // Juga panggil saat form dimuat untuk field yang sudah memiliki nilai dari old()
            setTimeout(updateFieldStatus, 100);
        });
    </script>
</body>
</html>