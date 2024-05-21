<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramKegiatanKPI extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tahun',
        'id_program',
    ];

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
