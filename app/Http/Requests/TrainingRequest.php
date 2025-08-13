<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Training;

class TrainingRequest extends FormRequest
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
            'training_title' => ['required', 'string', 'unique:trainings,training_title,NULL,id,office_id,' . auth()->user()->office_id],
            'training_start' => ['required'],
            'training_end' => ['required'],
            'duration_hours' => 'required|numeric|min:0',
            'learning_description_type' => ['required'],
            'sponsor_facilitator' => ['required', 'string'],
            'office_id' => 'required|integer',
        ];
    }
}

