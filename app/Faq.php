<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Faq extends Model
{
  //  protected $hidden  = ['id', 'created_at','updated_at', 'language_id', 'active'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ext_id', 'language_id', 'question','answer','priority',
    ];
    public function language() {
    	return $this->belongsTo('App\Language');
    }


    public function scopeListAll($query, $language_code)
    {
    	return Faq::withTrashed()
                   ->join('languages', 'faqs.language_id', '=', 'languages.id')
                   ->select(['ext_id','question', 'answer','priority','languages.code as langCode','languages.name as langName'])
                   ->selectRaw('case when countries.deleted_at is null then 0 else 1 end deleted')
    	           ->Where('languages.code',$language_code)
    	           ->get();

    }


    public function scopeAutocompleteSearch($query, $language_code, $text)
    {
    	return Faq::join('languages', 'faqs.language_id', '=', 'languages.id')
    	           ->Where('faqs.active',1)
    	           ->Where('languages.code',$language_code)
    	           ->WhereRaw('(question like \'%'.$text.'% \' or answer like \'%'.$text.'% \')')
    	           ->get();

    }


    public function scopeShow($query, $language_code)
    {

       return Faq::selectRaw('ext_id, question, answer')
                 ->join('languages', 'faqs.language_id', '=', 'languages.id')
                 ->Where('faqs.active',1)
                 ->Where('languages.code',$language_code)
                 ->get();


      

    }    




}
