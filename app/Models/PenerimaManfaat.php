<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\EncryptedRow;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;

class PenerimaManfaat extends Model implements CipherSweetEncrypted
{
    use HasFactory, UsesCipherSweet, SoftDeletes;

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

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addTextField('kategori')
            ->addTextField('tipe_rutinitas')
            ->addTextField('tipe_penyaluran')
            ->addIntegerField('rencana')
            ->addIntegerField('realisasi');

    }

    /**
     * Get the laporan_bulanan that owns the PenerimaManfaat.
     */
    public function laporanBulanan()
    {
        return $this->belongsTo(LaporanBulanan::class, 'id_laporan_bulanan');
    }
}
