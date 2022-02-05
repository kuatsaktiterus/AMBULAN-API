<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'orderer_id',
        'pick_up_detail',
        'pick_up_latitude',
        'pick_up_longitude',
        'drop_off_detail',
        'drop_off_latitude',
        'drop_off_longitude',
        'status',
    ];

    public function Customer()
    {
        return $this->belongsTo('App\Models\Customer', 'orderer_id');
    }

    public function OrderAcceptedLog()
    {
        return $this->hasOne('App\Models\OrderAcceptedLog', 'order_id');
    }
}
