<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Login.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'phone_number'  => 'required',
            'password'      => 'required',
        ]);

        if ($validate->fails()) {
            return $this->respon('error', 'validation error', $validate->errors(), null , 501);
        } else {
            $credentials = request(['phone_number', 'password']);
            if (!Auth::attempt($credentials)) {
                return $this->respon('success', 'unauthorized', null , null , 401);
            }

            $user = User::where('phone_number', $request['phone_number'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->respon('success', 'Login Successfully', null , [
                'status_code'   => 200,
                'access_token'  => $token,
                'token_type'    => 'Bearer',
                'user_id'       => $user->id,
                'user_name'     => $user->name,
                'user_role'     => $user->role
            ] , 200);
        }
    }

    /**
     * logout
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return $this->respon('success', 'Logout Successfully', null , null , 200);
    }

    /**
     * register
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'phone_number'     => 'required',
            'password'  => 'required',
            'user_role' => ['required', Rule::in('customer', 'driver')],
        ]);

        if ($validate->fails()) {
            return $this->respon('error', 'validation error', $validate->errors(), null , 501);
        } else {
            try {
                $user = User::create([
                    'name'          => $request['name'],
                    'phone_number'  => $request['phone_number'],
                    'password'      => Hash::make($request['password']),
                    'role'          => 'customer'
                ]);
      
                $token = $user->createToken('auth_token')->plainTextToken;
            } catch (\Throwable $th) {
                return $this->respon('error', 'error', $th, null , 500); 
            }

            if ($request['user_role'] == 'driver') {
                try {
                    Driver::create([
                        'vehicle_name'          => $request['vehicle_name'], 
                        'registration_number'   => $request['registration_number'], 
                        'user_id'               => $user->id
                    ]);

                    $user->update(['role' => 'driver']);
                } catch (\Throwable $th) {
                    $user->delete();
                    return $this->respon('error', 'error', $th, null , 500); 
                }
            }

            return $this->respon('success', 'Register Successfully', null , [
                'status_code'   => 201,
                'access_token'  => $token,
                'token_type'    => 'Bearer',
                'user_id'       => $user->id,
                'user_name'     => $user->name,
                'user_role'     => $user->role
            ] , 201);
        }
    }
}
