<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermitTypeResource;
use App\Models\FrontlineService;
use App\Models\PermitType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermitTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permittypes = PermitType::select('permit_types.*', 'frontline_service_types.service')
            ->join('frontline_service_types', 'frontline_service_types.id', 'permit_types.frontline_service_type_id')
            ->orderBy('frontline_service_types.service', 'ASC')
            ->get();
        return PermitTypeResource::collection($permittypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'frontline_service_type_id' => ['required'],
            'permit_type' => ['required', 'unique:'.PermitType::class],
        ], [
            'frontline_service_type_id.required' => 'The frontline service type field is required.',
        ]);

        Gate::authorize('create', PermitType::class);

        $permittype = PermitType::create([
            'frontline_service_type_id' => $request->frontline_service_type_id,
            'permit_type' => $request->permit_type,
            'report_heading' => $request->report_heading,
            'is_active_ptype' => 1
        ]);

        return new PermitTypeResource($permittype);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new PermitTypeResource(PermitType::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'frontline_service_type_id' => ['required'],
            'permit_type' => ['required'],
            'is_active_ptype' => ['required'],
        ], [
            'frontline_service_type_id.required' => 'The frontline service type field is required.',
            'is_active_ptype.required' => 'The status field is required.',
        ]);

        $permittype = PermitType::find($id);
        Gate::authorize('update', $permittype);
        $permittype->update([
            'frontline_service_type_id' => $request->frontline_service_type_id,
            'permit_type' => $request->permit_type,
            'report_heading' => $request->report_heading,
            'is_active_ptype' => $request->is_active_ptype
        ]);

        $permittype = PermitType::find($id);

        return new PermitTypeResource($permittype);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $permittype = PermitType::find($id);
        $isUsed = FrontlineService::where('permit_type_id', $permittype->id)->exists();
        if($isUsed) {
            return response()->json(['message' => 'This permit type is used in a frontline service therefore it cannot be deleted.'], 403);
        }
        Gate::authorize('delete', $permittype);
        $permittype->delete();
        
        return response()->noContent();
    }

    public function getPermitTypeByStatus($status)
    {
        $permittypes = PermitType::select('permit_types.*', 'frontline_service_types.service')
            ->join('frontline_service_types', 'frontline_service_types.id', 'permit_types.frontline_service_type_id')
            ->where('permit_types.is_active_ptype', $status)
            ->orderBy('frontline_service_types.service', 'ASC')
            ->get();
        return PermitTypeResource::collection($permittypes);
    }
}
