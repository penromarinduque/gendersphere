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

    protected $fillable = ['training_title', 'training_start', 'training_end', 'duration_hours', 'learning_description_type', 'sponsor_facilitator', 'created_at', 'updated_at', 'office_id'];

    public function learningDescription($type = null)
    {
        $arr_ld = [
            'managerial' => 'Managerial',
            'supervisory' => 'Supervisory',
            'technical' => 'Technical',
        ];
    }
 /*    public function getDurationInHours()
{
    if (!$this->training_start || !$this->training_end) {
        return null;
    }

    return Carbon::parse($this->training_start)->floatDiffInHours(Carbon::parse($this->training_end));
} */
    public function attendees()
    {
        return $this->belongsToMany(PersonInfo::class, 'training_users');
    }
}

