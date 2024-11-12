<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenderIssue extends Model
{
    use HasFactory;

    protected $fillable = ['mandate_year', 'gender_issue_mandate', 'is_active_gender_issue'];
}
