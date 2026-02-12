<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OfficeRequest extends FormRequest
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
            'office_name' => ['required', 'string', 'max:100'],
            'office_type' => ['required', Rule::in(['region', 'penro', 'cenro'])],
            'region_id' => ['required_if:office_type,region','nullable', 'exists:regions,id'],
            'barangay_id' => ['required', 'exists:barangays,id'],
            'parent_id' => [
                Rule::requiredIf(fn () => in_array($this->input('office_type'), ['penro', 'cenro'])),
                "nullable",
                'exists:offices,id'
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'region_id' => 'region',
            'barangay_id' => 'location',
            'parent_id' => 'parent office'
        ];
    }

}
