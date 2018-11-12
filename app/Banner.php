<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Banner extends Model implements HasMedia
{
    use HasMediaTrait, SoftDeletes;

    protected $fillable = ['language_id', 'product_id', 'url', 'position', 'description'];

	protected $dates = ['deleted_at'];

	public function language() {

		return $this->belongsTo(Language::class);
	}

	public function product() {

		return $this->belongsTo(Product::class);
	}
}
