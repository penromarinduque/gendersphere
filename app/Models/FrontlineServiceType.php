<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FrontlineServiceType extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['service', 'fs_status'];

    public function getFrontlineServiceType($fs_status = 1)
    {
        $frontlineservicetypes = $this->select('id', 'service', 'fs_status')
            ->where('fs_status', $fs_status)
            ->get();
        return $frontlineservicetypes;
    }

    public function permitTypes(){
        return $this->hasMany(PermitType::class, 'frontline_service_type_id', 'id');
    }
}
