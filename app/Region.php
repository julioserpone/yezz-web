<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    
    use SoftDeletes;
    protected $dates    = ['deleted_at'];
    protected $hidden   = ['id', 'created_at','updated_at','active','deleted_at'];
    protected $fillable = array('code', 'name','active', 'language_id','region_id','deleted_at');


    public function country() {
     	return $this->hasMany('App\Country');
    }



    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }


    public function scopeListAll($query)
    {
        return Region::withTrashed()->selectRaw('code,name,active,case when deleted_at is null then 0 else 1 end deleted')->get();
    }

    public function scopeCleanList($query)
    {
        return Region::get();
    }
}
