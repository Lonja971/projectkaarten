<?php

namespace App\Http\Requests\Sprints;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateSprintRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [    
            'reflection' => 'string|max:255',
            'feedback' => 'string|max:255',
            'goals' => 'nullable|array',

            'goals.create' => 'nullable|array',
            'goals.create.*.description' => 'required|string',
            'goals.create.*.is_retrospective' => 'required|boolean',
            'goals.create.*.workprocess_ids' => 'nullable|array',
            'goals.create.*.workprocess_ids.*' => 'required|integer|exists:work_processes,id',
            
            'goals.update' => 'nullable|array',
            'goals.update.*.id' => 'required|integer|exists:sprint_goals_and_retrospectives,id',
            'goals.update.*.description' => 'sometimes|required|string',
            'goals.update.*.is_retrospective' => 'sometimes|required|boolean',
            'goals.update.*.workprocesses' => 'nullable|array',
            'goals.update.*.workprocesses.add' => 'nullable|array',
            'goals.update.*.workprocesses.add.*' => 'integer|exists:work_processes,id',
            'goals.update.*.workprocesses.remove' => 'nullable|array',
            'goals.update.*.workprocesses.remove.*' => 'integer|exists:work_processes,id',
            
            'goals.delete' => 'nullable|array',
            'goals.delete.*' => 'integer',
        ];
    }
}
