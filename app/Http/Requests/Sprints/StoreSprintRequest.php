<?php

namespace App\Http\Requests\Sprints;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSprintRequest extends FormRequest
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
                'message' => 'Store failed',
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
            'project_id' => 'required|integer',
            'date_start' => 'required|date|after_or_equal:today',
            'date_end' => 'required|date|after_or_equal:date_start',

            //---GOALS-ARRAY-VALIDATION---
            'goals' => 'nullable|array',
            'goals.*.description' => 'required|string',
            'goals.*.is_retrospective' => 'required|boolean',

            //---WORKPROCESSES-ARRAY-VALIDATION---
            'goals.*.workprocess_ids' => 'nullable|array',
            'goals.*.workprocess_ids.*' => 'required|integer|exists:work_processes,id',
        ];
    }
}
