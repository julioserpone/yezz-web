<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRol extends Model
{
 	protected $table = 'user_rols';
 	protected $fillable = array('ext_id','name','active');

}
