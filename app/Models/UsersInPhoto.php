<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UsersInPhoto extends Model
{
    public function user()
    {
        return $this->belongsTo(People::class, 'person_id');
    }
}
