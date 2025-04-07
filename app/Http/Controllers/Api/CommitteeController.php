<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommitteeResource;
use App\Models\Committee;
use App\Models\PersonInfo;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year = ($request->year==null) ? date('Y') : $request->year;
        
        $committees = Committee::query()
        ->select('committees.id', 'committees.person_info_id', 'committees.year_covered', 'committees.committee_position_id', 'person_infos.lastname', 'person_infos.firstname', 'person_infos.middlename', 'person_infos.extname', 'person_infos.gender', 'person_infos.birthdate', 'person_infos.age', 'person_infos.height', 'person_infos.weight', 'person_infos.blood_type', 'barangays.barangay_name', 'municipalities.municipality_name', 'provinces.province_name', 'committee_positions.position_title')
        ->join('person_infos', 'person_infos.id', 'committees.person_info_id')
        ->leftJoin('provinces', 'provinces.id', 'person_infos.province_id')
        ->leftJoin('municipalities', 'municipalities.id', 'person_infos.municipality_id')
        ->leftJoin('barangays', 'barangays.id', 'person_infos.barangay_id')
        ->join('committee_positions', 'committee_positions.id', 'committees.committee_position_id')
        ->where('committees.year_covered', $year);

        if($request->employment_status && $request->employment_status != 'all'){
            $committees->where('person_infos.employment_status', $request->employment_status);
        }

        if($request->gender && $request->gender != 'all'){
            $committees->where('person_infos.gender', $request->gender);
        }
 
        return CommitteeResource::collection($committees->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'person_info_id' => ['required'],
            'committee_position_id' => ['required'],
            'year_covered' => ['required'],
        ], [
            'person_info_id.required' => 'The employee field is required.',
            'committee_position_id.required' => 'The position field is required.',
        ]);

        $committee = Committee::create([
            'person_info_id' => $request->person_info_id,
            'year_covered' => $request->year_covered,
            'committee_position_id' => $request->committee_position_id,
        ]);

        return new CommitteeResource($committee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Committee $committee)
    {
        return new CommitteeResource($committee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'person_info_id' => ['required'],
            'committee_position_id' => ['required'],
            'year_covered' => ['required'],
        ], [
            'person_info_id.required' => 'The employee field is required.',
            'committee_position_id.required' => 'The position field is required.',
        ]);

        $committee_update = Committee::find($id)->update([
            'person_info_id' => $request->person_info_id,
            'year_covered' => $request->year_covered,
            'committee_position_id' => $request->committee_position_id,
        ]);

        $committee = Committee::find($id);

        return new CommitteeResource($committee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Committee $committee)
    {
        // $committee = Committee::find($id)->delete();
        $committee->delete();
 
        return response()->noContent();
    }
    
    public function yearlist()
    {
        $years = [];
        for ($i=date('Y') + 3; $i >= 2018 ; $i--) { 
            $years[] = ['year'=>$i];
        }
        return  response()->json($years);
    }

    public function summary(Request $request){
        return (object)[
            "total_employees" => Committee::query()->where('year_covered', $request->year)->count(),
            "total_cos" => Committee::query()->where('year_covered', $request->year)->leftJoin('person_infos', 'person_infos.id', 'committees.person_info_id')->where('person_infos.employment_type', 'cos')->count(),
            "total_permanents" => Committee::query()->where('year_covered', $request->year)->leftJoin('person_infos', 'person_infos.id', 'committees.person_info_id')->where('person_infos.employment_type', 'permanent')->count(),
            "total_males" => Committee::query()->where('year_covered', $request->year)->leftJoin('person_infos', 'person_infos.id', 'committees.person_info_id')->where('person_infos.gender', 'male')->count(),
            "total_females" => Committee::query()->where('year_covered', $request->year)->leftJoin('person_infos', 'person_infos.id', 'committees.person_info_id')->where('person_infos.gender', 'female')->count(),
            "total_lgbtqiaplus" => Committee::query()->where('year_covered', $request->year)->leftJoin('person_infos', 'person_infos.id', 'committees.person_info_id')->where('person_infos.gender', 'lgbtqia+')->count(),
        ];
    }
}
