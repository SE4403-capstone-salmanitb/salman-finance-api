<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelaksanaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "penjelasan",
        "waktu",
        "tempat",
        "penyaluran",
        "id_program_kegiatan_kpi",
        "id_laporan_bulanan"
    ];

    public function programKegiatan()
    {
        return $this->belongsTo(ProgramKegiatanKPI::class, 'id_program_kegiatan_kpi');
    }

    public function laporanBulanan()
    {
        return $this->belongsTo(LaporanBulanan::class, "id_laporan_bulanan");
    }
}
