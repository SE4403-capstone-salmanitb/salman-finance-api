<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
    ];

    protected $casts = [
        'nama' => 'encrypted',
    ];

    public function Programs()
    {
        return $this->hasMany(Bidang::class, 'id_bidang');
    }
}
