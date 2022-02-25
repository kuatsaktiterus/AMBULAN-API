<?php
namespace App\Services;


class AuthResponseService {
    /**
     * Response of checking order.
     * @return array<int, string>
     *
     */
    public function loginResponse($token, $user)
    {
        return [
            'status_code'   => 201,
            'access_token'  => $token,
            'token_type'    => 'Bearer',
            'user_id'       => $user->id,
            'user_name'     => $user->name,
            'user_role'     => $user->role,
            'is_ordered'    => ((boolval($user->is_ordered)) ? true : false ),
        ];
    }
}