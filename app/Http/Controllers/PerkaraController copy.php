<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerkaraController extends Controller
{
    /**
     * Constructor untuk menerapkan middleware auth
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan daftar perkara dengan filter dan pencarian
     */
    public function index(Request $request)
    {
        // Ambil parameter dari request
        $perPage = $request->get('perPage', 10);
        $search = $request->get('search');
        $status = $request->get('status');
        $keteranganFilter = $request->get('keterangan_filter');
        $jenisPerkara = $request->get('jenis_perkara');

        // Query dasar
        $query = Perkara::orderBy('tgl_reg_pta', 'desc');

        // Filter pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_reg_pta', 'like', '%' . $search . '%')
                    ->orWhere('no_put_pa', 'like', '%' . $search . '%')
                    ->orWhere('satker', 'like', '%' . $search . '%')
                    ->orWhere('pembanding', 'like', '%' . $search . '%')
                    ->orWhere('terbanding', 'like', '%' . $search . '%')
                    ->orWhere('keterangan', 'like', '%' . $search . '%')
                    ->orWhere('no_srt_pa', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan status menggunakan scope
        if ($status) {
            $query->status($status);
        }

        // Filter berdasarkan keterangan
        if ($keteranganFilter) {
            $query->where('keterangan', $keteranganFilter);
        }

        // Filter berdasarkan jenis perkara
        if ($jenisPerkara) {
            $query->where('jenis_perkara', $jenisPerkara);
        }

        // Pagination
        $perkaras = $query->paginate($perPage);

        // Hitung statistik perkara dengan single query (lebih efisien)
        $stats = Perkara::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN tgl_putus IS NOT NULL THEN 1 ELSE 0 END) as putus_count,
            SUM(CASE WHEN tgl_putus IS NULL AND tgl_sidang IS NOT NULL THEN 1 ELSE 0 END) as proses_sidang_count,
            SUM(CASE WHEN tgl_putus IS NULL AND tgl_sidang IS NULL AND tgl_phs IS NOT NULL THEN 1 ELSE 0 END) as menunggu_sidang_count,
            SUM(CASE WHEN tgl_putus IS NULL AND tgl_sidang IS NULL AND tgl_phs IS NULL THEN 1 ELSE 0 END) as proses_awal_count,
            SUM(CASE WHEN tgl_putus IS NULL THEN 1 ELSE 0 END) as belum_putus_count
        ')->first();

        $putus_count = $stats->putus_count ?? 0;
        $proses_sidang_count = $stats->proses_sidang_count ?? 0;
        $menunggu_sidang_count = $stats->menunggu_sidang_count ?? 0;
        $proses_awal_count = $stats->proses_awal_count ?? 0;
        $belum_putus_count = $stats->belum_putus_count ?? 0;
        $totalPerkara = $stats->total ?? 0;

        // Hitung rata-rata perkara per bulan dengan handling division by zero
        $oldestDate = Perkara::whereNotNull('tgl_reg_pta')->min('tgl_reg_pta');
        $rata_per_bulan = 0;

        try {
            if ($oldestDate && $totalPerkara > 0) {
                $startDate = Carbon::parse($oldestDate);
                $endDate = Carbon::now();
                $totalMonths = $startDate->diffInMonths($endDate);
                
                // Pastikan minimal 1 bulan untuk menghindari division by zero
                $totalMonths = max(1, $totalMonths);
                
                // Hitung rata-rata dengan pembulatan 1 digit desimal
                $rata_per_bulan = round($totalPerkara / $totalMonths, 1);
            }
        } catch (\Exception $e) {
            Log::error('Error calculating average per month: ' . $e->getMessage());
            $rata_per_bulan = 0;
        }

        // Tambahkan parameter ke pagination links
        $perkaras->appends([
            'search' => $search,
            'status' => $status,
            'keterangan_filter' => $keteranganFilter,
            'jenis_perkara' => $jenisPerkara,
            'perPage' => $perPage
        ]);

        return view('perkaras.index', compact(
            'perkaras',
            'search',
            'status',
            'keteranganFilter',
            'jenisPerkara',
            'putus_count',
            'proses_sidang_count',
            'menunggu_sidang_count',
            'proses_awal_count',
            'belum_putus_count',
            'rata_per_bulan'
        ));
    }

    /**
     * Menampilkan form untuk membuat perkara baru
     */
    public function create()
    {
        return view('perkaras.create');
    }

    /**
     * Menyimpan perkara baru ke database
     */
    public function store(Request $request)
    {
        $today = now()->toDateString();

        // Validasi input
        $validatedData = $request->validate([
            'satker' => 'required|string|max:100',
            'no_reg_pa' => 'required|string|max:255',
            'jenis_perkara' => 'required|string|max:100',
            'no_reg_pta' => 'required|string|max:255|unique:perkara,no_reg_pta',
            'keterangan' => 'required|string|max:100',
            'pembanding' => 'nullable|string|max:255',
            'terbanding' => 'nullable|string|max:255',
            'tgl_put_pa' => 'nullable|date|before_or_equal:' . $today,
            'tgl_akta_banding' => 'nullable|date|before_or_equal:' . $today,
            'no_srt_pa' => 'nullable|string|max:100',
            'tgl_srt_pa' => 'nullable|date|before_or_equal:' . $today,
            'tgl_trm_pta' => 'nullable|date|before_or_equal:' . $today,
            'tgl_reg_pta' => 'nullable|date|before_or_equal:' . $today,
            'tgl_pmh' => 'nullable|date|before_or_equal:' . $today,
            'tgl_ppp' => 'nullable|date|before_or_equal:' . $today,
            'tgl_trm_km' => 'nullable|date|before_or_equal:' . $today,
            'tgl_phs' => 'nullable|date|before_or_equal:' . $today,
            'tgl_sidang' => 'nullable|date|before_or_equal:' . $today,
            'tgl_sela' => 'nullable|date|before_or_equal:' . $today,
            'tgl_putus' => 'nullable|date|before_or_equal:' . $today,
            'status_put' => 'nullable|string|max:100',
            'tgl_minut' => 'nullable|date|before_or_equal:' . $today,
            'tgl_serah' => 'nullable|date|before_or_equal:' . $today,
            'tgl_srt_pta' => 'nullable|date|before_or_equal:' . $today,
            'tgl_kirim_pta' => 'nullable|date|before_or_equal:' . $today,
            'hakim_ketua' => 'nullable|string|max:255',
            'hakim_anggota1' => 'nullable|string|max:255',
            'hakim_anggota2' => 'nullable|string|max:255',
            'panitera_pengganti' => 'nullable|string|max:255',
            'alamat_pa' => 'nullable|string|max:500',
            'tembusan' => 'nullable|string|max:255',
            'tembusan1' => 'nullable|string|max:255',
            'tembusan2' => 'nullable|string|max:255',
            'tembusan3' => 'nullable|string|max:255',
            'almt_tembusan' => 'nullable|string|max:500',
            'almt_tembusan1' => 'nullable|string|max:500',
            'almt_tembusan2' => 'nullable|string|max:500',
            'almt_tembusan3' => 'nullable|string|max:500',
        ]);

        // Simpan data
        Perkara::create($validatedData);

        return redirect()->route('perkaras.index')
            ->with('success', 'Perkara berhasil dibuat.');
    }

    /**
     * Menampilkan detail perkara
     */
    public function show($id)
    {
        $perkara = Perkara::findOrFail($id);
        return view('perkaras.show', compact('perkara'));
    }

    /**
     * Menampilkan form untuk mengedit perkara
     */
    public function edit($id)
    {
        $perkara = Perkara::findOrFail($id);
        return view('perkaras.edit', compact('perkara'));
    }

    /**
     * Memperbarui data perkara
     */
    public function update(Request $request, $id)
    {
        $perkara = Perkara::findOrFail($id);
        $today = now()->toDateString();

        // Validasi input
        $validatedData = $request->validate([
            'satker' => 'nullable|string|max:100',
            'no_reg_pa' => 'nullable|string|max:255',
            'jenis_perkara' => 'nullable|string|max:100',
            'no_reg_pta' => 'nullable|string|max:255|unique:perkara,no_reg_pta,' . $id,
            'keterangan' => 'required|string|max:100',
            'pembanding' => 'nullable|string|max:255',
            'terbanding' => 'nullable|string|max:255',
            'tgl_put_pa' => 'nullable|date|before_or_equal:' . $today,
            'tgl_akta_banding' => 'nullable|date|before_or_equal:' . $today,
            'no_srt_pa' => 'nullable|string|max:100',
            'tgl_srt_pa' => 'nullable|date|before_or_equal:' . $today,
            'tgl_trm_pta' => 'nullable|date|before_or_equal:' . $today,
            'tgl_reg_pta' => 'nullable|date|before_or_equal:' . $today,
            'tgl_pmh' => 'nullable|date|before_or_equal:' . $today,
            'tgl_ppp' => 'nullable|date|before_or_equal:' . $today,
            'tgl_trm_km' => 'nullable|date|before_or_equal:' . $today,
            'tgl_phs' => 'nullable|date|before_or_equal:' . $today,
            'tgl_sidang' => 'nullable|date|before_or_equal:' . $today,
            'tgl_sela' => 'nullable|date|before_or_equal:' . $today,
            'tgl_putus' => 'nullable|date|before_or_equal:' . $today,
            'status_put' => 'nullable|string|max:100',
            'tgl_minut' => 'nullable|date|before_or_equal:' . $today,
            'tgl_serah' => 'nullable|date|before_or_equal:' . $today,
            'tgl_srt_pta' => 'nullable|date|before_or_equal:' . $today,
            'tgl_kirim_pta' => 'nullable|date|before_or_equal:' . $today,
            'hakim_ketua' => 'nullable|string|max:255',
            'hakim_anggota1' => 'nullable|string|max:255',
            'hakim_anggota2' => 'nullable|string|max:255',
            'panitera_pengganti' => 'nullable|string|max:255',
            'alamat_pa' => 'nullable|string|max:500',
            'tembusan' => 'nullable|string|max:255',
            'tembusan1' => 'nullable|string|max:255',
            'tembusan2' => 'nullable|string|max:255',
            'tembusan3' => 'nullable|string|max:255',
            'almt_tembusan' => 'nullable|string|max:500',
            'almt_tembusan1' => 'nullable|string|max:500',
            'almt_tembusan2' => 'nullable|string|max:500',
            'almt_tembusan3' => 'nullable|string|max:500',
        ]);

        // Update data
        $perkara->update($validatedData);

        return redirect()->route('perkaras.index')
            ->with('success', 'Perkara berhasil diperbarui.');
    }

    /**
     * Menghapus perkara
     */
    public function destroy($id)
    {
        $perkara = Perkara::findOrFail($id);
        $perkara->delete();

        return redirect()->route('perkaras.index')
            ->with('success', 'Perkara berhasil dihapus.');
    }
}