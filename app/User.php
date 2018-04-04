<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\{Configurations, UserInformations, UserCounts, UserMedias};

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function configurations()
    {
        return $this->hasOne(Configurations::class);
    }

    public function informations()
    {
        return $this->hasOne(UserInformations::class, 'user_id');
    }

    public function counts()
    {
        return $this->hasOne(UserCounts::class);
    }

    public function medias()
    {
        return $this->hasMany(UserMedias::class);
    }
}
