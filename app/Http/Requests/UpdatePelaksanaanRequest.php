<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePelaksanaanRequest extends FormRequest
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
            "penjelasan" => "nullable|string|max:255",
            "waktu" => "nullable|string|max:255",
            "tempat" => "nullable|string|max:255",
            "penyaluran" => "nullable|string|max:255",
            "id_program_kegiatan_kpi" => "nullable|integer|exists:program_kegiatan_k_p_i_s,id",
            "id_laporan_bulanan" => "nullable|integer|exists:laporan_bulanans,id",
        ];
    }
}
