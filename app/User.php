<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','active','gender','rol_id','created_by','username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function rol() {

        return $this->belongsTo(UserRol::class, 'rol_id');
    }

    public function hasRole($role)
    {
        if (is_array($role)) {
            return in_array($this->rol->ext_id, $role);
        }

        return $this->rol->ext_id == $role;
    }
}
