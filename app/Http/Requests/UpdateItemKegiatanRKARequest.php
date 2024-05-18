<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemKegiatanRKARequest extends FormRequest
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
            'uraian' => 'nullable|string|max:255',
            'nilai_satuan' => 'nullable|integer',
            'quantity' => 'nullable|integer',
            'quantity_unit' => 'nullable|string|max:255',
            'frequency' => 'nullable|integer',
            'frequency_unit' => 'nullable|string|max:255',
            'sumber_dana' => 'nullable|string|in:Pusat,RAS,Kepesertaan,Pihak Ketiga,Wakaf Salman',

            'dana_jan' => 'nullable|boolean',
            'dana_feb' => 'nullable|boolean',
            'dana_mar' => 'nullable|boolean',
            'dana_apr' => 'nullable|boolean',
            'dana_mei' => 'nullable|boolean',
            'dana_jun' => 'nullable|boolean',
            'dana_jul' => 'nullable|boolean',
            'dana_aug' => 'nullable|boolean',
            'dana_sep' => 'nullable|boolean',
            'dana_oct' => 'nullable|boolean',
            'dana_nov' => 'nullable|boolean',
            'dana_dec' => 'nullable|boolean',

            'id_judul_kegiatan' => 'nullable|integer|exists:judul_kegiatan_r_k_a_s,id',
        ];
    }
}
