<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncoderPermission extends Model
{
    use HasFactory;

    protected $guarded = [];

    const PERMISSION = [
        'PersonInfo' => 'PersonInfo',
        'PlanBudget' => 'PlanBudget',
        'Committee' => 'Committee',
        'FrontlineService' => 'FrontlineService',
        'Training' => 'Training',
    ];

}
