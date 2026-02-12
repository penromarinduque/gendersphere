<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingRequest extends FormRequest
{
    public function rules() {
    return [
        'training_title' => ['required', 'string'],
        'learning_description_type' => ['required', 'string'],
        'is_gad_related' => ['required', 'boolean'],
        'training_nature' => ['required', 'in:attended,conducted'],
        'office_id' => ['required', 'exists:offices,id'],

        'training_instance' => ['required', 'array'],
        'training_instance.start_date' => ['required', 'date'],
        'training_instance.end_date' => ['required', 'date', 'after_or_equal:training_instance.start_date'],
        'training_instance.duration_hours' => ['required', 'numeric'],
        'training_instance.sponsor_facilitator' => ['required', 'string'],
        'training_instance.office_id' => ['required', 'exists:offices,id'],
    ];
    }

}
