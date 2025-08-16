<?php

namespace App\Http\Requests\Roomboking;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoombokingRequest extends FormRequest
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
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'professor_id' => 'required|exists:professors,id',
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
        ];
    }

    public function messages(): array
    {
        return [
            'day_of_week.required' => 'O dia da semana é obrigatório.',
            'day_of_week.integer' => 'O dia da semana deve ser um número válido.',
            'day_of_week.between' => 'O dia da semana deve estar entre 0 (domingo) e 6 (sábado).',
            'start_time.required' => 'O horário de início é obrigatório.',
            'start_time.date_format' => 'O horário de início deve estar no formato HH:MM.',
            'end_time.required' => 'O horário de término é obrigatório.',
            'end_time.date_format' => 'O horário de término deve estar no formato HH:MM.',
            'end_time.after' => 'O horário de término deve ser posterior ao horário de início.',
            'professor_id.required' => 'O professor é obrigatório.',
            'professor_id.exists' => 'O professor selecionado é inválido.',
            'subject_id.required' => 'A disciplina é obrigatória.',
            'subject_id.exists' => 'A disciplina selecionada é inválida.',
            'classroom_id.required' => 'A sala é obrigatória.',
            'classroom_id.exists' => 'A sala selecionada é inválida.',
        ];
    }
}
