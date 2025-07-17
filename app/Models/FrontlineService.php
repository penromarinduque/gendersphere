<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontlineService extends Model
{
    use HasFactory;

    protected $fillable = ['permit_type_id', 'permit_no', 'client_name', 'gender', 'date_applied', 'date_released', 'barangay_id', 'office_id'];

    public function getFrontlineServicesByPermitType($permit_type_id, $year, $office_id = null)
    {
        $query = $this->select('permit_no', 'client_name', 'gender', 'date_applied', 'date_released', 'barangay_name', 'municipality_name')
            ->join('barangays', 'barangays.id', 'frontline_services.barangay_id')
            ->join('municipalities', 'municipalities.id', 'barangays.municipality_id')
            ->where('frontline_services.permit_type_id', $permit_type_id)
            ->where('date_released', 'LIKE', "%{$year}%");

        if($office_id){
            $query->where('frontline_services.office_id', $office_id);
        }
            
        return $query->get();
    }
}
