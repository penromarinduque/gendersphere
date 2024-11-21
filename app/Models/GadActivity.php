<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class GadActivity extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['plan_budget_id', 'main_activity'];

    public function activity_details()
    {
        return $this->hasMany(ActivityDetail::class, 'gad_activity_id');
    }
}
