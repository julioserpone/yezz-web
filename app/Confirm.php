<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confirm extends Model
{
   protected $fillable = array('email','token');
}
