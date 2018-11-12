<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ProductCountry extends Model
{
    use SoftDeletes;

    protected $table = 'product_countries';
    protected $dates = ['deleted_at'];
    protected $hidden  = ['created_at','updated_at'];
    protected $fillable = ['ext_id','product_id','country_id'];

    public function product() 
    {
    	return $this->belongsTo(Product::class);
    }

    public function country()
    {
    	return $this->belongsTo(Country::class);
    }
}
