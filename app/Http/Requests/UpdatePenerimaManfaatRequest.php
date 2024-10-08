<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenerimaManfaatRequest extends FormRequest
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
            "id_laporan_bulanan" => "nullable|exists:laporan_bulanans,id|nullable",
            "kategori" => "string|nullable|max:255",
            "tipe_rutinitas" => "string|nullable|max:255",
            "tipe_penyaluran" => "string|nullable|max:255",
            "rencana" => "integer|nullable",
            "realisasi" => "integer|nullable",
        ];
    }
}
