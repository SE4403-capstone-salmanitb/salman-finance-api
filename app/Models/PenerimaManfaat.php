<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaManfaat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kategori',
        'tipe_rutinitas',
        'tipe_penyaluran',
        'rencana',
        'realisasi',
        'id_laporan_bulanan',
    ];

    protected function casts()
    {
        return [
            'kategori'=> 'encrypted',
            'tipe_rutinitas'=> 'encrypted',
            'tipe_penyaluran'=> 'encrypted',
            'rencana'=> 'encrypted',
            'realisasi'=> 'encrypted',
        ];
    }

    /**
     * Get the laporan_bulanan that owns the PenerimaManfaat.
     */
    public function laporanBulanan()
    {
        return $this->belongsTo(LaporanBulanan::class, 'id_laporan_bulanan');
    }
}
