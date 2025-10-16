<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonInfoRequest;
use App\Http\Resources\PersonInfoResource;
use App\Models\User;
use App\Models\PersonInfo;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PersonInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchkey = $request->searchkey;
        $user = auth()->user();
        $office_id = $user->office_id; 
        $personinfo_qry = PersonInfo::select('person_infos.*', 'provinces.province_name', 'municipalities.municipality_name', 'barangays.barangay_name')
            ->join('barangays', 'barangays.id', 'person_infos.barangay_id')
            ->join('municipalities', 'municipalities.id', 'barangays.municipality_id')
            ->join('provinces', 'provinces.id', 'municipalities.province_id')
            ->where('person_type', 1);

        if(!$user?->is_super_admin) {
            $personinfo_qry = PersonInfo::select('person_infos.*', 'provinces.province_name', 'municipalities.municipality_name', 'barangays.barangay_name')
                ->join('barangays', 'barangays.id', 'person_infos.barangay_id')
                ->join('municipalities', 'municipalities.id', 'barangays.municipality_id')
                ->join('provinces', 'provinces.id', 'municipalities.province_id')
                ->where('person_type', 1)
                ->where('person_infos.office_id', $office_id);
        }

        if ($searchkey!="") {
            $personinfo_qry->where(function ($qry) use ($searchkey) {
                $qry->where('lastname','LIKE',"%{$searchkey}%")
                    ->orWhere('firstname','LIKE',"%{$searchkey}%")
                    ->orWhere('birthdate','LIKE',"%{$searchkey}%");
            });
        }
        if($request->gender && $request->gender != 'all'){
            $personinfo_qry->where('person_infos.gender', $request->gender);
        }
        if($request->employment_status && $request->employment_status != 'all'){
            $personinfo_qry->where('person_infos.employment_type', $request->employment_status);
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

        Gate::authorize('create', PersonInfo::class);
        
        $personInfo = PersonInfo::create([
            ...$request->validated(),
            'office_id' => auth()->user()->office_id
        ]);

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
            'employment_status' => ['required', 'in:new,renewed,resigned,terminated,retired'],
            'employment_type' => ['required'],
            'contact_no' => ['nullable', 'max:12'],
            'email_add' => [$email_add_nullable, 'string', 'lowercase', 'email', 'max:150'],
            'position' => [$position_nullable, 'string']
        ]);

        $personinfo = PersonInfo::find($id);
        Gate::authorize('update', $personinfo);
        $personinfo->update([
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
            'employment_status' => $request->employment_status,
            'employment_type' => $request->employment_type,
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

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        $personInfo = PersonInfo::find($id);
        Gate::authorize('delete', $personInfo);
        $personInfo->delete();

        return response()->noContent();
    }

    public function all(Request $request) {
        $user = auth()->user();
        $office_id = $user->office_id; 
        $personinfo_qry = PersonInfo::select('person_infos.*', 'provinces.province_name', 'municipalities.municipality_name', 'barangays.barangay_name')
            ->join('barangays', 'barangays.id', 'person_infos.barangay_id')
            ->join('municipalities', 'municipalities.id', 'barangays.municipality_id')
            ->join('provinces', 'provinces.id', 'municipalities.province_id')
            ->where('person_type', 1);
        
        if(!$user?->is_super_admin) {
            $personinfo_qry = PersonInfo::select('person_infos.*', 'provinces.province_name', 'municipalities.municipality_name', 'barangays.barangay_name')
                ->join('barangays', 'barangays.id', 'person_infos.barangay_id')
                ->join('municipalities', 'municipalities.id', 'barangays.municipality_id')
                ->join('provinces', 'provinces.id', 'municipalities.province_id')
                ->where('person_type', 1)
                ->where('person_infos.office_id', $office_id);
        }
      
        $personinfos = $personinfo_qry->orderBy('person_infos.lastname', 'ASC')
            ->get();
        return PersonInfoResource::collection($personinfos);
    }

    //Total count
    public function summary(Request $request){
        $user = auth()->user();
        $office_id = $user->office_id; 

        $data = [
            'total_employees' => 0,
            "total_cos" => 0,
            "total_permanents" => 0,
            "total_males" => 0,
            "total_females" => 0,
            "total_lgbtqiaplus" => 0
        ];

        if($user?->is_super_admin) {
            $data = [
                'total_employees' => PersonInfo::query()->where("person_type", 1)->count(),
                "total_cos" => PersonInfo::query()->where('employment_type', 'cos')->where("person_type", 1)->count(),
                "total_permanents" => PersonInfo::query()->where('employment_type', 'permanent')->where("person_type", 1)->count(),
                "total_males" => PersonInfo::query()->where('gender', 'male')->where("person_type", 1)->count(),
                "total_females" => PersonInfo::query()->where('gender', 'female')->where("person_type", 1)->count(),
                "total_lgbtqiaplus" => PersonInfo::query()->where('gender', 'lgbtqia+')->where("person_type", 1)->count(),
            ];
        }
        else {
            $data = [
                "total_employees" => PersonInfo::query()->where('office_id', $office_id)->where("person_type", 1)->count(),
                "total_cos" => PersonInfo::query()->where('employment_type', 'cos')->where('office_id', $office_id)->where("person_type", 1)->count(),
                "total_permanents" => PersonInfo::query()->where('employment_type', 'permanent')->where('office_id', $office_id)->where("person_type", 1)->count(),
                "total_males" => PersonInfo::query()->where('gender', 'male')->where('office_id', $office_id)->where("person_type", 1)->count(),
                "total_females" => PersonInfo::query()->where('gender', 'female')->where('office_id', $office_id)->where("person_type", 1)->count(),
                "total_lgbtqiaplus" => PersonInfo::query()->where('gender', 'lgbtqia+')->where('office_id', $office_id)->where("person_type", 1)->count()
            ];
        }

        return (object)$data;
    }

    //
    public function getEmployees(Request $request){
        $user = auth()->user();
        $office_id = $user->office_id; 
        $query = PersonInfo::query()->select('person_infos.*', 'provinces.province_name', 'municipalities.municipality_name', 'barangays.barangay_name')
            ->join('barangays', 'barangays.id', 'person_infos.barangay_id')
            ->join('municipalities', 'municipalities.id', 'barangays.municipality_id')
            ->join('provinces', 'provinces.id', 'municipalities.province_id')
            ->where("person_type", 1);

        if(!$user?->is_super_admin) {
            $query = PersonInfo::query()->select('person_infos.*', 'provinces.province_name', 'municipalities.municipality_name', 'barangays.barangay_name')
                ->join('barangays', 'barangays.id', 'person_infos.barangay_id')
                ->join('municipalities', 'municipalities.id', 'barangays.municipality_id')
                ->join('provinces', 'provinces.id', 'municipalities.province_id')
                ->where("person_type", 1)
                ->where('person_infos.office_id', $office_id);
        }

        if($request->has('employment_type') && $request->employment_type != 'all'){
            $query->where("employment_type", $request->employment_type);
        }

        return $query->get();
    }
    
    //
    public function getChartData(Request $request){
        $user = auth()->user();
        $office_id = $user->office_id;
        $employees_by_gender = PersonInfo::query()->select('gender as name', DB::raw('COUNT(*) as total'))->where('person_type', 1)->groupBy('gender')->get()->toArray();
        $permanent_by_gender = PersonInfo::query()->select('gender as name', DB::raw('COUNT(*) as total'))->where('person_type', 1)->where('employment_type', 'permanent')->groupBy('gender')->get()->toArray();
        $cos_by_gender = PersonInfo::query()->select('gender as name', DB::raw('COUNT(*) as total'))->where('person_type', 1)->where('employment_type', 'cos')->groupBy('gender')->get()->toArray();
        $employees_by_emp_type = PersonInfo::query() ->select('employment_type as name', DB::raw('COUNT(*) as total'))->where('person_type', 1)->groupBy('employment_type')->get()->toArray();
        if(!$user?->is_super_admin) {
            $employees_by_gender = PersonInfo::query()->select('gender as name', DB::raw('COUNT(*) as total'))->where('person_type', 1)->where('office_id', $office_id)->groupBy('gender')->get()->toArray();
            $permanent_by_gender = PersonInfo::query()->select('gender as name', DB::raw('COUNT(*) as total'))->where('person_type', 1)->where('office_id', $office_id)->where('employment_type', 'permanent')->groupBy('gender')->get()->toArray();
            $cos_by_gender = PersonInfo::query()->select('gender as name', DB::raw('COUNT(*) as total'))->where('person_type', 1)->where('office_id', $office_id)->where('employment_type', 'cos')->groupBy('gender')->get()->toArray();
            $employees_by_emp_type = PersonInfo::query() ->select('employment_type as name', DB::raw('COUNT(*) as total'))->where('person_type', 1)->where('office_id', $office_id)->groupBy('employment_type')->get()->toArray();
        }              
        return (object)[
            'employees_by_gender' => $employees_by_gender,
            'employees_by_emp_type' => $employees_by_emp_type,
            'permanent_by_gender' => $permanent_by_gender,
            'cos_by_gender' => $cos_by_gender,
        ];
    }

    public function getEmployeeList()
    {   
        $user = auth()->user();
        $office_id = $user->office_id; 
        $users = PersonInfo::select('id', 'firstname', 'middlename', 'lastname', 'office_id')->where("person_type", 1)->where('office_id', $office_id)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => trim("{$p->firstname} {$p->middlename} {$p->lastname}")
                ];
            });

        return response()->json(['data' => $users]);
    }
}
