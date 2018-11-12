<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $hidden = array('id','country_id');
    protected $fillable = array('ext_id','country_id','name','address1','address2','email1','email2','phone1','phone2','attention','latitude','longitude');

}
