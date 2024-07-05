<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\EncryptedRow;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;

class Pelaksanaan extends Model implements CipherSweetEncrypted
{
    use HasFactory, SoftDeletes, UsesCipherSweet;

    protected $fillable = [
        "penjelasan",
        "waktu",
        "tempat",
        "penyaluran",
        "id_program_kegiatan_kpi",
        "id_laporan_bulanan"
    ];

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addTextField('penjelasan')
            ->addTextField('waktu')
            ->addTextField('tempat')
            ->addTextField('penyaluran');
    }

    public function programKegiatan()
    {
        return $this->belongsTo(ProgramKegiatanKPI::class, 'id_program_kegiatan_kpi');
    }

    public function laporanBulanan()
    {
        return $this->belongsTo(LaporanBulanan::class, "id_laporan_bulanan");
    }
}
