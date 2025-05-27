<?php

namespace App\Http\Requests;

class AlterarStatusChamadoRequest extends CustomRequest
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
            'status' => 'required|in:Aberto,Em atendimento,Resolvido,Fechado',
        ];
    }
}