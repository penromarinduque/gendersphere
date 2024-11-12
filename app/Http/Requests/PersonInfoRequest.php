<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PersonInfo;

class PersonInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'lastname' => ['required', 'string'],
            'firstname' => ['required', 'string'],
            'middlename' => ['required', 'string'],
            'extname' => ['nullable', 'string'],
            'gender' => ['required'],
            'civil_status' => ['required'],
            'birthdate' => ['required'],
            'height' => ['nullable'],
            'weight' => ['nullable'],
            'blood_type' => ['nullable'],
            'province_id' => ['required'],
            'municipality_id' => ['required'],
            'barangay_id' => ['required'],
            'address_full' => ['nullable'],
            'education_level' => ['required'],
            'contact_no' => ['required', 'max:12'],
            'email_add' => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:'.PersonInfo::class],
            'employment_type' => ['required'],
            'position' => ['required'],
            'organization' => ['nullable'],
            'person_type' => ['required'],
        ];
    }
}
