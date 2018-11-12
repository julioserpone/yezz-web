<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class YtThemeStatus extends Model
{
   use SoftDeletes;
   protected $dates    = ['deleted_at'];

   protected $hidden  = ['id', 'deleted_at','created_at','updated_at'];

   protected $fillable = array('ext_id', 'name');

   public function themes()
    {
        return $this->hasMany('App\YtTheme');
    }

   public function scopeDropdownList()
   {
       return YtThemeStatus::pluck('name', 'ext_id as id');
   } 

}
