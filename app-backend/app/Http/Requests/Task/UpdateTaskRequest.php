<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateTaskRequest extends FormRequest
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
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'user_id' => 'User'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'exists' => 'The :attribute does not exist.',
            'string' => 'The :attribute must be a string.',
            'in' => 'The :attribute must be in the list.',
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
            'user_id' => 'required|exists:users,id|in:' . $user->id,
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string|in:pending,in_progress,completed',
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
