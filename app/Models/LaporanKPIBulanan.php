<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKPIBulanan extends Model
{
    use HasFactory;

    protected $fillable = [
        "capaian",
        "deskripsi",
        "id_laporan_bulanan",
        "id_kpi"
    ];

    public function KPI()
    {
        return $this->belongsTo(KeyPerformanceIndicator::class, 'id_kpi');
    }

    public function laporanBulanan()
    {
        return $this->belongsTo(LaporanBulanan::class, "id_laporan_bulanan");
    }
}
