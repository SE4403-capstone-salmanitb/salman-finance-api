<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLaporanKPIBulananRequest extends FormRequest
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
            'capaian' => ['integer', 'nullable'],
            'deskripsi' => 'string|nullable|max:255',
            'id_laporan_bulanan' => 'integer|nullable|exists:id,laporan_bulanans',
            'id_kpi' => 'integer|nullable|exists:id,key_performance_indicators'
        ];
    }
}
