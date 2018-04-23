<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    public function aliases()
    {
        return $this->hasMany(Alias::class);
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        $this->aliases()->delete();
        $this->reminders()->delete();

        return parent::delete();
    }
}
