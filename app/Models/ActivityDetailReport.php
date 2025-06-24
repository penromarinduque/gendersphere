<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityDetailReport extends Model
{
    use HasFactory;

    protected $table = 'activity_detail_reports';

    protected $guarded = [];

    public function activityDetail()
    {
        return $this->belongsTo(ActivityDetail::class);
    }
}
