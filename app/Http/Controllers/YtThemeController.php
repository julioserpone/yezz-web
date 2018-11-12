<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use App\YtBanreason;
use App\YtCategory;
use App\YtComment;
use App\YtTheme;
use App\User;
use App\YtThemeStatus;
use App\YezztalkLog;
use App\Http\Requests;
use DB;


class YtThemeController extends Controller
{

 public function __construct()
 {
        //$this->middleware('auth', ['except' => ['index']]);
  $this->middleware('auth');
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      try
      {

       $themes = YtTheme::get();

       return $themes;   

     } 
     catch(\Exception $e){

      return response()->json(['error' =>'500', 'message' => $e]);              
    }
  }


  public function view()
  {
   $isEdit     = false;
   $openForm   = false;
   $statuses   = YtThemeStatus::DropdownList();
   $categories = YtCategory::DropdownList();


   $themes = YtTheme::withTrashed()
   ->selectRaw('yt_themes.ext_id, yt_themes.title, yt_themes.content,yt_themes.highlight_one, highlight_two, highlight_three
    ,yt_themes.likes, yt_themes.dislikes
    ,case when yt_themes.deleted_at is null then 0 else 1 end deleted ,CONCAT(yt_themes.createdBy, " ", yt_themes.created_at) createdBy , yt_themes.updatedBy
    ,yt_theme_statuses.ext_id status, yt_theme_statuses.name statusName
    ,yt_categories.ext_id category, yt_categories.name catName
    ,comments.count comments')
   ->join('yt_theme_statuses','yt_theme_statuses_id','=','yt_theme_statuses.id')
   ->join('yt_categories','yt_categories_id','=','yt_categories.id')
   ->leftJoin(DB::raw('(select yt_themes_id ,count(*) count from yt_comments group by yt_themes_id) comments'),
    function($join){
      $join->on('yt_themes.id', '=', 'comments.yt_themes_id');
    } )
   ->get();

   $theme = new YtTheme;

   return view('yezztalk.themes', compact('categories','isEdit','statuses','themes','theme','openForm'));

 }

 public function create(Request $request)
 {
  try 
  {
    $isEdit     = false;
    $openForm   = true;
    $statuses   = YtThemeStatus::DropdownList();
    $categories = YtCategory::DropdownList();
    $themes     = YtTheme::ListAll();
    $theme      = new YtTheme;

    return view('yezztalk.themes', compact('categories','isEdit','statuses','themes','theme','openForm'));

  } catch (Exception $e) {

  }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     try{

      $status_id   = YtThemeStatus::Where('ext_id',$request->get('statuses'))->first()->id;
      $category_id = YtCategory::where('ext_id',$request->get('categories'))->first()->id;    

      $formated_url = $this->formatUrl($request->get('title'));

      $theme = YtTheme::create([
        'yt_theme_statuses_id' => $status_id,
            'ext_id'               => $formated_url,//str_random(20),
            'yt_categories_id'     => $category_id,
            'title'                => $request->get('title'),
            'content'              => $request->get('content'),
            'summary'              => $request->get('summary'),
            'highlight_one'        => $request->get('highlight_one'),
            'highlight_two'        => $request->get('highlight_two'),
            'highlight_three'      => $request->get('highlight_three'),
            'createdBy'            => \Auth::user()->username
            ]);

      if($request->file('image')!=null)
      {

        $imageName = $theme->ext_id . '.' . 
        $request->file('image')->getClientOriginalExtension();

        $request->file('image')->move(
          base_path() . '/public/img/yezztalk/', $imageName
          );
      }

      return redirect()->route('ytthemes.view');  

    } 
    catch(\Exception $e){
      return response()->json(['error' =>'500', 'message' => $e]);              
    }
  }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ext_id)
    {
      try
      {
        $theme = YtTheme::Where('ext_id',$ext_id)->first();

        return $theme;   

      } 
      catch(\Exception $e){

        return response()->json(['error' =>'500', 'message' => $e]);              
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ext_id)
    {
      $isEdit     = false;
      $openForm   = false;
      $statuses   = YtThemeStatus::DropdownList();
      $categories = YtCategory::DropdownList();
      $themes     = YtTheme::ListAll();
      $theme      = $themes->where('ext_id',$ext_id)->first();
      $comments   = YtComment::ListAll($ext_id);
      $reasons    = YtBanreason::lists('reason as name','id');

      return view('yezztalk.theme', compact('categories','isEdit','statuses','themes','theme','openForm','comments','reasons'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ext_id)
    {

           // dd($request);      
      $status = YtThemeStatus::Where('ext_id',$request->get('status'))->first();
      $theme  = YtTheme::Where('ext_id',$ext_id)->first();


      $theme->title                = $request->get('title');
      $theme->content              = $request->get('content');
      $theme->summary              = $request->get('summary');
      $theme->highlight_one        = $request->get('highlight_one');
      $theme->highlight_two        = $request->get('highlight_two');
      $theme->highlight_three      = $request->get('highlight_three');
      $theme->yt_theme_statuses_id = $status->id;
      $theme->active               = $request->get('active');
      $theme->save();


      if($request->file('image')!=null)
      { 
        $imageName = $theme->ext_id . '.' . 
        $request->file('image')->getClientOriginalExtension();

        $request->file('image')->move(
          base_path() . '/public/img/yezztalk/', $imageName
          );

      }
      return redirect()->route('ytthemes.view');              
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ext_id)
    {
      try
      {
        $theme = YtTheme::Where('ext_id',$ext_id)->first();

        if ($theme == null) return response()->json(['error' =>'404']);              
        
        $theme->delete();

        return response()->json(['ext_id' => $theme->ext_id]);

      } 
      catch(\Exception $e){

        return response()->json(['error' =>'500', 'message' => $e]);              
      }
    }

    public function restore($ext_id)
    {
      $theme = YtTheme::withTrashed()->where('ext_id',$ext_id)->first();
      $theme->restore();
      return response()->json(['code' => 200]);
    }

    function formatUrl($string) {
    //Lower case everything
      $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
      $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
      $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
      $string = preg_replace("/[\s_]/", "-", $string);
      return $string;
    }


    public function storeComment(Request $request)
    {
      $user = \Auth::user(); 
      
      $comment = $request->get('comment');
      $parent  = $request->get('parent');
      
      $ext_id  = $request->get('theme');
      $theme   = YtTheme::where('ext_id',$ext_id)->first();

      if($theme==null)
      {
        return redirect('/yezztalk');
      }
      
      $comment = YtComment::create([
        'yt_themes_id' => $theme->id,
        'user_id'      => $user->id,
        'parent_id'    => $parent,
        'ext_id'       => str_random(20),
        'answer'       => $comment,
        'yt_banreasons_id' => 0
        ]);

      return redirect('/yezztalk/theme/'.$ext_id);

    }

    public function postThemeLike($ext_id)
    {
      return $this->ThemeLike($ext_id);
    }
    public function postThemeDislike($ext_id)
    {
      return $this->ThemeDislike($ext_id);
    }

    public function postCommentLike($ext_id){
      return $this->PostLikes($ext_id, 'yt_comments');
    }

    public function postCommentDislike($ext_id){
     return $this->PostDislike($ext_id,'yt_comments');
   }

   function PostLikes($ext_id, $entity)
   {
    try 
    {   
      $obj = null;
      $user = \Auth::user();

      $likes    = YezztalkLog::ByAction($user->id,'likes', $entity, $ext_id);
      $dislikes = YezztalkLog::ByAction($user->id,'dislikes', $entity, $ext_id);
      $firstTime = ($likes->count()==0 && $dislikes->count()==0) ? 1 : 0;

      $allowed = 1;            

      if(!$firstTime)
      {
        $likes    = ($likes->count()>0) ? $likes->first() : null;
        $dislikes = ($dislikes->count()>0) ? $dislikes->first() : null;

        $allowed  = ($likes==null && $dislikes!=null) ?   1 : 0;

        if($likes!=null && $dislikes!=null)
        {
                 //Compares both dates to let the user make a like
          $allowed = ($dislikes->created_at > $likes->created_at) ? 1 : 0;    
        }
      }
      if(!$allowed )
      {
        return response()->json(['code'=> 103, 'data' => 0]);
      }

      if($entity=='yt_themes')
      {
        $obj = YtTheme::where('ext_id',$ext_id)->first();
      }
      if($entity=='yt_comments')
      {
        $obj = YtComment::where('ext_id',$ext_id)->first();
      }

      $obj->likes = $obj->likes + 1;

      if($obj->dislikes>0 && $dislikes->count()>0)
      {
       $obj->dislikes = $obj->dislikes - 1;
     }

     $obj->save();


     $log = YezztalkLog::create([
      'user_id'   => $user->id,
      'action'    => 'likes',
      'entity'    => $entity,
      'ext_id'    => $ext_id
      ]);


     return response()->json(['code'=> 200, 'likes' => $obj->likes, 'dislikes'=>$obj->dislikes]);


   } catch (Exception $e) {
    return response()->json(['code'=> 500, 'data' => $e->message]);
  }
}

public function PostDislike($ext_id,$entity)
{
 try 
 {
  $obj = null;
  $user = \Auth::user();

  $likes    = YezztalkLog::ByAction($user->id,'likes', $entity, $ext_id);
  $dislikes = YezztalkLog::ByAction($user->id,'dislikes', $entity, $ext_id);

  $firstTime = ($likes->count()==0 && $dislikes->count()==0) ? 1 : 0;

  $allowed = 1;            

  if(!$firstTime)
  {
    $likes    = ($likes->count()>0) ? $likes->first() : null;
    $dislikes = ($dislikes->count()>0) ? $dislikes->first() : null;

    $allowed  = ($likes!=null && $dislikes==null) ?   1 : 0;

    if($likes!=null && $dislikes!=null)
    {
                 //Compares both dates to let the user make a dislike
      $allowed = ($likes->created_at > $dislikes->created_at) ? 1 : 0;    
    }
  }
  if(!$allowed )
  {
    return response()->json(['code'=> 103, 'data' => 0]);
  }

  if($entity=='yt_themes')
  {
    $obj = YtTheme::where('ext_id',$ext_id)->first();
  }
  if($entity=='yt_comments')
  {
    $obj = YtComment::where('ext_id',$ext_id)->first();
  }

  $obj->dislikes = $obj->dislikes + 1;

  if($obj->likes>0 && $likes->count()>0)
  {
   $obj->likes = $obj->likes - 1;
 }

 $obj->save();

 $log = YezztalkLog::create([
  'user_id'   => $user->id,
  'action'    => 'dislikes',
  'entity'    => $entity,
  'ext_id'    => $ext_id
  ]);


 return response()->json(['code'=> 200, 'likes' => $obj->likes, 'dislikes'=>$obj->dislikes]);


} catch (Exception $e) {
  return response()->json(['code'=> 500, 'data' => $e->message]);
}
}



public function ThemeLike($ext_id)
{
  try 
  {
    $user = \Auth::user();

    $likes    = YezztalkLog::ByAction($user->id,'likes', 'yt_themes', $ext_id);
    $dislikes = YezztalkLog::ByAction($user->id,'dislikes', 'yt_themes', $ext_id);

    $firstTime = ($likes->count()==0 && $dislikes->count()==0) ? 1 : 0;

    $allowed = 1;            

    if(!$firstTime)
    {
      $likes    = ($likes->count()>0) ? $likes->first() : null;
      $dislikes = ($dislikes->count()>0) ? $dislikes->first() : null;

      $allowed  = ($likes==null && $dislikes!=null) ?   1 : 0;

      if($likes!=null && $dislikes!=null)
      {
                 //Compares both dates to let the user make a like
        $allowed = ($dislikes->created_at > $likes->created_at) ? 1 : 0;    
      }
    }
    if(!$allowed )
    {
      return response()->json(['code'=> 103, 'data' => 0]);
    }

    $theme = YtTheme::where('ext_id',$ext_id)->first();
    $theme->likes = $theme->likes + 1;

    if($theme->dislikes>0 && $dislikes->count())
    {
     $theme->dislikes = $theme->dislikes - 1;
   }

   $theme->save();

   $log = YezztalkLog::create([
    'user_id'   => $user->id,
    'action'    => 'likes',
    'entity'    => 'yt_themes',
    'ext_id'    => $ext_id
    ]);


   return response()->json(['code'=> 200, 'likes' => $theme->likes, 'dislikes'=>$theme->dislikes]);
 } catch (Exception $e) {
  return response()->json(['code'=> 500, 'data' => $e->message]);
}
}

public function ThemeDislike($ext_id)
{
 try 
 {
  $user = \Auth::user();

  $likes    = YezztalkLog::ByAction($user->id,'likes', 'yt_themes', $ext_id);
  $dislikes = YezztalkLog::ByAction($user->id,'dislikes', 'yt_themes', $ext_id);

  $firstTime = ($likes->count()==0 && $dislikes->count()==0) ? 1 : 0;

  $allowed = 1;            

  if(!$firstTime)
  {
    $likes    = ($likes->count()>0) ? $likes->first() : null;
    $dislikes = ($dislikes->count()>0) ? $dislikes->first() : null;

    $allowed  = ($likes!=null && $dislikes==null) ?   1 : 0;

    if($likes!=null && $dislikes!=null)
    {
                 //Compares both dates to let the user make a dislike
      $allowed = ($likes->created_at > $dislikes->created_at) ? 1 : 0;    
    }
  }
  if(!$allowed )
  {
    return response()->json(['code'=> 103, 'data' => 0]);
  }

  $theme = YtTheme::where('ext_id',$ext_id)->first();
  $theme->dislikes = $theme->dislikes + 1;

  if($theme->likes>0 && $likes->count()>0)
  {
   $theme->likes = $theme->likes - 1;
 }

 $theme->save();

 $log = YezztalkLog::create([
  'user_id'   => $user->id,
  'action'    => 'dislikes',
  'entity'    => 'yt_themes',
  'ext_id'    => $ext_id
  ]);


 return response()->json(['code'=> 200, 'likes' => $theme->likes, 'dislikes'=>$theme->dislikes]);
} catch (Exception $e) {
  return response()->json(['code'=> 500, 'data' => $e->message]);
}
}


public function deleteComment($ext_id,Request $request)
{
  try {


    $reason_id = $request->get('reason');

    $comment = YtComment::where('ext_id',$ext_id)->first();

    if($comment==null)
    {
      return response()->json(['code'=> 404 ]);
    }

    $comment->yt_banreasons_id = $reason_id;

    $comment->save();

    $comment->delete();


    return response()->json(['code'=> 200, 'data' => $comment]);
  } catch (Exception $e) {
   return response()->json(['code'=> 500, 'message' => $e->message]);

 }

}

public function restoreComment($ext_id)
{
 try {
  $comment = YtComment::withTrashed()->where('ext_id',$ext_id)->first();

  if($comment==null)
  {
    return response()->json(['code'=> 404 ]);
  }

  $comment->yt_banreasons_id = 0;

  $comment->save();

  $comment->restore();

  return response()->json(['code'=> 200]);
} catch (Exception $e) {
  return response()->json(['code'=> 500, 'message' => $e->message]);

}

}





}
