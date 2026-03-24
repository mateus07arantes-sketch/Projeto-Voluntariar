<?php

namespace App\Http\Requests;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OngRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('cnpj') && !empty($this->cnpj)) {
            $this->merge([
                'cnpj' => $this->formatarCNPJ($this->cnpj)
            ]);
        }

        if ($this->has('phone') && !empty($this->phone)) {
            $this->merge([
                'phone' => $this->formatarTelefone($this->phone)
            ]);
        }
    }

    public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'cnpj' => [
            'required',
            'string',
            'max:18',
            function ($attribute, $value, $fail) {
                // Remove formatação para verificar unique
                $cnpjLimpo = preg_replace('/[^0-9]/', '', $value);
                
                // Verifica se já existe um CNPJ com esses números
                if (\App\Models\Ong::where('cnpj', $cnpjLimpo)->exists()) {
                    $fail('Este CNPJ já está cadastrado.');
                }
            },
            'regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/'
        ],
        'email' => [
            'required',
            'email:rfc,dns',
            'max:255',
            'unique:users,email',
            'unique:ongs,email'
        ],
        'phone' => [
            'required',
            'string',
            'max:20',
            'regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/'
        ],
        'address' => 'required|string|max:500',
        'description' => 'required|string|max:1000',
        'password' => [
            'required',
            'string',
            'min:6',
            'max:12',
            'confirmed',
        ],
        'password_confirmation' => 'required|string|same:password',
    ];
}
    public function messages(): array
    {
        return [
            'name.required' => 'O nome da ONG é obrigatório.',
            'name.max' => 'O nome não pode exceder 255 caracteres.',
            
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'cnpj.regex' => 'O formato do CNPJ deve ser: 00.000.000/0000-00.',
            
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            
            'phone.required' => 'O telefone é obrigatório.',
            'phone.regex' => 'O formato do telefone deve ser: (00) 00000-0000 ou (00) 0000-0000.',
            
            'address.required' => 'O endereço é obrigatório.',
            'address.max' => 'O endereço não pode exceder 500 caracteres.',
            
            'description.required' => 'A descrição é obrigatória.',
            'description.max' => 'A descrição não pode exceder 1000 caracteres.',
            
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'password.max' => 'A senha deve ter no máximo 12 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
            
            'password_confirmation.required' => 'A confirmação de senha é obrigatória.',
            'password_confirmation.same' => 'As senhas não conferem.',
        ];
    }

    private function formatarCNPJ(string $cnpj): string
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        
        if (empty($cnpj)) {
            return '';
        }
        
        $cnpj = substr($cnpj, 0, 14);
        
        if (strlen($cnpj) === 14) {
            return sprintf(
                '%s.%s.%s/%s-%s',
                substr($cnpj, 0, 2),
                substr($cnpj, 2, 3),
                substr($cnpj, 5, 3),
                substr($cnpj, 8, 4),
                substr($cnpj, 12, 2)
            );
        }
        
        return $cnpj;
    }

    private function formatarTelefone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (empty($phone)) {
            return '';
        }
        
        if (strlen($phone) === 11) {
            return sprintf(
                '(%s) %s-%s',
                substr($phone, 0, 2),
                substr($phone, 2, 5),
                substr($phone, 7, 4)
            );
        } elseif (strlen($phone) === 10) {
            return sprintf(
                '(%s) %s-%s',
                substr($phone, 0, 2),
                substr($phone, 2, 4),
                substr($phone, 6, 4)
            );
        }
        
        return $phone;
    }
}