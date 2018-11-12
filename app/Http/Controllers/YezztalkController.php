<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Country;
use App\Language;
use App\YezztalkLog;
use App\YtCategory;
use App\YtCategorystatus;
use App\YtComment;
use App\YtTheme;
use App\YtThemeStatus;
use App\Yezz\Location;
use DB;

class YezztalkController extends Controller
{

  public function yezztalk()
  {
    $code = Location::setLocation();
    return redirect('/yezztalk/'.$code['language']);
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view($langcountry)
    {

      $lang_country = "";
      $code = $this->validateLangCountry($langcountry);

      if($code['language']!="")
      {
        $lang_country = $code['language'];
      }else{
        return redirect('/yezztalk/en-us');
      }
      if($code['country']!="")
      {
        $lang_country = $lang_country.'-'.$code['country'];
      }

      $this->setLang($code['language']);
      $lang = $code['language'];

      $catStatus   = YtCategorystatus::where('ext_id','open')->first();
      $themeStatus = YtThemeStatus::where('ext_id','open')->first();
      
      $themes = YtTheme::selectRaw('yt_themes.ext_id, yt_themes.title, yt_themes.summary summary ,yt_themes.highlight_one
        ,highlight_two, highlight_three
        ,yt_themes.likes, yt_themes.dislikes
        ,yt_themes.createdBy createdBy ,yt_themes.created_at,  yt_themes.updatedBy
        ,coalesce(comments.count,0) comments
        ,yt_categories.name category_name')
      ->join('yt_categories','yt_categories_id','=','yt_categories.id')
      ->join('languages','language_id','=','languages.id')
      ->leftJoin(DB::raw('(select yt_themes_id , count(*) count from yt_comments group by yt_themes_id) comments'),
        function($join){
          $join->on('yt_themes.id', '=', 'comments.yt_themes_id');
        } )
      ->where('yt_categories.yt_categorystatuses_id',$catStatus->id)
      ->where('yt_theme_statuses_id',$themeStatus->id)
      ->where('languages.code',$lang)
      ->orderby('yt_themes.created_at','desc')
      ->get();
      
      
      $categories = YtCategory::selectRaw('yt_categories.ext_id ,yt_categories.name, coalesce(themes.count,0) themes')
      ->join('languages','language_id','=','languages.id')
      ->leftJoin(DB::raw('(select yt_categories_id cat_id,count(*) count 
       from yt_themes 
       where yt_theme_statuses_id ='.$themeStatus->id.' and yt_themes.deleted_at is null
       group by yt_categories_id) themes'),
      function($join){
        $join->on('yt_categories.id', '=', 'themes.cat_id');
      } )
      ->where('yt_categorystatuses_id',$catStatus->id)
      ->where('languages.code',$lang)
      ->get();                
      
      $user = \Auth::user();                

      return view('public.yezztalk.main',compact('themes','user','categories','lang_country','lang')); 
    }


    public function theme($ext_id)
    {
      $langcountry = "es-ve";
      $lang_country = "";
      $code = $this->validateLangCountry($langcountry);

      if($code['language']!="")
      {
        $lang_country = $code['language'];
      }else{
        return redirect('/yezztalk/en-us');
      }
      if($code['country']!="")
      {
        $lang_country = $lang_country.'-'.$code['country'];
      }

      $this->setLang($code['language']);
     
     $catStatus   = YtCategorystatus::where('ext_id','open')->first();
     $themeStatus = YtThemeStatus::where('ext_id','open')->first();
     
     

     $theme = YtTheme::selectRaw('yt_themes.ext_id, yt_themes.title, yt_themes.content,yt_themes.highlight_one, highlight_two, highlight_three
      ,yt_themes.likes, yt_themes.dislikes
      ,yt_themes.createdBy createdBy , yt_themes.created_at, yt_themes.updatedBy
      ,coalesce(comments.count,0) comments
      ,yt_categories.name category_name, yt_categories.ext_id as cat_code')
     ->join('yt_categories','yt_categories_id','=','yt_categories.id')
     ->leftJoin(DB::raw('(select yt_themes_id , count(*) count from yt_comments group by yt_themes_id) comments'),
      function($join){
        $join->on('yt_themes.id', '=', 'comments.yt_themes_id');
      } )
     ->where('yt_themes.ext_id',$ext_id)
     ->where('yt_theme_statuses_id',$themeStatus->id)
     ->first();

     $categories = YtCategory::selectRaw('yt_categories.ext_id ,yt_categories.name, coalesce(themes.count,0) themes')
     ->leftJoin(DB::raw('(select yt_categories_id cat_id, count(*) count 
       from yt_themes 
       where yt_theme_statuses_id ='.$themeStatus->id.'
       group by yt_categories_id) themes'),
     function($join){
      $join->on('yt_categories.id', '=', 'themes.cat_id');
    } )
     ->where('yt_categorystatuses_id',$catStatus->id)->get();        

     
     if($theme==null)
     {
      return redirect()->route('yezztalk');  
    }
    
    $comments = YtComment::CleanList($ext_id);    

    $jcomments = json_encode($comments);

    $user = \Auth::user();

    
    return view('public.yezztalk.theme',compact('theme','comments','user','categories', 'lang_country')); 
  }

  
  



  public function category($ext_id)
  {

   $category = YtCategory::where('ext_id',$ext_id)->first();

   if($category==null)
   {
    return redirect('/yezztalk');
  } 

  $catStatus   = YtCategorystatus::where('ext_id','open')->first();
  $themeStatus = YtThemeStatus::where('ext_id','open')->first();
  
  $themes = YtTheme::selectRaw('yt_themes.ext_id, yt_themes.title, yt_themes.summary summary ,yt_themes.highlight_one
    ,highlight_two, highlight_three
    ,yt_themes.likes, yt_themes.dislikes
    ,yt_themes.createdBy createdBy ,yt_themes.created_at,  yt_themes.updatedBy
    ,coalesce(comments.count,0) comments
    ,yt_categories.name category_name')
  ->join('yt_categories','yt_categories_id','=','yt_categories.id')
  ->leftJoin(DB::raw('(select yt_themes_id , count(*) count from yt_comments group by yt_themes_id) comments'),
    function($join){
      $join->on('yt_themes.id', '=', 'comments.yt_themes_id');
    } )
  ->where('yt_categories.yt_categorystatuses_id',$catStatus->id)
  ->where('yt_theme_statuses_id',$themeStatus->id)
  ->where('yt_categories.ext_id',$ext_id)
  ->orderby('yt_themes.created_at','desc')
  ->get();
  
  
  $categories = YtCategory::selectRaw('yt_categories.ext_id ,yt_categories.name, coalesce(themes.count,0) themes')
  ->leftJoin(DB::raw('(select yt_categories_id cat_id, count(*) count 
   from yt_themes 
   where yt_theme_statuses_id ='.$themeStatus->id.'
   group by yt_categories_id) themes'),
  function($join){
    $join->on('yt_categories.id', '=', 'themes.cat_id');
  } )
  ->where('yt_categorystatuses_id',$catStatus->id)->get();     
  
  $user = \Auth::user();

  $code = Location::setLocation();
  $lang = $code['language'];

  return view('public.yezztalk.category',compact('categories','themes','user','lang')); 

} 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function validateLangCountry($lang_country)
    {
     $params   = explode('-', $lang_country);
     $count    = sizeof($params);

     $code = array();
     $code['language'] = "";
     $code['country']  = "";

     $lang = Language::where('code',$params[0])->first();
     if($lang!=null)
     {
       $code['language'] = $lang->code;
       
     }
     
     if($count>1)
     {
       $country = Country::where('code',$params[1])->first();
       if($country!=null){
         $code['country'] = $country->code;
       }
     } 

     return $code;
   }

   function setLang($lang){
     \App::setlocale($lang);
   }

   

 }
