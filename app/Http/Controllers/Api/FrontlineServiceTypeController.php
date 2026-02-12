<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FrontlineServiceTypeResource;
use App\Models\FrontlineServiceType;
use App\Models\PermitType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FrontlineServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $frontlineservicetypes = FrontlineServiceType::all();
        return FrontlineServiceTypeResource::collection($frontlineservicetypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service' => ['required', 'unique:'.FrontlineServiceType::class],
        ]);

        $frontlineservicetype = FrontlineServiceType::create([
            'service' => $request->service,
            'fs_status' => 1
        ]);

        return new FrontlineServiceTypeResource($frontlineservicetype);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new FrontlineServiceTypeResource(FrontlineServiceType::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'service' => ['required'],
            'fs_status' => ['required'],
        ], [
            'fs_status.required' => 'The status field is required.'
        ]);

        $frontlineservicetype = FrontlineServiceType::find($id);
        Gate::authorize('update', $frontlineservicetype);
        $frontlineservicetype->update([
            'service' => $request->service,
            'fs_status' => $request->fs_status,
        ]);

        $frontlineservicetype = FrontlineServiceType::find($id);

        return new FrontlineServicetypeResource($frontlineservicetype);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $frontlineservicetype = FrontlineServiceType::find($id);
        $isUsed = PermitType::where('frontline_service_type_id', $frontlineservicetype->id)->exists();
        if($isUsed) {
            return response()->json(['message' => 'This frontline service type is used in a permit type therefore it cannot be deleted.'], 403);
        }
        Gate::authorize('delete', $frontlineservicetype);
        $frontlineservicetype->delete();
 
        return response()->noContent();
    }
}
