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
    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }
}
