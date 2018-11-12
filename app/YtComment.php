<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class YtComment extends Model
{
    //

  use SoftDeletes;
  protected $table = 'yt_comments';
  protected $dates = ['deleted_at'];
  protected $appends = array('related');
  protected $fillable = array('ext_id', 'user_id','active', 'yt_themes_id','parent_id','answer','likes','dislikes','yt_banreasons_id');

  


    public function scopeListAll($query,$theme_extId)
    {
      return   $query->withTrashed()
                      ->selectRaw('yt_comments.ext_id, yt_comments.answer comment, yt_comments.created_at, yt_comments.likes, yt_comments.dislikes
                      	          , case when yt_comments.deleted_at is null then 0 else 1 end banned
                      	          ,users.username, users.name, yt_banreasons.reason banreason')
                      ->join('yt_themes','yt_themes_id','=','yt_themes.id')
                      ->join('users','user_id','=','users.id')
                      ->leftjoin('yt_banreasons','yt_banreasons_id','=','yt_banreasons.id')
                      ->where('yt_themes.ext_id',$theme_extId)
                      ->get();
    }

    public function scopeCleanList($query,$theme_extId)
    {
      return   $query->selectRaw('yt_comments.ext_id, yt_comments.answer comment, yt_comments.created_at, yt_comments.likes, yt_comments.dislikes
                                  , case when yt_comments.deleted_at is null then 0 else 1 end banned
                                  ,users.username, users.name')
                      ->join('yt_themes','yt_themes_id','=','yt_themes.id')
                      ->join('users','user_id','=','users.id')
                      ->where('yt_themes.ext_id',$theme_extId)->where('yt_banreasons_id',0)->where('parent_id',0)
                      ->get();
    }


    public function getRelatedAttribute($query)
    {

      $childs = DB::table('yt_comments')
                  ->selectRaw('yt_comments.ext_id, yt_comments.answer comment, yt_comments.created_at, yt_comments.likes,  yt_comments.dislikes
                              , case when yt_comments.deleted_at is null then 0 else 1 end banned
                              ,users.username, users.name')
                   ->join('users','user_id','=','users.id')
                   ->where('yt_comments.parent_id',$this->ext_id)->where('yt_banreasons_id',0)
                   ->get();
      
      return $childs;
    }




   

}
