<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlokasiDana extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_laporan_bulanan',
        'id_item_rka',
        'jumlah_realisasi'
    ];

    /**
     * Get the laporan_bulanan that owns this thing.
     */
    public function laporanBulanan()
    {
        return $this->belongsTo(LaporanBulanan::class, 'id_laporan_bulanan');
    }

    public function ItemKegiatanRKA()
    {
        return $this->belongsTo(ItemKegiatanRKA::class, 'id_item_rka');
    }
}
