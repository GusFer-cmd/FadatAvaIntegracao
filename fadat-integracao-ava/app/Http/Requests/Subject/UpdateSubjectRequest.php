<?php

namespace App\Http\Subject\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
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
            'semester' => ['required', 'integer', 'min:1', 'max:10'],
            'course_id' => ['nullable', 'string', 'exists:courses,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'semester.required' => 'O semestre é obrigatório.',
            'semester.integer' => 'O semestre deve ser um número inteiro.',
            'semester.min' => 'O semestre deve ser pelo menos 1.',
            'semester.max' => 'O semestre não pode ser maior que 12.',
            'course_id.exists' => 'O curso selecionado não existe.',
        ];
    }
}
