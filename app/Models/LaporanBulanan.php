<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanBulanan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode',
        'bulan_laporan',
        'disusun_oleh',
        'diperiksa_oleh',
        'tanggal_pemeriksaan',
        'program_id'
    ];

    public $timestamps = true;

    const CREATED_AT = 'tanggal_pembuatan';
    const UPDATED_AT = 'updated_at';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_pembuatan' => 'datetime',
            'tanggal_pemeriksaan' => 'datetime',
            'bulan_laporan' => 'date:m-Y',
        ];
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function disusunOleh()
    {
        return $this->belongsTo(User::class, 'disusun_oleh');
    }

    public function diperiksaOleh()
    {
        return $this->belongsTo(User::class, 'diperiksa_oleh');
    }

    public function getNamaAttribute()
    {
        return $this->program->nama;
    }

    public function pelaksanaans()
    {
        return $this->hasMany(Pelaksanaan::class, "id_laporan_bulanan");
    }

    public function KPIBulanans()
    {
        return $this->hasMany(LaporanKPIBulanan::class, "id_laporan_bulanan");
    }
}
