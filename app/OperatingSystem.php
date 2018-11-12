<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperatingSystem extends Model
{
    protected $hidden  = ['id', 'created_at','updated_at', 'active'];

    
    public function product() 
    {
     	return $this->hasMany('App\Product');
    }



}
