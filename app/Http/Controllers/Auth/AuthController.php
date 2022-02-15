<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\CreateCustomerService;
use App\Services\CreateDriverService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login.
     * @param  App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $request = $request->validated();
        $credentials = request(['phone_number', 'password']);
        if (!Auth::attempt($credentials)) {
            return $this->respon('success', 'unauthorized', null , null , 401);
        }

        $user = User::where('phone_number', $request['phone_number'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        $respon = [
            'status_code'   => 200,
            'access_token'  => $token,
            'token_type'    => 'Bearer',
            'user_id'       => $user->id,
            'user_name'     => $user->name,
            'user_role'     => $user->role
        ];

        if (($user->role) == 'customer') {
            $respon['status'] = $user->customer->status;
        }

        return $this->respon('success', 'Login Successfully', null , $respon , 200);
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
    public function register(RegisterRequest $registerReq, DriverRequest $driverReq,)
    {
        $createDriverService = new CreateDriverService;
        $createCustomerService = new CreateCustomerService;

        $registerReq = $registerReq->validated();
        $driverReq = $driverReq->validated();

        try {
            $user = User::create([
                'name'          => $registerReq['name'],
                'phone_number'  => $registerReq['phone_number'],
                'password'      => Hash::make($registerReq['password']),
                'role'          => 'customer'
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;
        } catch (\Throwable $th) {
            return $this->respon('error', 'error', $th->getMessage(), null , 500); 
        }

        $createAccount = ($registerReq['user_role'] == 'driver') ? $createDriverService->CreateDriver($user, $driverReq) : $createCustomerService->CreateCustomer($user);
        
        return ($createAccount[0]) ? $this->respon('error', 'error', $createAccount[1]->getMessage(), null , 500)
        : $this->respon('success', 'Register Successfully', null , [
            'status_code'   => 201,
            'access_token'  => $token,
            'token_type'    => 'Bearer',
            'user_id'       => $user->id,
            'user_name'     => $user->name,
            'user_role'     => $user->role
        ] , 201);
    }
}
