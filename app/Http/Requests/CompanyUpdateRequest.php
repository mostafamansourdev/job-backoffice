<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
            // 'name' is required and must be a string with a maximum length of 255 characters
            'name' => 'required|string|max:255|unique:companies,name,' . $this->route('company'),
            "address" => "required|string|max:500",
            "industry" => "required|string|max:255",
            "website" => "nullable|string|url|max:255",

            // owner email cannot be changed
            // owner credentials
            'owner_name' => 'required|string|max:255',
            'owner_password' => 'nullable|string|min:8|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The job category name is required.',
            'name.string' => 'The job category name must be a string.',
            'name.max' => 'The job category name may not be greater than 255 characters.',
            'name.unique' => 'The job category name has already been taken.',

            "address.required" => "The company address is required.",
            "address.max" => "The company address must not exceed 500 characters.",
            "address.string" => "The company address must be a string.",

            "industry.required" => "The industry is required.",
            "industry.string" => "The industry must be a string.",
            "industry.max" => "The industry must not exceed 255 characters.",

            "website.string" => "The website must be a string.",
            "website.url" => "The website must be a valid URL.",
            "website.max" => "The website must not exceed 255 characters.",

            // owner credentials
            "owner_name.string" => "The owner name must be a string.",
            "owner_name.max" => "The owner name must not exceed 255 characters.",

            "owner_password.string" => "The owner password must be a string.",
            "owner_password.min" => "The owner password must be at least 8 characters.",
            "owner_password.max" => "The owner password must not exceed 255 characters.",
        ];
    }
}
