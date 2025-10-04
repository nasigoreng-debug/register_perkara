<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Menampilkan dashboard dengan statistik perkara
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try {
            // Validasi input tanggal
            $validator = Validator::make($request->all(), [
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Query data dengan filter tanggal
            $perkaras = $this->getFilteredPerkaras($startDate, $endDate);

            // Hitung berbagai statistik
            $kinerjaHakim = $this->calculateHakimPerformance($perkaras);
            $kinerjaPanitera = $this->calculatePaniteraPerformance($perkaras);
            $stats = $this->calculateGeneralStats($perkaras, $kinerjaHakim, $kinerjaPanitera);
            $statsPengiriman = $this->calculateShippingStats($startDate, $endDate);

            return view('dashboard', array_merge($stats, [
                'kinerjaHakim' => $kinerjaHakim,
                'kinerjaPanitera' => $kinerjaPanitera,
                'statsPengiriman' => $statsPengiriman,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Mendapatkan data perkara dengan filter tanggal
     *
     * @param string|null $startDate
     * @param string|null $endDate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getFilteredPerkaras($startDate, $endDate)
    {
        $query = Perkara::query();

        if ($startDate && $endDate) {
            $query->whereBetween('tgl_reg_pta', [$startDate, $endDate]);
        } else {
            // Default: tampilkan data tahun berjalan
            $currentYear = date('Y');
            $query->whereYear('tgl_reg_pta', $currentYear);
        }

        return $query->get();
    }

    /**
     * Menghitung kinerja hakim berdasarkan data perkara
     *
     * @param \Illuminate\Database\Eloquent\Collection $perkaras
     * @return \Illuminate\Support\Collection
     */
    private function calculateHakimPerformance($perkaras)
    {
        return $perkaras->whereNotNull('tgl_reg_pta')
            ->sortByDesc('tgl_reg_pta')
            ->map(function ($perkara) {
                $perkara->lama_hakim = null;

                if ($perkara->tgl_reg_pta && $perkara->tgl_putus) {
                    $perkara->lama_hakim = Carbon::parse($perkara->tgl_reg_pta)
                        ->diffInDays(Carbon::parse($perkara->tgl_putus));
                }

                return $perkara;
            });
    }

    /**
     * Menghitung kinerja panitera berdasarkan data perkara
     *
     * @param \Illuminate\Database\Eloquent\Collection $perkaras
     * @return \Illuminate\Support\Collection
     */
    private function calculatePaniteraPerformance($perkaras)
    {
        return $perkaras->whereNotNull('tgl_minut')
            ->sortByDesc('tgl_minut')
            ->map(function ($perkara) {
                $perkara->lama_panitera = null;

                if ($perkara->tgl_minut && $perkara->tgl_serah) {
                    $perkara->lama_panitera = Carbon::parse($perkara->tgl_minut)
                        ->diffInDays(Carbon::parse($perkara->tgl_serah));
                }

                return $perkara;
            });
    }

    /**
     * Menghitung statistik umum
     *
     * @param \Illuminate\Database\Eloquent\Collection $perkaras
     * @param \Illuminate\Support\Collection $kinerjaHakim
     * @param \Illuminate\Support\Collection $kinerjaPanitera
     * @return array
     */
    private function calculateGeneralStats($perkaras, $kinerjaHakim, $kinerjaPanitera)
    {
        // Statistik dasar
        $totalPerkara = $perkaras->count();
        $perkaraPutus = $perkaras->whereNotNull('tgl_putus')->count();

        // Statistik e-court
        $perkaraECourt = $perkaras->where('keterangan', 'e-court')->count();
        $perkaraNonECourt = $perkaras->where('keterangan', 'non e-court')->count();
        $ecourtPutus = $perkaras->whereNotNull('tgl_putus')
            ->where('keterangan', 'e-court')
            ->count();

        // Rata-rata lama proses
        $avgHakim = $kinerjaHakim->whereNotNull('lama_hakim')->avg('lama_hakim') ?? 0;
        $avgPanitera = $kinerjaPanitera->whereNotNull('lama_panitera')->avg('lama_panitera') ?? 0;

        // Distribusi kinerja hakim
        $statsHakim = [
            'cepat' => $kinerjaHakim->where('lama_hakim', '<=', 30)->count(),
            'sedang' => $kinerjaHakim->whereBetween('lama_hakim', [31, 60])->count(),
            'lambat' => $kinerjaHakim->where('lama_hakim', '>', 60)->count(),
        ];

        // Distribusi kinerja panitera (UPDATE: sesuai regulasi baru)
        $statsPanitera = [
            '1-2' => $kinerjaPanitera->whereBetween('lama_panitera', [1, 2])->count(),
            '3-5' => $kinerjaPanitera->whereBetween('lama_panitera', [3, 5])->count(),
            '6-9' => $kinerjaPanitera->whereBetween('lama_panitera', [6, 9])->count(),
            '10-14' => $kinerjaPanitera->whereBetween('lama_panitera', [10, 14])->count(),
            '>14' => $kinerjaPanitera->where('lama_panitera', '>', 14)->count(),
        ];

        return compact(
            'totalPerkara',
            'perkaraPutus',
            'perkaraECourt',
            'perkaraNonECourt',
            'ecourtPutus',
            'avgHakim',
            'avgPanitera',
            'statsHakim',
            'statsPanitera'
        );
    }

    /**
     * Menghitung statistik pengiriman dengan filter tanggal
     *
     * @param string|null $startDate
     * @param string|null $endDate
     * @return array
     */
    private function calculateShippingStats($startDate, $endDate)
    {
        $query = Perkara::query();

        // Terapkan filter tanggal jika ada
        if ($startDate && $endDate) {
            $query->whereBetween('tgl_reg_pta', [$startDate, $endDate]);
        } else {
            // Default: tampilkan data tahun berjalan
            $currentYear = date('Y');
            $query->whereYear('tgl_reg_pta', $currentYear);
        }

        return [
            '0-30' => (clone $query)->whereBetween(DB::raw('DATEDIFF(tgl_trm_pta, tgl_akta_banding)'), [0, 30])->count(),
            '31-45' => (clone $query)->whereBetween(DB::raw('DATEDIFF(tgl_trm_pta, tgl_akta_banding)'), [31, 45])->count(),
            '46-60' => (clone $query)->whereBetween(DB::raw('DATEDIFF(tgl_trm_pta, tgl_akta_banding)'), [46, 60])->count(),
            '61-90' => (clone $query)->whereBetween(DB::raw('DATEDIFF(tgl_trm_pta, tgl_akta_banding)'), [61, 90])->count(),
            '91-120' => (clone $query)->whereBetween(DB::raw('DATEDIFF(tgl_trm_pta, tgl_akta_banding)'), [91, 120])->count(),
            '121>' => (clone $query)->where(DB::raw('DATEDIFF(tgl_trm_pta, tgl_akta_banding)'), '>', 120)->count(),
        ];
    }
}