<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\EncryptedRow;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;

class LaporanKPIBulanan extends Model implements CipherSweetEncrypted
{
    use HasFactory, SoftDeletes, UsesCipherSweet;

    protected $fillable = [
        "capaian",
        "deskripsi",
        "id_laporan_bulanan",
        "id_kpi"
    ];

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addTextField('capaian')
            ->addTextField('deskripsi');
    }

    public function KPI()
    {
        return $this->belongsTo(KeyPerformanceIndicator::class, 'id_kpi');
    }

    public function laporanBulanan()
    {
        return $this->belongsTo(LaporanBulanan::class, "id_laporan_bulanan");
    }
}
