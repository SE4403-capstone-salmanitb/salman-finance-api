<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\EncryptedRow;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;

class ProgramKegiatanRKA extends Model implements CipherSweetEncrypted
{
    use HasFactory, UsesCipherSweet;

    protected $fillable = [
        'nama',
        'deskripsi',
        'output',
        'tahun',

        'id_program'
    ];

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addTextField('nama')
            ->addTextField('deskripsi')
            ->addTextField('output')
            ->addTextField('tahun')
            ->addBlindIndex('tahun', new BlindIndex('tahun_program_rka_index'));
    }

    /**
     * Satu ProgramKegiatanRKA dimiliki oleh sebuah program
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }

    /**
     * Satu ProgramKegiatanRKA memiliki banyak judul kegiatan rka
     */
    public function Judul()
    {
        return $this->hasMany(JudulKegiatanRKA::class, 'id_program_kegiatan_rka');
    }

    public function getTotalDanaAttribute()
    {
        return $this->Judul->sum('TotalDana');
    }

    public function getDanaFromRASAttribute()
    {
        return $this->Judul->sum('DanaFromRas');
    }

    public function getDanaFromPusatAttribute()
    {
        return $this->Judul->sum('DanaFromPusat');
    }
    
    public function getDanaFromKepesertaanAttribute()
    {
        return $this->Judul->sum('DanaFromKepesertaan');
    }

    public function getDanaFromPihakKetigaAttribute()
    {
        return $this->Judul->sum('DanaFromPihakKetiga');
    }
    
    public function getDanaFromWakafSalmanAttribute()
    {
        return $this->Judul->sum('DanaFromWakafSalman');
    }

    public function withAppends(array $appends){
        $this->appends = $appends;
    }
}
