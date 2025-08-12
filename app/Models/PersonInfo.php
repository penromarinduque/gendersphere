<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class PersonInfo extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['user_id', 'lastname', 'firstname', 'middlename', 'extname', 'gender', 'civil_status', 'birthdate', 'age', 'height', 'weight', 'blood_type', 'barangay_id', 'municipality_id', 'province_id', 'address_full', 'education_level', 'contact_no', 'email_add', 'employment_type', 'employment_status', 'position', 'organization', 'person_type', 'office_id'];

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
    public function trainings()    
    {
        // This defines a many-to-many relationship with the Training model
        // using the 'training_user' pivot table.
        // The second parameter specifies the pivot table name.
        // The third parameter specifies the foreign key for the Training model.
        // The fourth parameter specifies the foreign key for the User model.
        // The pivot table is assumed to have 'training_id' and 'user_id' columns
    return $this->belongsToMany(Training::class, 'training_users');
    }
}
