<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramKegiatanRKA extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'output',
        'tahun',

        'id_program'
    ];

    protected function casts()
    {
        return [
            'nama' => 'encrypted',
            'deskripsi'=> 'encrypted',
            'output'=> 'encrypted',
        ];
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
