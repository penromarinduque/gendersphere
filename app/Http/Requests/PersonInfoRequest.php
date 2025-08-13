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
/*     {
            $validator = Validator::make($request->all(), [
        'first_name' => 'required|string',
        'middle_name' => 'required|string',
        'last_name' => 'required|string',
        // ... other fields
    ]);

    // Add custom rule: combination must be unique
    $validator->after(function ($validator) use ($request) {
        $exists = User::where('first_name', $request->first_name)
            ->where('middle_name', $request->middle_name)
            ->where('last_name', $request->last_name)
            ->exists();

        if ($exists) {
            $validator->errors()->add('first_name', 'A user with the same first, middle, and last name already exists.');
        }
    });

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    } */
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
