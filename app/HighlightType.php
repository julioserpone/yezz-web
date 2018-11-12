<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HighlightType extends Model
{
    //
    protected $hidden  = ['id'];


  public function scopeDropdownList()
    {
        return HighlightType::pluck('name', 'code as id');

    }

}
