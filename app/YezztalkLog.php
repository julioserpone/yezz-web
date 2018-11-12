<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class YezztalkLog extends Model
{
    //
  
  protected $fillable = array('user_id','entity','ext_id','action'); 


  public function scopeByAction($query,$user_id, $action, $entity,$ext_id)
  {
  	return $query
  	         ->where('user_id', $user_id)
  	         ->where('action', $action)
  	         ->where('entity', $entity)
  	         ->where('ext_id', $ext_id)
             ->orderBy('created_at','desc')
  	         ->get();

  }



  public function scopeWriteLog($user_id, $action, $entity,$ext_id)
  {

  	 $log = YezztalkLog::create([
  		                        'user_id'   => $user_id,
							  	'action'    => $action,
							  	'entity'    => $entity,
							  	'ext_id'    => $ext_id
							    ]);
  	return $log;

  }


}
