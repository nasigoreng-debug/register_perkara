<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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

        // Hitung statistik perkara
        $stats = $this->calculateStats();
        
        // Tambahkan parameter ke pagination links
        $perkaras->appends([
            'search' => $search,
            'status' => $status,
            'keterangan_filter' => $keteranganFilter,
            'jenis_perkara' => $jenisPerkara,
            'perPage' => $perPage
        ]);

        return view('perkaras.index', array_merge(
            compact(
                'perkaras',
                'search',
                'status',
                'keteranganFilter',
                'jenisPerkara'
            ),
            $stats
        ));
    }

    /**
     * Menghitung statistik perkara
     */
    private function calculateStats()
    {
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

        // Hitung rata-rata perkara per bulan
        $rata_per_bulan = $this->calculateAveragePerMonth($totalPerkara);

        return compact(
            'putus_count',
            'proses_sidang_count',
            'menunggu_sidang_count',
            'proses_awal_count',
            'belum_putus_count',
            'totalPerkara',
            'rata_per_bulan'
        );
    }

    /**
     * Menghitung rata-rata perkara per bulan
     */
    private function calculateAveragePerMonth($totalPerkara)
    {
        if ($totalPerkara <= 0) {
            return 0;
        }

        try {
            $oldestDate = Perkara::whereNotNull('tgl_reg_pta')->min('tgl_reg_pta');
            
            if (!$oldestDate) {
                return 0;
            }

            $startDate = Carbon::parse($oldestDate);
            $endDate = Carbon::now();
            $totalMonths = $startDate->diffInMonths($endDate);
            
            // Pastikan minimal 1 bulan untuk menghindari division by zero
            $totalMonths = max(1, $totalMonths);
            
            // Hitung rata-rata dengan pembulatan 1 digit desimal
            return round($totalPerkara / $totalMonths, 1);
        } catch (\Exception $e) {
            Log::error('Error calculating average per month: ' . $e->getMessage());
            return 0;
        }
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
        // Validasi input
        $validatedData = $this->validatePerkaraData($request);
        
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

        // Validasi input
        $validatedData = $this->validatePerkaraData($request, $perkara->id);

        // Update data
        $perkara->update($validatedData);

        return redirect()->route('perkaras.index')
            ->with('success', 'Perkara berhasil diperbarui.');
    }

    /**
     * Validasi data perkara
     */
    private function validatePerkaraData(Request $request, $id = null)
    {
        $rules = [
            'satker' => 'required|string|max:100',
            'no_reg_pa' => 'required|string|max:255',
            'jenis_perkara' => 'required|string|max:100',
            'keterangan' => 'required|string|max:100',
            'pembanding' => 'nullable|string|max:255',
            'terbanding' => 'nullable|string|max:255',
            'tgl_put_pa' => 'nullable|date',
            'tgl_akta_banding' => 'nullable|date',
            'no_srt_pa' => 'nullable|string|max:100',
            'tgl_srt_pa' => 'nullable|date',
            'tgl_trm_pta' => 'nullable|date',
            'tgl_reg_pta' => 'nullable|date',
            'tgl_pmh' => 'nullable|date',
            'tgl_ppp' => 'nullable|date',
            'tgl_trm_km' => 'nullable|date',
            'tgl_phs' => 'nullable|date',
            'tgl_sidang' => 'nullable|date',
            'tgl_sela' => 'nullable|date',
            'tgl_putus' => 'nullable|date',
            'status_put' => 'nullable|string|max:100',
            'tgl_minut' => 'nullable|date',
            'tgl_serah' => 'nullable|date',
            'tgl_srt_pta' => 'nullable|date',
            'tgl_kirim_pta' => 'nullable|date',
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
        ];

        // Aturan unik untuk no_reg_pta
        if ($id) {
            $rules['no_reg_pta'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('perkara', 'no_reg_pta')->ignore($id)
            ];
        } else {
            $rules['no_reg_pta'] = 'required|string|max:255|unique:perkara,no_reg_pta';
        }

        return $request->validate($rules);
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