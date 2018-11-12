<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
	use HasTranslations, SoftDeletes;
    
    public $translatable = ['description'];

    protected $fillable = ['ext_id', 'name', 'position', 'anchor', 'description'];

    public function products() 
    {
    	return $this->hasMany(Product::class);
    }

    public function catalogs($limit = 4) {

    	return $this->products()->orderBy('top')->limit($limit)->get();
    }
}
