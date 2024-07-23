<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class JudulKegiatanRKA extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'id_program_kegiatan_rka'
    ];

    protected $casts = [
        'nama' => 'encrypted',
    ];

    /**
     * Satu ProgramKegiatanRKA dimiliki oleh sebuah program
     */
    public function ProgramKegiatan()
    {
        return $this->belongsTo(ProgramKegiatanRKA::class, 'id_program_kegiatan_rka');
    }

    public function Item()
    {
        return $this->hasMany(ItemKegiatanRKA::class, 'id_judul_kegiatan');
    }

    public function getTotalDanaFrom(string $sumber) {
        $result = $this->Item->where('sumber_dana', $sumber)->sum('TotalDana');
        return $result;
    } 

    public function getTotalDanaAttribute() {
        return $this->Item->sum('TotalDana');
    } 

    public function getDanaFromRASAttribute()
    {
        return $this->getTotalDanaFrom('RAS');
    }

    public function getDanaFromPusatAttribute()
    {
        return $this->getTotalDanaFrom('Pusat');
    }
    
    public function getDanaFromKepesertaanAttribute()
    {
        return $this->getTotalDanaFrom('Kepesertaan');
    }

    public function getDanaFromPihakKetigaAttribute()
    {
        return $this->getTotalDanaFrom('Pihak Ketiga');
    }

    public function getDanaFromWakafSalmanAttribute()
    {
        return $this->getTotalDanaFrom('Wakaf Salman');
    }
}
