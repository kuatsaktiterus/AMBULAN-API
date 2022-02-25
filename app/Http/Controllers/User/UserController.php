<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created User.
     *
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        try {
            $user = User::create([
                'name'          => $request['name'],
                'phone_number'  => $request['phone_number'],
                'password'      => Hash::make($request['password']),
                'role'          => $request['user_role'],
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $user;
    }

    /**
     * Get the specified user.
     *
     * @return \Illuminate\Http\Response
     */
    public function Get($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        try {
            $user->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
