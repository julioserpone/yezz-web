<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Specification extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $hidden  = ['id', 'created_at','updated_at','product_id',  'language_id', 'deleted_at'];

    protected $fillable = array('product_id',
    	                        'language_id',
    							'ext_id',
								'name',
								'dimensions',
                                'operating_system',
								'weight',
								'chipset',
                                'cpu',
								'cpu_cores',
								'gpu',
								'simCard',
								'gsmEdge',
								'simQty',
                                'gsm_bands',
                                'threeg_speed',
                                'threeg_bands',
                                'fourg_speed',
                                'fourg_bands',
								'displayType',
								'displaySize',
								'resolution',
								'multitouch',
								'primary_camera',
                                'secundary_camera',
                                'primary_camera_features',
								'videoRecording',
								'microSDCS',
								'internalMemory',
								'ram',
								'wlan',
								'bluetooth',
								'gps',
								'usb',
								'batteryType',
								'batteryCapacity',
								'batteryRemovable','created_by','updated_by');


    protected $appends = array('language');
                                
    protected $table = 'specifications';

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

     public function products() 
     {
    	return $this->belongsTo('App\Product');
     }


     public function getLanguageAttribute()
     {
     	return DB::table('languages')
     	         ->Select('languages.code','languages.name')
     	         ->Join('specifications','specifications.language_id','=','languages.id')
     	         ->Where('specifications.id',$this->id)
     	         ->first();
     }


}
