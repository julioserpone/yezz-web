<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class YtCategory extends Model
{
   use SoftDeletes;
   protected $dates    = ['deleted_at'];
    
   protected $hidden   = ['id', 'created_at','updated_at', 'yt_categorystatuses_id', 'language_id'];
   protected $fillable = array('yt_categorystatuses_id','language_id','ext_id', 'name','active');

   
   public function scopeDropdownList()
   {
       return YtCategory::pluck('name', 'ext_id as id');
   } 

}
