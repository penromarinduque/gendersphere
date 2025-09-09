<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class Training extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'training_title',
        'learning_description_type',
        'training_nature',
        'is_gad_related',
    ];

    public function instances() {
        return $this->hasMany(TrainingInstance::class);
    }
/*     public function learningDescription($type = null)
    {
        $arr_ld = [
            'managerial' => 'Managerial',
            'supervisory' => 'Supervisory',
            'technical' => 'Technical',
        ];
    } */
 /*    public function getDurationInHours()
{
    if (!$this->training_start || !$this->training_end) {
        return null;
    }

    return Carbon::parse($this->training_start)->floatDiffInHours(Carbon::parse($this->training_end));
} */

}

