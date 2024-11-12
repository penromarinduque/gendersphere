<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class PersonInfo extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'lastname', 'firstname', 'middlename', 'extname', 'gender', 'civil_status', 'birthdate', 'age', 'height', 'weight', 'blood_type', 'barangay_id', 'municipality_id', 'province_id', 'address_full', 'education_level', 'contact_no', 'email_add', 'employment_type', 'position', 'organization', 'person_type'];

    public function educationalLevel($lvl = null)
    {
        $arr_el = [
            'elementary' => 'Elementary',
            'secondary' => 'Secondary',
            'vocational' => 'Vocational/Trade Course',
            'college' => 'College',
            'graduate_studies' => 'Graduate Studies',
        ];
    }
}
