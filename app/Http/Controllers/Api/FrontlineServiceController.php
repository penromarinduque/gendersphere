<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FrontlineServiceResource;
use App\Models\FrontlineService;
use Illuminate\Http\Request;

class FrontlineServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $frontlineservices = FrontlineService::select('frontline_services.*', 'permit_types.permit_type', 'frontline_service_types.service', 'municipalities.id as municipality_id', 'municipalities.municipality_name', 'barangays.barangay_name')
        ->join('permit_types', 'permit_types.id', 'frontline_services.permit_type_id')
        ->join('frontline_service_types', 'frontline_service_types.id', 'permit_types.frontline_service_type_id')
        ->join('barangays', 'barangays.id', 'frontline_services.barangay_id')
        ->join('municipalities', 'municipalities.id', 'barangays.municipality_id')
        ->get();
        return FrontlineServiceResource::collection($frontlineservices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'permit_type_id' => ['required'],
            'permit_no' => ['required'],
            'client_name' => ['required'],
            'gender' => ['required'],
            'date_applied' => ['required'],
            'date_released' => ['required'],
            'municipality_id' => ['required'],
            'barangay_id' => ['required'],
        ], [
            'permit_type_id.required' => 'Permit type field is required.',
            'municipality_id.required' => 'Municipality field is required.',
            'barangay_id.required' => 'Barangay field is required.',
        ]);

        $frontlineservice = FrontlineService::create([
            'permit_type_id' => $request->permit_type_id,
            'permit_no' => $request->permit_no,
            'client_name' => $request->client_name,
            'gender' => $request->gender,
            'date_applied' => $request->date_applied,
            'date_released' => $request->date_released,
            'barangay_id' => $request->barangay_id,
        ]);

        return new FrontlineServiceResource($frontlineservice);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $frontlineservice = FrontlineService::select('frontline_services.*', 'permit_types.permit_type', 'frontline_service_types.service', 'municipalities.id as municipality_id', 'municipalities.municipality_name', 'barangays.barangay_name')
            ->join('permit_types', 'permit_types.id', 'frontline_services.permit_type_id')
            ->join('frontline_service_types', 'frontline_service_types.id', 'permit_types.frontline_service_type_id')
            ->join('barangays', 'barangays.id', 'frontline_services.barangay_id')
            ->join('municipalities', 'municipalities.id', 'barangays.municipality_id')
            ->where('frontline_services.id',$id)
            ->first();
        return new FrontlineServiceResource($frontlineservice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'permit_type_id' => ['required'],
            'permit_no' => ['required'],
            'client_name' => ['required'],
            'gender' => ['required'],
            'date_applied' => ['required'],
            'date_released' => ['required'],
            'municipality_id' => ['required'],
            'barangay_id' => ['required'],
        ], [
            'permit_type_id.required' => 'Permit type field is required.',
            'municipality_id.required' => 'Municipality field is required.',
            'barangay_id.required' => 'Barangay field is required.',
        ]);

        $frontlineservice_updated = FrontlineService::find($id)->update([
            'permit_type_id' => $request->permit_type_id,
            'permit_no' => $request->permit_no,
            'client_name' => $request->client_name,
            'gender' => $request->gender,
            'date_applied' => $request->date_applied,
            'date_released' => $request->date_released,
            'barangay_id' => $request->barangay_id,
        ]);

        $frontlineservice = FrontlineService::find($id);

        return new FrontlineServiceResource($frontlineservice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $frontlineservice = FrontlineService::find($id)->delete();
 
        return response()->noContent();
    }
}
