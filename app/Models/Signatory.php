<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signatory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function committeePosition()
    {
        return $this->belongsTo(CommitteePosition::class, 'signatory', 'id');
    }
}
