<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudulKegiatanRKA extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'id_program_kegiatan_rka'
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
}
