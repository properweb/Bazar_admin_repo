<?php

namespace Modules\Role\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class UserRequest extends FormRequest
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
        return [
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
            'email' => 'required|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email',
            'password' => [
                'required',
                'string',
                'max:8',
                'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[^\w\s]).{1,}$/'
            ],
            'role' => 'required|numeric'
        ];
    }

    /**
     * Create a json response on validation errors.
     *
     * @param Validator $validator
     * @return JsonResponse
     */
    public function failedValidation(Validator $validator): JsonResponse
    {

        return (response()->json([
            'res' => false,
            'msg' => $validator->errors()->first(),
            'data' => ""
        ]));

    }
}
