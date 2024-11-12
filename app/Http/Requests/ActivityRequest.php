<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Activity;

class ActivityRequest extends FormRequest
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
            'activity_type' => ['required'],
            'gad_activity' => ['required', 'string'],
            'name_title' => ['required', 'string'],
            'date_conducted' => ['required'],
            'place_conducted' => ['required'],
            'resource_speakers' => ['required'],
            'remarks' => ['nullable'],
            'gad_budget_allotment' => ['required'],
            'gad_allocated' => ['required'],
            'gad_remaining_budget' => ['required'],
        ];
    }
}
