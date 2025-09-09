<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;

class TrainingInstance extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'training_id',
        'training_start',
        'training_end',
        'duration_hours',
        'sponsor_facilitator',
        'office_id',
    ];
    // Each instance belongs to a specific training
    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    // An instance can have many attendees
    public function attendees()
    {
        return $this->belongsToMany(PersonInfo::class, 'training_instance_attendee')
            ->withPivot('certificate_path')
            ->withTimestamps();
    }

    // Optional: Duration in hours based on start and end dates
    public function getDurationInHoursAttribute()
    {
        if (!$this->training_start || !$this->training_end) {
            return null;
        }

        return Carbon::parse($this->training_start)->floatDiffInHours(Carbon::parse($this->training_end));
    }
}
