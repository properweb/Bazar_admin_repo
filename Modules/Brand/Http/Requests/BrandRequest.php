<?php

namespace Modules\Brand\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\JsonResponse;

class BrandRequest extends FormRequest
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
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'country_code' => 'required|numeric',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'language' => 'required|string',
            'document' => 'required|mimes:pdf,doc,docx|max:2048',
            'brand_name' => 'required|string|max:255',
            'brand_email' => 'required|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'website_url' => ['required','regex:/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/'],
            'prime_cat' => 'required|integer|exists:categories,id',
            'country' => 'required|integer|exists:countries,id',
            'num_products_sell' => 'required|string',
            'num_store' => 'required|string',
            'about_us' => 'required|string',
            'established_year' => 'required|digits:4|integer|min:1900|max:'.date('Y'),
            'insta_handle' => ['nullable','regex:/^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29}$/'],
            'headquatered' => 'required|integer|exists:countries,id',
            'city' => 'nullable|integer|exists:cities,id',
            'state' => 'nullable|integer|exists:states,id',
            'product_made' => 'nullable|integer|exists:countries,id',
            'product_shipped' => 'nullable|integer|exists:countries,id',
        ];
    }

}
