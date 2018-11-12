<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YtQuestionstatus extends Model
{
    protected $hidden  = ['id', 'created_at','updated_at', 'region_id', 'language_id','active'];


    public function questions() {
      return $this->hasMany('App\YtQuestion');
   }
    //
}
