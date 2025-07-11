<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\PersonInfo;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::where('usertype','<>',1)->with('office', 'roles.office')->get());
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
            'is_active' => 1
        ]);

        PersonInfo::find($request->person_info_id)->update(['user_id' => $user->id]);

        // $user = User::create($request->validated());

        return new UserResource($user);
    }

    public function storeAdmin(Request $request)
    {
        Gate::authorize('createAdmin', Role::class);
        
        $request->validate([
            'first_name' => ['required', 'string', 'max:150'],
            'last_name' => ['required', 'string', 'max:150'],
            'middle_name' => ['required', 'string', 'max:150'],
            'gender' => ['required', Rule::in(['male', 'female', 'lgbtqia+'])],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'office_id' => ['required', 'exists:offices,id'],
            'password' => ['required'],
        ],
        [],
        [
            'office_id' => 'office'
        ]);

        return DB::transaction(function () use ($request) {
            $name = $request->last_name.', '.$request->first_name.' '.$request->middle_name;    
            $user = User::create([
                'name' => $name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'usertype' => $request->usertype,
                'is_active' => 1,
                'usertype' => 3,
                'office_id' => $request->office_id
            ]);

            $personInfo = PersonInfo::create([
                'user_id' => $user->id,
                'lastname' => $request->last_name,
                'firstname' => $request->first_name,
                'middlename' => $request->middle_name,
                'gender' => $request->gender,
                'person_type' => 1,
                'office_id' => $request->office_id
            ]);

            Role::create([
                'user_id' => $user->id,
                'office_id' => $request->office_id,
                'role_type' => 'admin'
            ]);

            return new UserResource($user);
        });
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

    // public function getRoles($id)
    // {
        
    // }
}
