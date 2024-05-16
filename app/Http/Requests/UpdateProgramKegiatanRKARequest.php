<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgramKegiatanRKARequest extends FormRequest
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
            'nama' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'output' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer|min:1900',
    
            'sumber_dana_pusat' => 'integer|nullable',
            'sumber_dana_ras' => 'integer|nullable',
            'sumber_dana_kepesertaan' => 'integer|nullable',
            'sumber_dana_pihak_ketiga' => 'integer|nullable',
            'sumber_dana_wakaf_salman' => 'integer|nullable',
    
            'id_program' => 'nullable|integer|exists:programs,id',
        ];
    }
}
