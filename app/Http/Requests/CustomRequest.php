<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser uma string.',
            'max' => 'O campo :attribute não pode ter mais de :max caracteres.',
            'exists' => 'O :attribute selecionado é inválido.',
            'in' => 'O valor do campo :attribute deve ser um dos seguintes: :values.',
            'file' => 'O campo :attribute deve ser um arquivo válido.',
            'mimes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
            'max_file' => 'O campo :attribute não pode ser maior que :max KB.',
        ];
    }
}