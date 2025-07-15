<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
    //
    public function user() {
        return UserResource::make(auth()->user());  
    }

    public function canAccess(Request $request) {
        $models = [
            'office' => Office::class,
            'user' => User::class
        ];

        if(!$request->has('action')) {
            return response(['message' => 'No action specified'], 400);
        }

        if(!$request->has('model')) {
            return response(['message' => 'No model specified'], 400);
        }

        $model = $models[$request->model];
        
        if($request->has('id')) {
            $model = $models[$request->model]::find($request->id);
        }

        return Gate::check($request->action, $model);
    }
}
