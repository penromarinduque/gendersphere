<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficeRequest;
use App\Http\Resources\OfficeResource;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     * Note: Pagination is not yet implemented since the number of offices is minimal
     */
    public function index(Request $request)
    {
        //
        $offices  = Office::query()->with('region', 'barangay.municipality.province', 'parent')->get();

        return OfficeResource::collection($offices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OfficeRequest $request)
    {
        //
        Office::create([
            'office_type' => $request->office_type,
            'region_id' => $request->office_type == 'region' ? $request->region_id : null,
            'barangay_id' => $request->barangay_id,
            'parent_id' => $request->office_type == 'region' ? null : $request->parent_id,
            'office_name' => $request->office_name
        ]);

        return response()->json([
            'message' => 'Office created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        //
    }

    public function findById($id)
    {
        $office = Office::with(['region', 'barangay.municipality.province', 'parent'])->find($id);
        return new OfficeResource($office);
    }
}
