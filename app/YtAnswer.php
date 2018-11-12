<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class YtAnswer extends Model
{
   use SoftDeletes;
   protected $dates    = ['deleted_at'];


   protected $fillable = array('yt_question_id','active','user_id','answer','parent_id','ext_id','positive','negative');
    
   protected $hidden  = ['id', 'user_id','active','yt_question_id','parent_id','deleted_at'];

   protected $table = 'yt_answers';

   protected $appends = array('user');

   public function toArray()
    {
        $array = parent::toArray();
        foreach ($this->getMutatedAttributes() as $key)
        {
            if ( ! array_key_exists($key, $array)) {
                $array[$key] = $this->{$key};   
            }
        }
        return $array;
    }


   



   public function question() 
   {
  		return $this->belongsTo('App\YtQuestion');
   }

   
    

   public function getUserAttribute()
    {
        
        return DB::table('users')
                 ->Select('username')
                 ->Join('yt_answers','yt_answers.user_id','=','users.id')
                 ->first();
        
    }

    


}
