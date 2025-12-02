<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
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
            "title" => "required|string|max:255",
            "description" => "required|string",
            "location" => "required|string|max:255",
            "salary" => "required|string|max:255",
            "type" => "required|in:Full-Time,Contract,Remote,Hybrid",
            "jobCategoryId" => "required|exists:job_categories,id",
            "companyId" => "required|exists:companies,id",
        ];
    }

    public function messages(): array
    {
        return [
            "title.required" => "The job title is required.",
            "title.string" => "The job title must be a string.",
            "title.max" => "The job title may not be greater than 255 characters.",

            "description.required" => "The job description is required.",
            "description.string" => "The job description must be a string.",

            "location.required" => "The job location is required.",
            "location.string" => "The job location must be a string.",
            "location.max" => "The job location may not be greater than 255 characters.",

            "salary.required" => "The salary is required.",
            "salary.string" => "The salary must be a string.",
            "salary.max" => "The salary may not be greater than 255 characters.",

            "type.required" => "The job type is required.",
            "type.in" => "The selected job type is invalid. Allowed types are: full-time, contract, Remote, Hybrid.",

            "jobCategoryId.required" => "The job category is required.",
            "jobCategoryId.exists" => "The selected job category is invalid.",

            "companyId.required" => "The company is required.",
            "companyId.exists" => "The selected company is invalid.",
        ];
    }
}
