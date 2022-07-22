<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //start transaction
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->delete();
            DB::commit();
            //end transaction
            return to_route('users.index')->with('success', 'User '.$user->name.' deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return to_route('users.index')->with('error', 'Error deleting user. '.$th->getMessage());
        }
    }

    /*
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            return Inertia::render('User/Edit', [
                'user' => $user
            ]);
        } catch (\Throwable $th) {
            return to_route('users.index')->with('error', 'Error creating user. '.$th->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('User/Index', [
            'users' => User::where('id','!=',auth()->user()->id)
                ->when($request->q, function($query, $q){
                    $query->where('name', 'LIKE', "%".$q."%");
                    $query->Orwhere('email', 'LIKE', "%".$q."%");
                })->orderBy('id', 'desc')->paginate(10)
        ]);
    }

    /**
     * Display a listing of user request data.
     */
    public function search(Request $request)
    {
        $users = User::where('name', 'like', '%' . $request->q . '%')->paginate(10);
        return response()->json($users);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //check form validation rule
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        //start transaction
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $attributes = new User($data);
            $attributes->save();

            DB::commit();
            //end transaction
            return to_route('users.index')->with('success', 'User '.$attributes->name.' created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return to_route('users.index')->with('error', 'Error creating user. '.$th->getMessage());
        }
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //check form validation rule
        $this->validate($request, [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => 'unique:users,email,'.$id,
            'password'              => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'sometimes|required_with:password|same:password',
        ]);

        //start transaction
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
                $user->update([
                    'name'      => $request->name,
                    'email'     => $request->email,
                    'password'  => Hash::make($request->password),
                ]);
            DB::commit();
            //end transaction
            return to_route('users.index')->with('success', 'User '.$user->name.' updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return to_route('users.index')->with('error', 'Error updating user. '.$th->getMessage());
        }
    }
}
