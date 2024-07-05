<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\EncryptedRow;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;

class GeolocationHistory extends Model implements CipherSweetEncrypted
{
    use HasFactory, UsesCipherSweet;

    protected $fillable = [
        'user_id',
        'ip',
        'latitude',
        'longitude',
        'countryName',
        'countryCode',
        'regionName',
        'regionCode',
        'cityName',
        'timezone',
        'driver',
        'is_authorized'
    ];

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addTextField('ip')
            ->addTextField('latitude')
            ->addTextField('longitude')
            ->addTextField('countryName')
            ->addTextField('countryCode')
            ->addTextField('regionName')
            ->addTextField('regionCode')
            ->addTextField('cityName')
            ->addTextField('timezone')
            ->addTextField('driver')
            ->addBooleanField('is_authorized')
            ->addBlindIndex('ip', new BlindIndex('ip_history_index'));
    }


}
