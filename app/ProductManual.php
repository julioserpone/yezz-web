<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductManual extends Model {

	protected $table = 'product_manuals';

    protected $fillable = array('product_id','language_id','name');
    
    public function product() {

    	return $this->belongsTo(Product::class);
    }
}
