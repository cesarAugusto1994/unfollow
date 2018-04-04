<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserMedias extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function images()
    {
        return $this->hasMany(MediaImages::class, 'media_id');
    }

    public function usersInPhoto()
    {
        return $this->hasMany(UsersInPhoto::class, 'media_id');
    }
}
