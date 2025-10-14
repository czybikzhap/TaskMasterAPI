<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
        $taskId = $this->route('task');
        
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                'min:3'
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'status' => [
                'required',
                Rule::in(['pending', 'in_progress', 'completed'])
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Название задачи обязательно для заполнения.',
            'title.string' => 'Название задачи должно быть строкой.',
            'title.max' => 'Название задачи не может превышать 255 символов.',
            'title.min' => 'Название задачи должно содержать минимум 3 символа.',
            'description.string' => 'Описание должно быть строкой.',
            'description.max' => 'Описание не может превышать 1000 символов.',
            'status.required' => 'Статус задачи обязателен для заполнения.',
            'status.in' => 'Статус должен быть одним из: pending, in_progress, completed.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'название задачи',
            'description' => 'описание',
            'status' => 'статус',
        ];
    }
}
