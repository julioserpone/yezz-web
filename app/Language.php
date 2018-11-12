<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
   use SoftDeletes;
   protected $dates    = ['deleted_at'];
   
   protected $hidden   = ['id', 'created_at','updated_at', 'region_id', 'language_id'];
   protected $fillable = array('code', 'name','active');

    

  public function countries() {
  	return $this->hasMany('App\Country');
  }

  public function questions() {
    return $this->hasMany('App\YtQuestion');
  }



  public function scopeListAll($query)
  {
	     $languages = Language::Select(['code','name'])
                            ->where('active',1)
                            ->get();
	     return $languages;
	    
    }


   public function scopeDropdownList()
   {
       return Language::pluck('name', 'code as id');
   } 


   public function scopeExist($query, $code)
   {
      return $query->select(['id','code','name'])->where('code',$code);
   }

   public function scopeConsult($query, $code)
   {
      return $query->selectRaw('code,name')->where('code',$code)->first();
   }
  

}
