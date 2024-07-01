<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDanaRequest extends FormRequest
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
            'is_pengeluaran' => "boolean|required",
            'jumlah' => "integer|required",
            'ras' => "integer|required",
            'kepesertaan' => "integer|required",
            'dpk' => "integer|required",
            'pusat' => "integer|required",
            'wakaf' => "integer|required",
            'id_laporan_bulanan' => "integer|required|exists:laporan_bulanans,id"
        ];
    }
}
