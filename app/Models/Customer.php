<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'status',
    ];

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'customer_id');
    }

    public function Orders()
    {
        return $this->hasMany('App\Models\Customer', 'orderer_id');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($customer) { // before delete() method call this
            $customer->Orders()->delete();
        });
    }
}
