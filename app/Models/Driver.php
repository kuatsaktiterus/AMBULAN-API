<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vehicle_name',
        'registration_number',
        'user_id',
    ];

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
