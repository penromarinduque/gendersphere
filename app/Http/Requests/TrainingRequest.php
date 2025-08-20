<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Training;
use Illuminate\Validation\Rule;

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
 /*    public function rules() : array
    {
        return [
            'training_title' => ['required', 'string', 'unique:trainings,training_title,NULL,id,office_id,' . auth()->user()->office_id],
            'training_start' => ['required', 'date', 'before_or_equal:training_end'],
            'training_end' => ['required', 'date', 'after_or_equal:training_start'],
            'duration_hours' => 'required|numeric|min:0',
            'learning_description_type' => ['required'],
            'sponsor_facilitator' => ['required', 'string'],
            'office_id' => 'required|integer',
            'is_gad_related' => ['boolean'],
            'training_nature' => ['required', 'in:attended,conducted'],
            
        ];
    } */
       public function rules(): array
    {
        $training = $this->route('training');  // IMPORTANT: use 'training'
    $trainingId = is_object($training) ? $training->id : $training;

    $titleRule = Rule::unique('trainings', 'training_title')
        ->where('office_id', auth()->user()->office_id);

    if ($this->isMethod('put') || $this->isMethod('patch')) {
        $titleRule = $titleRule->ignore($trainingId);
    }

        return [
            'training_title' => ['required', 'string', $titleRule],
            'training_start' => ['required', 'date', 'before_or_equal:training_end'],
            'training_end' => ['required', 'date', 'after_or_equal:training_start'],
            'duration_hours' => ['required', 'numeric', 'min:0'],
            'learning_description_type' => ['required', 'string'],
            'sponsor_facilitator' => ['required', 'string'],
            'is_gad_related' => ['boolean'],
            'training_nature' => ['required', 'in:attended,conducted'],
        ];
    }
}

