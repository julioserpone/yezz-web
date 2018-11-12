<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Highlight extends Model
{
    

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $hidden  = ['id','created_at','updated_at', 'product_id'];

    protected $fillable = array('language_id','text','product_id','ext_id','type_id');

    protected $table = 'highlights';


/*
    public function scopeListAll($product_id){
    	return = Highlight::withTrashed()
                                ->selectRaw('highlights.ext_id, highlights.text,languages.code langCode, languages.name langName
                                            , case when highlights.deleted_at is null then 0 else 1 end deleted')
                                ->where('product_id',$product_id)
                                ->join('languages','language_id','=','languages.id')
                                ->get();
    }*/

}
