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
        'nama_kendaraan',
        'no_polisi_kendaraan',
        'id_user',
    ];

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}
