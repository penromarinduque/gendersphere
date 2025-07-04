<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ActivityDetail extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['gad_activity_id', 'sub_activity', 'targets', 'target_women', 'target_men', 'gad_budget', 'responsible_unit', 'actual_result', 'actual_women', 'actual_men', 'actual_lgbtq', 'actual_cost', 'remarks', 'mov_file'];

    public function getActivityDetail($id)
    {
        return $this->select('activity_details.id', 'gad_activity_id', 'sub_activity', 'targets', 'target_women', 'target_men', 'gad_budget', 'responsible_unit', 'actual_result', 'actual_women', 'actual_men', 'actual_lgbtq', 'actual_cost', 'remarks', 'mov_file', 'gad_activities.main_activity')
            ->join('gad_activities', 'gad_activities.id', 'activity_details.gad_activity_id')
            ->where('activity_details.id', $id)
            ->first();
    }

    public function getActivityDetailsByGA($ga_id)
    {
        return $this->select('id', 'gad_activity_id', 'sub_activity', 'targets', 'target_women', 'target_men', 'gad_budget', 'responsible_unit', 'actual_result', 'actual_women', 'actual_men', 'actual_lgbtq', 'actual_cost', 'remarks', 'mov_file')
            ->where('gad_activity_id', $ga_id)
            ->get();
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }
}
