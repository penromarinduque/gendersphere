<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'training_title',
        'learning_description_type',
        'is_gad_related',
    ];

    public function instances()
    {
        return $this->hasMany(TrainingInstance::class);
    }
}
