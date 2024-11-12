<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GadActivity extends Model
{
    use HasFactory;

    protected $fillable = ['plan_budget_id', 'main_activity'];

    public function activity_details()
    {
        return $this->hasMany(ActivityDetail::class, 'gad_activity_id');
    }
}
