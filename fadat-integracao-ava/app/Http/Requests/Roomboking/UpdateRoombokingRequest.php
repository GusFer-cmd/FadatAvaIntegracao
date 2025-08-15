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
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date|after:start_date_time',
            'professor_id' => 'required|exists:professors,id',
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
        ];
    }

    public function messages(): array
    {
        return [
            'start_date_time.required' => 'A data de início e horário são obrigatórios.',
            'end_date_time.required' => 'A data de término e horário são obrigatórios.',
            'end_date_time.after' => 'A data de término e o seu horário deve ser posterior a de início.',
            'professor_id.required' => 'O professor é obrigatório.',
            'subject_id.required' => 'A disciplina é obrigatória.',
            'classroom_id.required' => 'A Sala é obrigatória.',
        ];
    }
}
