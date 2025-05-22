<?php

namespace App\Http\Requests;

class StoreChamadoRequest extends CustomRequest
{
    public function authorize(): bool
    {
        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'descricao' => 'required',
            'categoria' => 'required|string',
            'prioridade' => 'required|in:Baixa,Média,Alta',
            'anexo' => 'nullable|file|max:2048',
        ];
    }
}