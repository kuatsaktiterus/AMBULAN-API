<?php
namespace App\Services;

use App\Models\User;

class UpdateStatusUserService {

    public function updateStatusUserTrue($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update(['is_ordered' => true]);
        } catch (\Throwable $th) {
            return $th;
        }
        return $user;
    }
}