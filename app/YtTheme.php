<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class YtTheme extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $hidden  = ['id', 'created_at','updated_at','deleted_at','yt_theme_statuses_id'];

    protected $fillable = array('ext_id', 'title','content','highlight_one','highlight_two','highlight_three','active','yt_theme_statuses_id','yt_categories_id'
                                ,'likes','dislikes','summary','createdBy','updatedBy');


    protected $table = 'yt_themes';
    
   public function questions()
    {
        return $this->hasMany('App\YtQuestion')->get();
    }



    public function scopeListAll()
    {
          return YtTheme::withTrashed()
                        ->selectRaw('yt_themes.ext_id, yt_themes.title, yt_themes.content,yt_themes.summary ,yt_themes.highlight_one, highlight_two, highlight_three
                                    , yt_themes.likes, yt_themes.dislikes
                                    , case when yt_themes.deleted_at is null then 0 else 1 end deleted ,CONCAT(yt_themes.createdBy, " ", yt_themes.created_at) createdBy , yt_themes.updatedBy
                                    ,yt_theme_statuses.ext_id status, yt_theme_statuses.name statusName
                                    ,yt_categories.ext_id category, yt_categories.name catName
                                    ,COALESCE(comments.count,0) comments')
                        ->join('yt_theme_statuses','yt_theme_statuses_id','=','yt_theme_statuses.id')
                        ->join('yt_categories','yt_categories_id','=','yt_categories.id')
                        ->leftJoin(DB::raw('(select yt_themes_id ,count(*) count from yt_comments group by yt_themes_id) comments'),
                                          function($join){
                                            $join->on('yt_themes.id', '=', 'comments.yt_themes_id');
                                           } )
                        ->get();
    }

    public function scopeGetEntity($query, $ext_id)
    {
        
        return $query->withTrashed()
                        ->selectRaw('yt_themes.ext_id, yt_themes.title, yt_themes.content ,yt_themes.highlight_one, highlight_two, highlight_three
                                    , yt_themes.likes, yt_themes.dislikes
                                    , case when yt_themes.deleted_at is null then 0 else 1 end deleted ,CONCAT(yt_themes.createdBy, " ", yt_themes.created_at) createdBy , yt_themes.updatedBy
                                    ,yt_theme_statuses.ext_id status, yt_theme_statuses.name statusName
                                    ,yt_categories.ext_id category, yt_categories.name catName
                                    ,comments.count comments')
                        ->join('yt_theme_statuses','yt_theme_statuses_id','=','yt_theme_statuses.id')
                        ->join('yt_categories','yt_categories_id','=','yt_categories.id')
                        ->leftJoin(DB::raw('(select yt_themes_id ,count(*) count from yt_comments group by yt_themes_id) comments'),
                                          function($join){
                                            $join->on('yt_themes.id', '=', 'comments.yt_themes_id');
                                           } )
                        ->where('yt_themes.ext_id',$ext_id)
                        ->firs();


    }
    


}
