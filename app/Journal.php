<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $hidden = array('id');
    protected $fillable = array('ext_id','language_id','position','name','url','image_url','usr_define1','usr_define2');
}
