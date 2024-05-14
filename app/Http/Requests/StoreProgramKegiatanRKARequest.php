<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramKegiatanRKARequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'output' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900',
    
            'sumber_dana_pusat' => 'integer|nullable',
            'sumber_dana_ras' => 'integer|nullable',
            'sumber_dana_kepesertaan' => 'integer|nullable',
            'sumber_dana_pihak_ketiga' => 'integer|nullable',
            'sumber_dana_pusat_wakaf_salman' => 'integer|nullable',
    
            'id_program' => 'required|integer|exists:programs,id',
        ];
    }
}
