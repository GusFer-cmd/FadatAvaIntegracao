<?php

namespace App\Http\Requests\ClassRoom;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassroomRequest extends FormRequest
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
            'class_number' => 'required|integer|max:2',
            'person_class' => 'required|in:PR,ED,HI',
            'academic_building' => 'nullable|string|max:1',
            'url' => 'nullable|string|max:150',
        ];
    }

    public function messages(): array
    {
        return [
            'class_number.required' => 'O campo "Número da sala" é obrigatório.',
            'class_number.integer' => 'O campo "Número da sala" deve ser um número inteiro.',
            'class_number.max' => 'O campo "Número da sala" não pode ter mais de 2 dígitos.',
            'person_class.required' => 'O campo "Tipo de aula" é obrigatório.',
            'academic_building.string' => 'O campo "Bloco" deve espera somente um caractere.',
            'academic_building.max' => 'O campo "Bloco" não pode ter mais de 1 caractere.',
            'url.max' => 'O campo "URL" não pode ter mais de 150 caracteres.',
        ];
    }
}
