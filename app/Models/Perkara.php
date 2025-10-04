<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Perkara extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'perkara'; // Pastikan ini 'perkara' bukan 'perkaras'

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'satker',
        'no_reg_pa',
        'jenis_perkara',
        'no_reg_pta',
        'keterangan',
        'pembanding',
        'terbanding',
        'tgl_put_pa',
        'tgl_akta_banding', // Pastikan ejaan benar
        'no_srt_pa',
        'tgl_srt_pa',
        'tgl_trm_pta',
        'tgl_reg_pta',
        'tgl_pmh',
        'tgl_ppp',
        'tgl_trm_km',
        'tgl_serah',
        'tgl_phs',
        'tgl_sidang',
        'tgl_sela',
        'tgl_putus',
        'status_put',
        'tgl_minut',
        'tgl_srt_pta',
        'tgl_kirim_pta',
        'hakim_ketua',
        'hakim_anggota1',
        'hakim_anggota2',
        'panitera_pengganti',
        'alamat_pa',
        'tembusan',
        'tembusan1',
        'tembusan2',
        'tembusan3',
        'tembusan4',
        'almt_tembusan',
        'almt_tembusan1',
        'almt_tembusan2',
        'almt_tembusan3'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tgl_put_pa' => 'datetime:Y-m-d',
        'tgl_akta_banding' => 'datetime:Y-m-d',
        'tgl_srt_pa' => 'datetime:Y-m-d',
        'tgl_trm_pta' => 'datetime:Y-m-d',
        'tgl_reg_pta' => 'datetime:Y-m-d',
        'tgl_pmh' => 'datetime:Y-m-d',
        'tgl_ppp' => 'datetime:Y-m-d',
        'tgl_trm_km' => 'datetime:Y-m-d',
        'tgl_serah' => 'datetime:Y-m-d',
        'tgl_phs' => 'datetime:Y-m-d',
        'tgl_sidang' => 'datetime:Y-m-d',
        'tgl_sela' => 'datetime:Y-m-d',
        'tgl_putus' => 'datetime:Y-m-d',
        'tgl_minut' => 'datetime:Y-m-d',
        'tgl_srt_pta' => 'datetime:Y-m-d',
        'tgl_kirim_pta' => 'datetime:Y-m-d',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function scopeStatus($query, $status)
{
    switch ($status) {
        case 'putus':
            return $query->whereNotNull('tgl_putus');
        case 'proses_sidang':
            return $query->whereNull('tgl_putus')->whereNotNull('tgl_sidang');
        case 'menunggu_sidang':
            return $query->whereNull('tgl_putus')
                        ->whereNull('tgl_sidang')
                        ->whereNotNull('tgl_phs');
        case 'proses_awal':
            return $query->whereNull('tgl_putus')
                        ->whereNull('tgl_sidang')
                        ->whereNull('tgl_phs');
        case 'belum_putus':
            return $query->whereNull('tgl_putus');
        default:
            return $query;
    }
}
}