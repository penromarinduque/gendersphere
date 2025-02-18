<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonInfoRequest;
use App\Http\Resources\PersonInfoResource;
use App\Models\User;
use App\Models\PersonInfo;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;

class PersonInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchkey = $request->searchkey;

        $personinfo_qry = PersonInfo::select('person_infos.*', 'provinces.province_name', 'municipalities.municipality_name', 'barangays.barangay_name')
            ->join('barangays', 'barangays.id', 'person_infos.barangay_id')
            ->join('municipalities', 'municipalities.id', 'barangays.municipality_id')
            ->join('provinces', 'provinces.id', 'municipalities.province_id')
            ->where('person_type',1);
        if ($searchkey!="") {
            $personinfo_qry->where(function ($qry) use ($searchkey) {
                $qry->where('lastname','LIKE',"%{$searchkey}%")
                    ->orWhere('firstname','LIKE',"%{$searchkey}%")
                    ->orWhere('birthdate','LIKE',"%{$searchkey}%");
            });
        }
        $personinfos = $personinfo_qry->orderBy('person_infos.lastname', 'ASC')
            ->paginate(15)
            ->withQueryString();
        // $personinfos->appends(['searchkey' => $searchkey]);
        return PersonInfoResource::collection($personinfos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonInfoRequest $request)
    {
        $personInfo = PersonInfo::create($request->validated());

        $person_info = PersonInfo::find($personInfo->id);
        if (!empty($person_info)) {
            if ($person_info->person_type==1 && $person_info->birthdate!="") {
                $_age = date('Y') - date('Y', strtotime($person_info->birthdate));
                PersonInfo::find($person_info->id)->update(['age'=>$_age]);
            }
        }

        return new PersonInfoResource($personInfo);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // return new PersonInfoResource($personInfo);

        $personInfo = PersonInfo::find($id);
        return new PersonInfoResource($personInfo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cs_nullable = ($request->person_type==1) ? 'required' : 'nullable';
        $birthdate_nullable = ($request->person_type==1) ? 'required' : 'nullable';
        $education_level_nullable = ($request->person_type==1) ? 'required' : 'nullable';
        $email_add_nullable = ($request->person_type==1) ? 'required' : 'nullable';
        $position_nullable = ($request->person_type==1) ? 'required' : 'nullable';
        $civil_status = ($request->person_type==1 && $request->civil_status) ? $request->civil_status : NULL;
        $birthdate = ($request->person_type==1 && $request->birthdate) ? $request->birthdate : NULL;
        $education_level = ($request->person_type==1 && $request->education_level) ? $request->education_level : NULL;
        $email_add = ($request->person_type==1 && $request->email_add) ? $request->email_add : NULL;
        $age = ($request->person_type==2 && $request->age) ? $request->age : 0;
        $bage = ($birthdate!=NULL) ? date('Y') - date('Y', strtotime($birthdate)) : $age;
        $position = ($request->person_type==1 && $request->position) ? $request->position : NULL;
        $organization = ($request->person_type==2 && $request->organization) ? $request->organization : NULL;
        $height = ($request->person_type==1 && $request->height) ? $request->height : 0;
        $weight = ($request->person_type==1 && $request->weight) ? $request->weight : 0;
        $blood_type = ($request->person_type==1 && $request->blood_type) ? $request->blood_type : NULL;
        
        $request->validate([
            'lastname' => ['required', 'string'],
            'firstname' => ['required', 'string'],
            'middlename' => ['required', 'string'],
            'extname' => ['nullable', 'string'],
            'gender' => ['required'],
            'civil_status' => [$cs_nullable],
            'birthdate' => [$birthdate_nullable],
            'province_id' => ['required'],
            'municipality_id' => ['required'],
            'barangay_id' => ['required'],
            'education_level' => [$education_level_nullable],
            'contact_no' => ['nullable', 'max:12'],
            'email_add' => [$email_add_nullable, 'string', 'lowercase', 'email', 'max:150'],
            'position' => [$position_nullable, 'string']
        ]);

        PersonInfo::find($id)->update([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'extname' => $request->extname,
            'gender' => $request->gender,
            'civil_status' => $civil_status,
            'birthdate' => $birthdate,
            'age' => $bage,
            'height' => $height,
            'weight' => $weight,
            'blood_type' => $blood_type,
            'province_id' => $request->province_id,
            'municipality_id' => $request->municipality_id,
            'barangay_id' => $request->barangay_id,
            'education_level' => $education_level,
            'contact_no' => $request->contact_no,
            'email_add' => $email_add,
            'position' => $position,
            'organization' => $organization,
        ]);

        if($request->user_id!=0){
            $name = "na";
            $extname = ($request->extname!=NULL) ? ' '.$request->extname : '';
            $name = $request->lastname.', '.$request->firstname.' '.$request->middlename.''.$extname;
            User::find($request->user_id)->update(['name'=>$name, 'email'=>$request->email_add]);
        }
        $personInfo = PersonInfo::find($id);
        if (!empty($person_info)) {
            if ($request->person_type==1 && $request->birthdate) {
                $_age = date('Y') - date('Y', strtotime($request->birthdate));
                PersonInfo::find($id)->update(['age'=>$_age]);
            }
        }

        return new PersonInfoResource($personInfo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $personInfo = PersonInfo::find($id)->delete();

        return response()->noContent();
    }

    public function all(Request $request) {
        

        $personinfo_qry = PersonInfo::select('person_infos.*', 'provinces.province_name', 'municipalities.municipality_name', 'barangays.barangay_name')
            ->join('barangays', 'barangays.id', 'person_infos.barangay_id')
            ->join('municipalities', 'municipalities.id', 'barangays.municipality_id')
            ->join('provinces', 'provinces.id', 'municipalities.province_id')
            ->where('person_type',1);
      
        $personinfos = $personinfo_qry->orderBy('person_infos.lastname', 'ASC')
            ->get();
        // $personinfos->appends(['searchkey' => $searchkey]);
        return PersonInfoResource::collection($personinfos);
    }
}
