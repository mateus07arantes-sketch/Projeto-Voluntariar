<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // usuário autenticado pode inscrever-se (a verificação de ONG/admin é para marcação)
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'voluntary_action_id' => 'required|exists:voluntary_actions,id',
        ];
    }

    public function messages(): array
    {
        return [
            'voluntary_action_id.required' => 'A ação selecionada é obrigatória.',
            'voluntary_action_id.exists' => 'A ação selecionada não existe.',
        ];
    }
}
