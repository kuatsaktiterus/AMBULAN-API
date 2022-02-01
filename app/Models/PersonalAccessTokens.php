<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalAccessTokens extends Model
{
    use HasFactory;

    public $table = 'personal_access_tokens';

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'tokenable_id');
    }
    
}
