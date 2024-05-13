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

        'sumber_dana_pusat',
        'sumber_dana_ras',
        'sumber_dana_kepesertaan',
        'sumber_dana_pihak_ketiga',
        'sumber_dana_pusat_wakaf_salman',

        'id_program'
    ];

    /**
     * Satu ProgramKegiatanRKA dimiliki oleh sebuah program
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }
}
