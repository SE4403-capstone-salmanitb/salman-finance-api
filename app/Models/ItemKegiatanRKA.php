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

    protected $casts = [
        'uraian'=> 'encrypted',
        'nilai_satuan'=> 'encrypted',
        'quantity'=> 'encrypted',
        'quantity_unit'=> 'encrypted',
        'frequency'=> 'encrypted',
        'frequency_unit'=> 'encrypted',
        'dana_jan'=> 'encrypted',
        'dana_feb'=> 'encrypted',
        'dana_mar'=> 'encrypted',
        'dana_apr'=> 'encrypted',
        'dana_mei'=> 'encrypted',
        'dana_jun'=> 'encrypted',
        'dana_jul'=> 'encrypted',
        'dana_aug'=> 'encrypted',
        'dana_sep'=> 'encrypted',
        'dana_oct'=> 'encrypted',
        'dana_nov'=> 'encrypted',
        'dana_dec'=> 'encrypted',
    ];

    public function Judul()
    {
        return $this->BelongsTo(JudulKegiatanRKA::class, 'id_judul_kegiatan');
    }

    public function getTotalDanaAttribute(){
        return $this->nilai_satuan * $this->quantity * $this->frequency;
    }
}
