<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'id_bidang'
    ];

    public function Bidang()
    {
        return $this->belongsTo(Bidang::class, 'id_bidang');
    }

    public function ProgramKegiatanRKA()
    {
        return $this->hasMany(ProgramKegiatanRka::class, 'id_program');
    }

    public function ProgramKegiatanKPI()
    {
        return $this->hasMany(ProgramKegiatanKPI::class, 'id_program');
    }

    public function LaporanBulanan()
    {
        return $this->hasMany(LaporanBulanan::class, 'program_id');
    }
}
