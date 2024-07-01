<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dana extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_pengeluaran',
        'jumlah',
        'ras',
        'kepesertaan',
        'dpk',
        'pusat',
        'wakaf',
        'id_laporan_bulanan'
    ];

    public function laporanBulanan()
    {
        $this->belongsTo(LaporanBulanan::class, 'id_laporan_bulanan');
    }
}
