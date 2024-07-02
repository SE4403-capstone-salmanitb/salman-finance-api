<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlokasiDanaRequest extends FormRequest
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
            //
            'jumlah_realisasi' => 'integer|required',
            "id_laporan_bulanan" => "required|integer|exists:laporan_bulanans,id",
            "id_item_rka" => "required|integer|exists:item_kegiatan_r_k_a_s,id",
        ];
    }
}
