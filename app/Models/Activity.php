<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['activity_type', 'gad_activity', 'name_title', 'date_conducted', 'place_conducted', 'resource_speakers', 'remarks', 'gad_budget_allotment', 'gad_allocated', 'gad_remaining_budget'];
}
