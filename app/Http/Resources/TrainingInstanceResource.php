<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrainingInstanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'training_title' => $this->training?->training_title,
            'training_nature' => $this->training?->training_nature,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

