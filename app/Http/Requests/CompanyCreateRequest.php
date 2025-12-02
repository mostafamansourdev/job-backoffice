<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
            "name" => "required|string|max:255|unique:companies,name",
            "address" => "required|string|max:500",
            "industry" => "required|string|max:255",
            "website" => "nullable|string|url|max:255",

            // Owner credentials
            "owner_name" => "required|string|max:255",
            "owner_email" => "required|string|email|max:255|unique:users,email",
            "owner_password" => "required|string|min:8",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "The job category name is required.",
            "name.unique" => "The job category name has already been taken.",
            "name.max" => "The job category name must not exceed 255 characters.",
            "name.string" => "The job category name must be a string.",

            "address.required" => "The company address is required.",
            "address.max" => "The company address must not exceed 500 characters.",
            "address.string" => "The company address must be a string.",

            "industry.required" => "The industry is required.",
            "industry.string" => "The industry must be a string.",
            "industry.max" => "The industry must not exceed 255 characters.",

            "website.string" => "The website must be a string.",
            "website.url" => "The website must be a valid URL.",
            "website.max" => "The website must not exceed 255 characters.",

            // Owner credentials
            "owner_name.required" => "The owner name is required.",
            "owner_name.string" => "The owner name must be a string.",
            "owner_name.max" => "The owner name must not exceed 255 characters.",

            "owner_email.required" => "The owner email is required.",
            "owner_email.string" => "The owner email must be a string.",
            "owner_email.email" => "The owner email must be a valid email address.",
            "owner_email.max" => "The owner email must not exceed 255 characters.",
            "owner_email.unique" => "The owner email has already been taken.",

            "owner_password.required" => "The owner password is required.",
            "owner_password.string" => "The owner password must be a string.",
            "owner_password.min" => "The owner password must be at least 8 characters.",

        ];
    }
}
