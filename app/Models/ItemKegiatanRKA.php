<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemKegiatanRKA extends Model
{
    use HasFactory;

    protected $fillable = [
        'uraian',
        'nilai_satuan',
        'quantity',
        'quantity_unit',
        'frequency',
        'frequency_unit',
        'sumber_dana',
        'dana_jan',
        'dana_feb',
        'dana_mar',
        'dana_apr',
        'dana_mei',
        'dana_jun',
        'dana_jul',
        'dana_aug',
        'dana_sep',
        'dana_oct',
        'dana_nov',
        'dana_dec',
        'id_judul_kegiatan'
    ];

    public function judul()
    {
        return $this->BelongsTo(JudulKegiatanRKA::class, 'id_judul_kegiatan');
    }
}
