<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Country extends Model
{

    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $hidden  = ['id', 'created_at','updated_at', 'region_id', 'language_id', 'deleted_at'];
    protected $fillable = array('code', 'name','active', 'language_id','region_id','marketing_region');

    
    public function region() 
    {
  		return $this->belongsTo(Region::class);
    }

    public function language() 
    {
    	return $this->belongsTo(Language::class);
    }

    public function scopeListAll($query)
    {
	     $countries = Country::with(['language','region'])->get();
	     return $countries;
	    
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'product_countries');
    }


}
