<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAcceptedLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'driver_id',
    ];

    public function Order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function Driver()
    {
        return $this->belongsTo('App\Models\Driver', 'driver_id');
    }
}
