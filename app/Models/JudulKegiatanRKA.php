<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudulKegiatanRKA extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama'
    ];

    /**
     * Satu ProgramKegiatanRKA dimiliki oleh sebuah program
     */
    public function programKegiatan()
    {
        return $this->belongsTo(ProgramKegiatanRKA::class, 'id_program_kegiatan_rka');
    }
}
