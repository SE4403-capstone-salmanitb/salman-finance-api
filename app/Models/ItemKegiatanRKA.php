<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\EncryptedRow;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;

class ItemKegiatanRKA extends Model implements CipherSweetEncrypted
{
    use HasFactory, UsesCipherSweet;

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

    /**
     * Encrypted Fields
     *
     * Each column that should be encrypted should be added below. Each column
     * in the migration should be a `text` type to store the encrypted value.
     *
     * ```
     * ->addField('column_name')
     * ->addBooleanField('column_name')
     * ->addIntegerField('column_name')
     * ->addTextField('column_name')
     * ```
     *
     * Optional Fields
     * 
     * These do not encrypt when NULL is provided as a value.
     * Instead, they become an unencrypted NULL.
     * 
     * ```
     * ->addOptionalTextField('column_name')
     * ->addOptionalBooleanField('column_name')
     * ->addOptionalFloatField('column_name')
     * ->addOptionalIntegerField('column_name')
     * ```
     * 
     * A JSON array can be encrypted as long as the key structure is defined in
     * a field map. See the docs for details on defining field maps.
     *
     * ```
     * ->addJsonField('column_name', $fieldMap)
     * ```
     *
     * Each field that should be searchable using an exact match needs to be
     * added as a blind index. Partial search is not supported. See the docs
     * for details on bit sizes and how to use compound indexes.
     *
     * ```
     * ->addBlindIndex('column_name', new BlindIndex('column_name_index'))
     * ```
     *
     * @see https://github.com/spatie/laravel-ciphersweet
     * @see https://ciphersweet.paragonie.com/
     * @see https://ciphersweet.paragonie.com/php/blind-index-planning
     * @see https://github.com/paragonie/ciphersweet/blob/master/src/EncryptedRow.php
     *
     * @param EncryptedRow $encryptedRow
     *
     * @return void
     */
    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addTextField('uraian')
            ->addTextField('quantity_unit')
            ->addTextField('frequency_unit')
            ->addTextField('sumber_dana')

            ->addIntegerField('frequency')
            ->addIntegerField('quantity')
            ->addIntegerField('nilai_satuan')

            ->addBooleanField('dana_jan')
            ->addBooleanField('dana_feb')
            ->addBooleanField('dana_mar')
            ->addBooleanField('dana_apr')
            ->addBooleanField('dana_mei')
            ->addBooleanField('dana_jun')
            ->addBooleanField('dana_jul')
            ->addBooleanField('dana_aug')
            ->addBooleanField('dana_sep')
            ->addBooleanField('dana_oct')
            ->addBooleanField('dana_nov')
            ->addBooleanField('dana_dec')

            ->addBlindIndex('sumber_dana', new BlindIndex('sumber_dana_item_rka_index'));
    }


    public function Judul()
    {
        return $this->BelongsTo(JudulKegiatanRKA::class, 'id_judul_kegiatan');
    }

    public function getTotalDanaAttribute(){
        return $this->nilai_satuan * $this->quantity * $this->frequency;
    }
}
