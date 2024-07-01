<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDanaRequest extends FormRequest
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
            'is_pengeluaran' => "boolean|nullable",
            'jumlah' => "integer|nullable",
            'ras' => "integer|nullable",
            'kepesertaan' => "integer|nullable",
            'dpk' => "integer|nullable",
            'pusat' => "integer|nullable",
            'wakaf' => "integer|nullable",
            'id_laporan_bulanan' => "integer|nullable|exists:laporan_bulanans,id"
        ];
    }
}
