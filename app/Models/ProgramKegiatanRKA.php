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
    public function judul()
    {
        return $this->hasMany(JudulKegiatanRKA::class, 'id_program_kegiatan_rka');
    }
}
