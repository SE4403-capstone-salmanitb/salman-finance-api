<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLaporanBulananRequest extends FormRequest
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
            'program_id' => 'exists:programs,id|nullable',
            'kode' => 'string|max:255|nullable',
            'bulan_laporan' =>'date|date_format:m-Y|nullable',
            'disusun_oleh' => 'nullable|exists:users,id',
            'diperiksa_oleh' => 'nullable|exists:users,id',
        ];
    }
}
