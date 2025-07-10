<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficeRequest;
use App\Http\Resources\OfficeResource;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        $officeExists = $request->office_type == 'region' ? Office::where([
                'office_type' => $request->office_type,
                'region_id' => $request->office_type == 'region' ? $request->region_id : null
            ])->exists()
            : Office::where([
                'office_type' => $request->office_type,
                'region_id' => $request->office_type == 'region' ? $request->region_id : null,
                'barangay_id' => $request->barangay_id,
                'parent_id' => $request->office_type == 'region' ? null : $request->parent_id,
                'office_name' => $request->office_name
            ])->exists();

        if($officeExists) {
            return response()->json([
                'message' => 'Office already exists'
            ], 409);
        }

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
        if(!$request->id) {
            return response()->json([
                'message' => 'The Office you are trying to update does not exist'
            ], 404);
        }

        $request->validate([
            'id' => ['required', 'exists:offices,id'],
            'office_name' => ['required', 'string', 'max:100'],
            'office_type' => ['required', Rule::in(['region', 'penro', 'cenro'])],
            'region_id' => [
                Rule::requiredIf($request->office_type === 'region'),
                'nullable',
                'exists:regions,id'
            ],
            'barangay_id' => ['required', 'exists:barangays,id'],
            'parent_id' => [
                Rule::requiredIf(in_array($request->office_type, ['penro', 'cenro'])),
                'nullable',
                'exists:offices,id'
            ],
        ], [
            'region_id' => 'region',
            'barangay_id' => 'location',
            'parent_id' => 'parent office'
        ]);

        $officeExists = Office::where('office_type', $request->office_type)
            ->where('office_name', $request->office_name)
            ->where('barangay_id', $request->barangay_id)
            ->when($request->office_type === 'region', function ($query) use ($request) {
                $query->where('region_id', $request->region_id)
                    ->whereNull('parent_id');
            })
            ->when(in_array($request->office_type, ['penro', 'cenro']), function ($query) use ($request) {
                $query->where('parent_id', $request->parent_id)
                    ->whereNull('region_id');
            })
            ->where('id', '!=', $request->id)
            ->exists();


        if ($officeExists) {
            return response()->json(['message' => 'Office already exists'], 409);
        }

        $office = Office::find($request->id);
        if (!$office) {
            return response()->json(['message' => 'Office not found'], 404);
        }

        $office->update([
            'office_name' => $request->office_name,
            'office_type' => $request->office_type,
            'region_id' => $request->office_type === 'region' ? $request->region_id : null,
            'barangay_id' => $request->barangay_id,
            'parent_id' => $request->office_type === 'region' ? null : $request->parent_id,
        ]);

        return response()->json(['message' => 'Office updated successfully'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //
        if(!$id) {
            return response()->json([
                'message' => 'The Office you are trying to delete does not exist'
            ], 404);
        }

        $office = Office::find($id);

        if(!$office) {
            return response()->json([
                'message' => 'The Office you are trying to delete does not exist'
            ], 404);
        };
        
        $office->delete();

        return response()->json([
            'message' => 'Office deleted successfully'
        ], 200);
    }

    public function findById($id)
    {
        $office = Office::with(['region', 'barangay.municipality.province', 'parent'])->find($id);
        return new OfficeResource($office);
    }
}
