<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontlineServiceType extends Model
{
    use HasFactory;

    protected $fillable = ['service', 'fs_status'];

    public function getFrontlineServiceType($fs_status = 1)
    {
        $frontlineservicetypes = $this->select('id', 'service', 'fs_status')
            ->where('fs_status', $fs_status)
            ->get();
        return $frontlineservicetypes;
    }
}
