<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauseGenderIssue extends Model
{
    use HasFactory;

    protected $fillable = ['cause', 'is_active_cause'];
}
