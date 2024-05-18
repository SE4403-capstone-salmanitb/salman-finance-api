<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemKegiatanRKARequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'uraian' => 'required|string',
        'nilai_satuan' => 'required|integer',
        'quantity' => 'required|integer',
        'quantity_unit' => 'required|string',
        'frequency' => 'required|integer',
        'frequency_unit' => 'required|string',
        'sumber_dana' => 'required|string',

        'dana_jan' => 'required|boolean',
        'dana_feb' => 'required|boolean',
        'dana_mar' => 'required|boolean',
        'dana_apr' => 'required|boolean',
        'dana_mei' => 'required|boolean',
        'dana_jun' => 'required|boolean',
        'dana_jul' => 'required|boolean',
        'dana_aug' => 'required|boolean',
        'dana_sep' => 'required|boolean',
        'dana_oct' => 'required|boolean',
        'dana_nov' => 'required|boolean',
        'dana_dec' => 'required|boolean',
        
        'id_judul_kegiatan' => 'required|integer',
        ];
    }
}
