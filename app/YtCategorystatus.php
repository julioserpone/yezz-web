<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YtCategorystatus extends Model
{
    
   public function scopeDropdownList()
   {
       return YtCategorystatus::pluck('name', 'ext_id as id');
   } 
}
