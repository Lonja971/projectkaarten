<?php

namespace App\Http\Requests;

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
            'sprint' => 'nullable|array',
            'sprint.reflection' => 'string|max:255',
            'sprint.feedback' => 'string|max:255',

            'goals' => 'nullable|array',
            
            'goals.update' => 'nullable|array',
            'goals.update.*.description' => 'sometimes|required|string',
            'goals.update.*.is_retrospective' => 'sometimes|required|boolean',
            
            'goals.delete' => 'nullable|array',
            'goals.delete.*' => 'integer',
            
            'goals.create' => 'nullable|array',
            'goals.create.*.description' => 'required|string',
            'goals.create.*.is_retrospective' => 'required|boolean',
            
            'workprocesses' => 'nullable|array',

            'workprocesses.delete' => 'nullable|array',
            'workprocesses.delete.*' => 'integer',

            'workprocesses.create' => 'nullable|array',
            'workprocesses.create.*.sprint_goal_id' => 'required|integer',
            'workprocesses.create.*.workprocess_id' => 'required|integer',
        ];
    }
}
