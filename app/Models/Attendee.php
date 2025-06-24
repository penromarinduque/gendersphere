<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Attendee extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = ['activity_id', 'activity_detail_id', 'person_info_id'];

    public function getByActivityDetailId($activity_detail_id)
    {
        return $this->select('attendees.person_info_id', 'person_infos.gender')
            ->join('person_infos', 'person_infos.id', 'attendees.person_info_id')
            ->join('activity_details', 'activity_details.id', 'attendees.activity_detail_id')
            ->where('activity_details.id', $activity_detail_id)
            ->get();
    }

    public function personInfo()
    {
        return $this->belongsTo(PersonInfo::class);
    }
}
