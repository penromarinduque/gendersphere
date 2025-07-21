<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncoderPermission extends Model
{
    use HasFactory;

    protected $guarded = [];

    const PERMISSIONS = [
        'PersonInfo',
        'PlanBudget',
        'Committee',
        'FrontlineService'
    ];

}
