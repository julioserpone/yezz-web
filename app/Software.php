<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Software extends Model implements HasMedia
{
    use HasMediaTrait, SoftDeletes;

    protected $fillable = ['product_id', 'system_operatives_id', 'information', 'part_number', 'hardware_version'];

	public function product() {

		return $this->belongsTo(Product::class);
	}

	public function system_operative() {

		return $this->belongsTo(SystemOperative::class, 'system_operatives_id');
	}
}
