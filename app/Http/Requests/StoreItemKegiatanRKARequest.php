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
            'uraian' => 'required|string|max:255',
            'nilai_satuan' => 'required|integer',
            'quantity' => 'required|integer',
            'quantity_unit' => 'required|string|max:255',
            'frequency' => 'required|integer',
            'frequency_unit' => 'required|string|max:255',
            'sumber_dana' => 'required|string|in:Pusat,RAS,Kepesertaan,Pihak Ketiga,Wakaf Salman',

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

            'id_judul_kegiatan' => 'required|integer|exists:judul_kegiatan_r_k_a_s,id',
        ];
    }
}
