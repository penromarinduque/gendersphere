<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingRequest extends FormRequest
{
    public function authorize(): bool   {
        return true; // You can adjust this for authorization logic
    }

    protected function prepareForValidation(): void {
        if ($this->has('training_instance')) {
            $this->merge([
                'training_instance' => (array) $this->input('training_instance'),
            ]);
        }
    }

    public function rules(): array  {
        return [
            'training_title' => 'required|string',
            'learning_description_type' => 'required|string',
            'training_nature' => 'required|string',
            'is_gad_related' => 'required|boolean',

            'training_instance' => 'required|array',

            'training_instance.training_start' => 'required|date',
            'training_instance.training_end' => 'required|date|after_or_equal:training_instance.training_start',
            'training_instance.duration_hours' => 'required|numeric|min:0',
            'training_instance.sponsor_facilitator' => 'required|string',
            'training_instance.office_id' => 'required|integer|exists:offices,id',
        ];
    }

    public function messages(): array
    {
        return [
            'training_title.required' => 'Training title is required.',
            'training_instance.training_end.after_or_equal' => 'Training end date must be after or equal to start date.',
        ];
    }
}
