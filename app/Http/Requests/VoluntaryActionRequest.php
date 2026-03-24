<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class VoluntaryActionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Só ONG (com registro em ongs) ou admin podem criar
        $user = $this->user();
        return $user && ($user->role === 'admin' || $user->ong !== null);
    }

    /**
     * Prepare os dados para validação
     */
    protected function prepareForValidation(): void
    {
        // Garante que a data/hora está no formato correto para validação
        if ($this->has('event_datetime')) {
            try {
                $this->merge([
                    'event_datetime' => Carbon::parse($this->event_datetime)->format('Y-m-d H:i:s')
                ]);
            } catch (\Exception $e) {
                // Mantém o valor original se houver erro na conversão
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
            'category' => 'required|in:environmental,social,animal,educational',
            'description' => 'required|string',
            'location' => 'required|string',
            'event_datetime' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    try {
                        $selectedDateTime = Carbon::parse($value);
                        $minimumDateTime = Carbon::now()->addMinutes(15);
                        
                        if ($selectedDateTime->lt($minimumDateTime)) {
                            $fail("A data e hora do evento devem ser pelo menos 15 minutos no futuro. Data mínima: {$minimumDateTime->format('d/m/Y H:i')}");
                        }
                    } catch (\Exception $e) {
                        $fail('Erro ao processar a data e hora do evento.');
                    }
                },
            ],
            'vacancies' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O título da ação é obrigatório.',
            'name.string' => 'O título da ação deve ser um texto.',
            'name.max' => 'O título da ação não pode ultrapassar 150 caracteres.',

            'category.required' => 'A categoria é obrigatória.',
            'category.in' => 'A categoria selecionada é inválida.',

            'description.required' => 'A descrição é obrigatória.',
            'description.string' => 'A descrição deve ser um texto.',

            'location.required' => 'O local do evento é obrigatório.',
            'location.string' => 'O local deve ser um texto.',

            'event_datetime.required' => 'A data e hora do evento são obrigatórias.',
            'event_datetime.date' => 'A data e hora do evento devem estar em um formato válido.',

            'vacancies.required' => 'O número de vagas é obrigatório.',
            'vacancies.integer' => 'O número de vagas deve ser um número inteiro.',
            'vacancies.min' => 'O número de vagas deve ser maior que 0.',

            'image.required' => 'A imagem é obrigatória.',
            'image.image'   => 'O arquivo enviado deve ser uma imagem.',
            'image.mimes'   => 'A imagem deve ser do tipo: jpg, jpeg, png, webp ou gif.',
            'image.max'     => 'A imagem não pode ser maior que 4MB.',
        ];
    }
}