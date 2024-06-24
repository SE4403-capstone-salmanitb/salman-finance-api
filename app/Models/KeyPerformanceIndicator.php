<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyPerformanceIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'indikator',
        'target',
        'id_program_kegiatan_kpi'
    ];

    public function programKegiatan()
    {
        return $this->belongsTo(ProgramKegiatanKPI::class, 'id_program_kegiatan_kpi');
    }

    public function KPIBulanan()
    {
        return $this->hasMany(LaporanKPIBulanan::class, "id_laporan_bulanan");
    }

}
