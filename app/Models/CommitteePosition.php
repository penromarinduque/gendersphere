<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteePosition extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'position_title', 'is_active_position'];
}
