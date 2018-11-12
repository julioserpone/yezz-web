<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    protected $fillable = array('name','ext_id','country','province','email','phone_number','address','latitude','lomgitude','attention','active');
}
