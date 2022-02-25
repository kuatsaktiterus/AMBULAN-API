<?php

namespace App\Http\Controllers\Api\ApiAuth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Driver\DriverController;
use App\Http\Controllers\User\UserController;
use App\Http\Requests\DriverRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthControllerApi extends Controller
{
    private $authResServ;
    private $user;

    public function __construct()
    {
        $this->user = new UserController;
        $this->authResServ = new AuthResponseService;
    }

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

        try {
            $user = User::where('phone_number', $request['phone_number'])->firstOrFail();
        } catch (\Throwable $th) {
            throw $th;
        }
        
        $token = ($user['role'] == 'customer') ? $user->createToken('auth_token', ['customer'])->plainTextToken : $user->createToken('auth_token', ['driver'])->plainTextToken;

        return $this->respon('success', 'Login Successfully', null , $this->authResServ->loginResponse($token, $user), 200);
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
    public function register(RegisterRequest $registerReq, DriverRequest $driverReq)
    {
        $registerReq = $registerReq->validated();
        if ($registerReq['user_role'] == 'driver') {$driverReq = $driverReq->validated();}

        try {
            $user = $this->user->store($registerReq);
            $driverReq = [
                'id'                    => $user['id'], 
                'vehicle_name'          => $driverReq['vehicle_name'], 
                'registration_number'   => $driverReq['registration_number'],
            ];

            $token = ($user['role'] == 'customer') ? $user->createToken('auth_token', ['customer'])->plainTextToken 
            : $user->createToken('auth_token', ['driver'])->plainTextToken;

            ($registerReq['user_role'] == 'driver') ? (new DriverController)->store($driverReq) : (new CustomerController)->store($user);
        } catch (\Throwable $th) {
            if(isset($user)){$this->user->destroy($user);}
            return $this->respon('error', 'error', $th->getMessage(), null , 500); 
        }
        
        return $this->respon('success', 'Register Successfully', null , $this->authResServ->loginResponse($token, $user), 201);
    }
}
