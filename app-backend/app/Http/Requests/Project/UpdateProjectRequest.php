<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'name' => 'Project Name',
            'description' => 'Description',
            'user_id' => 'User',
            'tasks' => 'Tasks'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'exists' => 'The :attribute does not exist.',
            'string' => 'The :attribute must be a string.',
            'in' => 'The :attribute must be one of: :values.',
            'array' => 'The :attribute must be an array.',
            'tasks.*.title' => 'The :attribute field is required.',
            'tasks.*.status' => 'The :attribute must be one of: :values.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // user_id has to be the logged user id
        $user = Auth::user();

        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'string|in:pending,in_progress,completed',
            'user_id' => 'exists:users,id|in:' . $user->id,
            'tasks' => 'array',
            'tasks.*.id' => 'exists:tasks,id',
            'tasks.*.title' => 'required|string',
            'tasks.*.status' => 'string|in:pending,in_progress,completed',
        ];
    }

    protected function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422));
        }
    }
}
