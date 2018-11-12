<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class YtQuestion extends Model
{
   use SoftDeletes;
   protected $dates   = ['deleted_at'];

   protected $hidden  = ['id', 'user_id','language_id','active','yt_theme_id','questionstatus_id','deleted_at'];

   protected $fillable = array('question','active','user_id','language_id','questionstatus_id','ext_id','yt_theme_id');

   protected $appends = array('answers');
    
   protected $table = 'yt_questions'; 

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




    public function user() {
  		return $this->belongsTo('App\User');
    } 


    public function theme() {
      return $this->belongsTo('App\YtTheme');
    } 


    public function language() {
  		return $this->belongsTo('App\Language');
    }

    public function questionstatus() {
  		return $this->belongsTo('App\YtQuestionstatus');
    }

/*
    public function scopeListAll($query)
    {
    	return $query->With(['questionstatus','user'])
    	             ->Where('yt_questions.active',$this->id)->get();
    }*/
    

     public function getAnswersAttribute()
    {
        return $this->hasMany('App\YtAnswer')->get();
       
    }

}
