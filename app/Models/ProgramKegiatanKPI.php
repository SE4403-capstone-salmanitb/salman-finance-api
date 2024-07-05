<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\EncryptedRow;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;

class ProgramKegiatanKPI extends Model implements CipherSweetEncrypted
{
    use HasFactory, UsesCipherSweet;

    protected $fillable = [
        'nama',
        'tahun',
        'id_program',
    ];

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addTextField('nama')
            ->addTextField('tahun')
            ->addBlindIndex('tahun', new BlindIndex('tahun_program_kpi_index'));
    }

    /**
     * Satu ProgramKegiatanRKA dimiliki oleh sebuah program
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }

    public function kpi()
    {
        return $this->hasMany(KeyPerformanceIndicator::class, 'id_program_kegiatan_kpi');
    }
}
