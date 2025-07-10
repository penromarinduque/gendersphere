<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\PersonInfo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::where('usertype','<>',1)->with('role')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $_personinfo = new PersonInfo;

        $request->validate([
            'person_info_id' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'usertype' => ['required'],
        ], [
            'person_info_id.required' => 'The personnel field is required.'
        ]);
        $person_info_id = $request->person_info_id;
        $personinfo = PersonInfo::find($person_info_id);

        $name = "na";
        if (!empty($personinfo)) {
            $extname = ($personinfo->extname!=NULL) ? ' '.$personinfo->extname : '';
            $name = $personinfo->lastname.', '.$personinfo->firstname.' '.$personinfo->middlename.$extname;
        }

        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $request->usertype,
            'is_active' => 1,
        ]);

        PersonInfo::find($request->person_info_id)->update(['user_id' => $user->id]);

        // $user = User::create($request->validated());

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $_personinfo = new PersonInfo;

        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => [Rules\Password::defaults()],
            'usertype' => ['required'],
        ]);
        
        $user_data = User::find($id);
        $personinfo = PersonInfo::where('user_id',$id)->first();
        $person_info_id = (!empty($personinfo)) ? $personinfo->id : 0;

        $passw = ($request->password!="") ? Hash::make($request->password) : $user_data->password;

        $name = "na";
        if (!empty($personinfo)) {
            $extname = ($personinfo->extname!=NULL) ? ' '.$personinfo->extname : '';
            $name = $personinfo->lastname.', '.$personinfo->firstname.' '.$personinfo->middlename.$extname;
        }

        $user_update = User::find($id)->update([
            'name' => $name,
            'email' => $request->email,
            'password' => $passw,
            'usertype' => $request->usertype,
            'is_active' => 1,
        ]);

        PersonInfo::find($person_info_id)->update(['email_add' => $request->email]);
        $user = User::find($id);

        // $user->update($request->validated());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent(); 
    }

    public function getAuth()
    {
        return auth()->user();
    }
}
