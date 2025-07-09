<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BarangayResource;
use App\Models\Barangay;
use Illuminate\Http\Request;

class BarangayController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BarangayResource::collection(Barangay::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barangays = Barangay::where('municipality_id', $id)->orderBy('barangay_name','ASC')->get();

        return BarangayResource::collection($barangays);
    }

    /**
     * Display the specified resource.
     */
    public function search($name)
    {
        // $barangays = Barangay::where('barangay_name','LIKE', $name)->with(['municipality', 'municipality.province'])->get();

        $barangays = Barangay::with(['municipality.province'])
                ->where('barangay_name', 'LIKE', '%' . $name . '%')
                ->orWhereHas('municipality', function ($q) use ($name) {
                    $q->where('municipality_name', 'LIKE', '%' . $name . '%')
                    ->orWhereHas('province', function ($q) use ($name) {
                        $q->where('province_name', 'LIKE', '%' . $name . '%');
                    });
                })
                ->limit(100)
                ->get();

        return BarangayResource::collection($barangays);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barangay $barangay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barangay $barangay)
    {
        //
    }

    /**
     * Display all barangays without pagination
     */
    public function all()
    {
        return Barangay::query()->with(['municipality'])->get();
    }
}
