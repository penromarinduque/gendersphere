<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public function parent()
    {
        return $this->belongsTo(Office::class, 'parent_id');
    }
    
}
