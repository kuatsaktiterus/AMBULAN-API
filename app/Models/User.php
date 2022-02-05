<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone_number',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function PersonalAccessTokens()
    {
        return $this->hasMany('App\Models\PersonalAccessTokens', 'tokenable_id');
    }

    public function Customer()
    {
        return $this->hasOne('App\Models\Customer', 'customer_id');
    }

    public function Driver()
    {
        return $this->hasOne('App\Models\Driver', 'user_id');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) { // before delete() method call this
            $user->PersonalAccessTokens()->delete(); 
            $user->Driver()->delete(); 
            $user->Customer()->delete(); 
        });
    }
}
