<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Committee extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['person_info_id', 'year_covered', 'committee_position_id', 'office_id'];

    public function personInfo() {
        return $this->belongsTo(PersonInfo::class, 'person_info_id', 'id');
    }

    public static function yearlist()
    {
        $years = [];
        for ($i=date('Y') + 3; $i >= 2016 ; $i--) { 
            $years[] = ['year'=>$i];
        }
        return $years;
    }

    
}
