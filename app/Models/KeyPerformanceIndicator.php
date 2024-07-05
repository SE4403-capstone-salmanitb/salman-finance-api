<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\EncryptedRow;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;

class KeyPerformanceIndicator extends Model implements CipherSweetEncrypted
{
    use HasFactory, UsesCipherSweet;

    protected $fillable = [
        'indikator',
        'target',
        'id_program_kegiatan_kpi'
    ];

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addField('indikator')
            ->addField('target');
    }

    public function programKegiatan()
    {
        return $this->belongsTo(ProgramKegiatanKPI::class, 'id_program_kegiatan_kpi');
    }

    public function KPIBulanan()
    {
        return $this->hasMany(LaporanKPIBulanan::class, "id_laporan_bulanan");
    }

}
