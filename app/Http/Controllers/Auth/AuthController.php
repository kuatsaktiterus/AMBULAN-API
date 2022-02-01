<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
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
            'no_hp'     => 'required',
            'password'  => 'required',
        ]);

        if ($validate->fails()) {
            return $this->respon('error', 'validation error', $validate->errors(), null , 501);
        } else {
            $credentials = request(['no_hp', 'password']);
            if (!Auth::attempt($credentials)) {
                return $this->respon('success', 'unauthorized', null , null , 401);
            }

            $user = User::where('no_hp', $request['no_hp'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->respon('success', 'Login Successfully', null , [
                'status_code'   => 200,
                'access_token'  => $token,
                'token_type'    => 'Bearer',
                'user_name'     => $user->nama,
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
            'nama'      => 'required|string|max:255',
            'no_hp'     => 'required',
            'password'  => 'required',
            'user_role' => ['required', Rule::in('customer', 'driver')],
        ]);

        if ($validate->fails()) {
            return $this->respon('error', 'validation error', $validate->errors(), null , 501);
        } else {
            try {
                $user = User::create([
                    'nama'      => $request['nama'],
                    'no_hp'     => $request['no_hp'],
                    'password'  => Hash::make($request['password']),
                    'role'      => 'customer'
                ]);
      
                $token = $user->createToken('auth_token')->plainTextToken;
            } catch (\Throwable $th) {
                return $this->respon('error', 'error', $th, null , 500); 
            }

            if ($request['user_role'] == 'driver') {
                try {
                    Driver::create([
                        'nama_kendaraan'        => $request['nama_kendaraan'], 
                        'no_polisi_kendaraan'   => $request['no_polisi_kendaraan'], 
                        'id_user'               => $user->id
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
                'user_name'     => $user->nama,
                'user_role'     => $user->role
            ] , 201);
        }
    }
}
