<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
    ];

    public function ProgramKegiatanRKA()
    {
        return $this->hasMany(ProgramKegiatanRka::class, 'id_Program');
    }

    public function ProgramKegiatanKPI()
    {
        return $this->hasMany(ProgramKegiatanKPI::class, 'id_Program');
    }
}
