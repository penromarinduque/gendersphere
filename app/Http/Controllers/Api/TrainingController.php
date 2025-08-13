<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingRequest;
use App\Http\Resources\TrainingResource;

use App\Models\Training;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchkey = $request->searchkey;
        $user = auth()->user();
        $office_id = $user->office_id; 
       

        if($user?->is_super_admin) {
            $training_qry = Training::select('trainings.*');
        } 
        else {
            $training_qry = Training::select('trainings.*')
                ->where('trainings.office_id', $office_id);
        }
        if ($searchkey!="") {
            $training_qry->where(function ($qry) use ($searchkey) {
                $qry->where('training_title','LIKE',"%{$searchkey}%")
                    ->orWhere('learning_description_type','LIKE',"%{$searchkey}%")
                    ->orWhere('training_start','LIKE',"%{$searchkey}%");
            });
        }
        if($request->learning_description_type && $request->learning_description_type != 'all'){
            $training_qry->where('learning_description_type', $request->learning_description_type);
        }


        $trainings = $training_qry->orderBy('training_start', 'ASC')
            ->paginate(15)
            ->withQueryString();
        // $trainings->appends(['searchkey' => $searchkey]);
        return TrainingResource::collection($trainings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrainingRequest $request)
    {
        $training = Training::create($request->validated());
        $training = Training::find($training->id);

/*         if ($training->training_start && $training->training_end) {
            $training->duration_hours = Carbon::parse($training->training_start)
                ->floatDiffInHours(Carbon::parse($training->training_end));
        } */

        return new TrainingResource($training);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // return new PersonInfoResource($personInfo);

        $training = Training::find($id);
        return new TrainingResource($training);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $training_title = ($request->training_title) ? $request->training_title : NULL;
        $training_start = ($request->training_start) ? $request->training_start : NULL;
        $training_end = ($request->training_end) ? $request->training_end : NULL;
        $duration_hours = ($request->duration_hours) ? $request->duration_hours : NULL;
        $learning_description_type = ($request->learning_description_type) ? $request->learning_description_type : NULL;
        $sponsor_facilitator = ($request->sponsor_facilitator) ? $request->sponsor_facilitator : NULL;

        $request->validate([
            'training_title' => ['required', 'string'],
            'training_start' => ['required', 'date'],
            'training_end' => ['required', 'date'],
            'duration_hours' => ['required', 'numeric'],
            'learning_description_type' => ['required', 'string'],
            'sponsor_facilitator' => ['required', 'string'],
        ]);

        Training::find($id)->update([
            'training_title' => $training_title,
            'training_start' => $training_start,
            'training_end' => $training_end,
            'duration_hours' => $duration_hours,
            'learning_description_type' => $learning_description_type,
            'sponsor_facilitator' => $sponsor_facilitator,
        ]);


        $training = Training::find($id);
        return new TrainingResource($training);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $training = Training::find($id)->delete();

        return response()->noContent();
    }

    public function all(Request $request) {
        $user = auth()->user();
        $office_id = $user->office_id; 
        
        if($user?->is_super_admin) {
            $training_qry = Training::select('*');
        } 
        else {
            $training_qry = Training::select('trainings.*')
                ->where('trainings.office_id', $office_id);
        }

        $trainings = $training_qry->orderBy('training_title', 'ASC')
            ->get();
        // $personinfos->appends(['searchkey' => $searchkey]);
        return TrainingResource::collection($trainings);
    }

    public function summary(Request $request){
        $user = auth()->user();
        $office_id = $user->office_id; 

        if($user?->is_super_admin) {
            $total_trainings = Training::query()->count();
            $total_managerial = Training::query()->where('learning_description_type', 'managerial')->count();
            $total_supervisory = Training::query()->where('learning_description_type', 'supervisory')->count();
            $total_technical = Training::query()->where('learning_description_type', 'technical')->count();
        }
        else {
            $total_trainings = Training::query()->where('office_id', $office_id)->count();
            $total_managerial = Training::query()->where('learning_description_type', 'managerial')->where('office_id', $office_id)->count();
            $total_supervisory = Training::query()->where('learning_description_type', 'supervisory')->where('office_id', $office_id)->count();
            $total_technical = Training::query()->where('learning_description_type', 'technical')->where('office_id', $office_id)->count();

        }
        return response()->json([
            "total_trainings" => $total_trainings,
            "total_managerial" => $total_managerial,
            "total_supervisory" => $total_supervisory,
            "total_technical" => $total_technical,
        ]);
    }

 /*    public function getEmployees(Request $request){
        $user = auth()->user();
        $office_id = $user->office_id; 

        if($user?->is_super_admin) {
            $query = PersonInfo::query()->select('person_infos.*', 'provinces.province_name', 'municipalities.municipality_name', 'barangays.barangay_name')
                ->join('barangays', 'barangays.id', 'person_infos.barangay_id')
                ->join('municipalities', 'municipalities.id', 'barangays.municipality_id')
                ->join('provinces', 'provinces.id', 'municipalities.province_id')
                ->where("person_type", 1);
        } 
        else {
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
    } */

}
