<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ParagonIE\CipherSweet\EncryptedRow;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;

class AlokasiDana extends Model implements CipherSweetEncrypted
{
    use HasFactory, UsesCipherSweet;

    protected $fillable = [
        'id_laporan_bulanan',
        'id_item_rka',
        'jumlah_realisasi'
    ];

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addIntegerField('jumlah_realisasi');
    }

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
