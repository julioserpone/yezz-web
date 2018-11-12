<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Product extends Model
{
    use SoftDeletes;
 
    protected $table = 'products';
    protected $dates = ['deleted_at'];
    protected $hidden  = ['created_at','updated_at', 'operating_system_id', 'active'];
    protected $fillable = array('line','model','model_id','active','sales_guide_es','sales_guide_en','operating_system_id','ext_id','category_id','top','created_by','updated_by');
                                
    public function manuals()
    {
        return $this->hasMany(ProductManual::class);
    }

    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

    public function specs()
    {
        return $this->hasOne(Specification::class);
    }

    public function scopeShow($query)
    {
        return $query->orderBy('top','desc')->take(4);
    }


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





    public function scopeGetProduct($ext_id)
    {
        return Product::withTrashed()
                           ->selectRaw('ext_id,products.line ,products.model, case when products.deleted_at is null then 0 else 1 end deleted
                                       ,operating_systems.code osCode, operating_systems.name osName')
                           ->join('operating_systems','operating_system_id','=','operating_systems.id')
                           ->where('ext_id',$ext_id)
                           ->first();
    }


    
    public function scopeProductSpecs($query, $ext_id)
    {
        return  $query->selectRaw('products.ext_id, products.model, products.model_id, specifications.name , products.line,
                                   dimensions, weight, chipset, cpu, gpu, simCard,simQty ,gsm_bands, threeg_speed,threeg_bands,fourg_speed,fourg_bands, displayType, displaySize, resolution, multitouch, primary_camera, secundary_camera, 
                                    videoRecording, primary_camera_features, microSDCS, internalMemory, ram, wlan, bluetooth, gps, usb, batteryType, 
                                   batteryCapacity, batteryRemovable, specifications.operating_system')
                           ->leftJoin('operating_systems','operating_system_id','=','operating_systems.id')
                           ->leftJoin('specifications','product_id','=','products.id')
                           ->where('products.ext_id',$ext_id)
                           ->first();
                           
    }


    public function scopeTop($query, $category)
    {

        $serie =  $query
                 ->selectRaw('products.ext_id, line, model, model_id, highlights.text as highlights')
                 ->leftJoin('highlights','product_id','=','products.id')
                 ->join('categories','category_id','=','categories.id')
                 ->whereRaw('top > 0 and (highlights.type_id = 1 or highlights.type_id is null)
                             and (categories.name =\''.$category.'\' )')
                 ->orderBy('top')->take(4)->get();

       return $serie;          
    }

    public function scopeCatalog($query, $serie)
    {
        $serie =  $query
                 ->selectRaw('products.ext_id, line, model, model_id, highlights.text as highlights')
                 ->leftJoin('highlights','product_id','=','products.id')
                 ->whereRaw('(highlights.type_id = 1 or highlights.type_id is null)
                             and (line =\''.$serie.'\' )')
                 ->orderBy('top')->get();

       return $serie;          
    }

    public function scopeDropdownList()
    {

        return Product::selectRaw('concat(categories.name,\' \',model) as name , products.ext_id')
                      ->join('categories','category_id','=','categories.id')
                      ->orderBy('categories.name')
                      ->get()->pluck('name', 'ext_id');
    }

    public function countries()
    {
        return $this->belongsToMany('App\Country','product_countries');
    }
/*
    public function getSpecificationsAttribute()
    {
    	return $this->hasMany('App\Specification')->get();
        
    }*/

    public function getOsAttribute()
    {
    	//return $this->belongsTo('App\OperatingSystem')->first();
        return DB::table('operating_systems')->select('operating_systems.code','operating_systems.name')
                 ->Join('products','products.operating_system_id','=','operating_systems.id')->Where('products.id',$this->id)->first();

    }


}
