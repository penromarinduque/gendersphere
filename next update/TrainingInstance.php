<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingInstance extends Model
{
    protected $fillable = [
        'training_id',
        'office_id',
        'training_start',
        'training_end',
        'duration_hours',
        'training_nature',
        'sponsor_facilitator',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function attendees()
    {
        return $this->belongsToMany(PersonInfo::class, 'attendee_training_instance')
            ->withPivot('certificate_path')
            ->withTimestamps();
    }
}
