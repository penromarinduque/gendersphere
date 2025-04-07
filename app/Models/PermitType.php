<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PermitType extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['frontline_service_type_id', 'permit_type', 'report_heading', 'is_active_ptype'];

    public function getPermitTypes($frontline_service_type_id)
    {
        $permit_types = $this->select('id', 'frontline_service_type_id', 'permit_type', 'report_heading', 'is_active_ptype')
            ->where('frontline_service_type_id', $frontline_service_type_id)
            ->get();
        return $permit_types;
    }

    public function getPermitType($id)
    {
        $permit_type = $this->select('permit_types.id', 'permit_types.frontline_service_type_id', 'permit_types.permit_type', 'permit_types.report_heading', 'permit_types.is_active_ptype', 'frontline_service_types.service')
            ->join('frontline_service_types', 'frontline_service_types.id', 'permit_types.frontline_service_type_id')
            ->where('permit_types.id', $id)
            ->first();
        return $permit_type;
    }

    public function services(){
        return $this->belongsTo(FrontlineService::class, 'id', 'permit_type_id');
    }
}
