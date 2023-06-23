<?php

namespace Modules\Role\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $userId = $this->route('id');
        $emailRule = Rule::unique('users')->ignore($userId);
        return [
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
            'email' => [
                'required',
                'email',
                $emailRule,
            ],

            'new_password' => [
                'nullable',
                'string',
                'max:8',
                'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[^\w\s]).{1,}$/',
                'confirmed'
            ],
            'role' => 'required|numeric'

        ];
    }
}
