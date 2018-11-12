<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\YtCategory;
use App\Language;
use App\YtCategorystatus;
use DB;

class YtCategoryController extends Controller
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
        //
    }


    

    public function view()
    {
        $isEdit     = false;
        $openForm   = false;
        $categories = YtCategory::withTrashed()
                                ->selectRaw('yt_categories.ext_id, yt_categories.name, likes, unlikes
                                    , case when yt_categories.deleted_at is null then 0 else 1 end deleted
                                    , yt_categorystatuses.ext_id status, yt_categorystatuses.name statusName
                                    ,languages.code langCode, languages.name langName
                                    ,coalesce(themes.count, 0) themes')
                                ->join('yt_categorystatuses','yt_categorystatuses_id','=','yt_categorystatuses.id')
                                ->join('languages','language_id','=','languages.id')
                                ->leftJoin(DB::raw('(select yt_categories_id ,count(*) count from yt_themes group by yt_categories_id) themes'),
                                          function($join){
                                            $join->on('yt_categories.id', '=', 'themes.yt_categories_id');
                                           } )
                                ->get();
        $category  = new YtCategory; 
        $languages = Language::DropdownList();
        $statuses  = YtCategorystatus::DropdownList();
         
    
       return view('yezztalk.category', compact('categories','isEdit','languages','statuses','category','openForm'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isEdit = false;
        $openForm = true;
        $category  = new YtCategory; 
        $languages = Language::DropdownList();
        $statuses  = YtCategorystatus::DropdownList();
        $categories = YtCategory::withTrashed()
                                ->selectRaw('yt_categories.ext_id, yt_categories.name, likes, unlikes
                                    , case when yt_categories.deleted_at is null then 0 else 1 end deleted
                                    , yt_categorystatuses.ext_id status, yt_categorystatuses.name statusName
                                    ,languages.code langCode, languages.name langName
                                    ,themes.count')
                                ->join('yt_categorystatuses','yt_categorystatuses_id','=','yt_categorystatuses.id')
                                ->join('languages','language_id','=','languages.id')
                                ->leftJoin(DB::raw('(select yt_categories_id ,count(*) count from yt_themes group by yt_categories_id) themes'),
                                          function($join){
                                            $join->on('yt_categories.id', '=', 'themes.yt_categories_id');
                                           } )
                                ->get();
         
        
       return view('yezztalk.category', compact('categories','isEdit','languages','statuses','category','openForm'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try 
        {
            $language_id = Language::where('code', $request->get('languages'))->first()->id;
            $status_id   = YtCategorystatus::where('ext_id',$request->get('statuses'))->first()->id;

            $formated_extId = $this->formatUrl($request->get('name'));
 
            $category = YtCategory::create([
                        'ext_id'       => $formated_extId,
                        'language_id'  =>$language_id,
                        'yt_categorystatuses_id' =>$status_id,
                        'name'         =>$request->get('name')
                        ]);
              

            return redirect()->route('ytcategories.view');  

        } catch (Exception $e) {
            
        }



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
    public function edit($ext_id)
    {
        $isEdit     = true;
        $openForm   = true;
        $category   = new YtCategory; 
        $languages  = Language::DropdownList();
        $statuses   = YtCategorystatus::DropdownList();
        $categories = YtCategory::withTrashed()
                                ->selectRaw('yt_categories.ext_id, yt_categories.name, likes, unlikes
                                    , case when yt_categories.deleted_at is null then 0 else 1 end deleted
                                    , yt_categorystatuses.ext_id status, yt_categorystatuses.name statusName
                                    ,languages.code langCode, languages.name langName
                                    ,themes.count')
                                ->join('yt_categorystatuses','yt_categorystatuses_id','=','yt_categorystatuses.id')
                                ->join('languages','language_id','=','languages.id')
                                ->leftJoin(DB::raw('(select yt_categories_id ,count(*) count from yt_themes group by yt_categories_id) themes'),
                                          function($join){
                                            $join->on('yt_categories.id', '=', 'themes.yt_categories_id');
                                           } )
                                ->get();
         $category = YtCategory::withTrashed()
                                ->selectRaw('yt_categories.ext_id, yt_categories.name, likes, unlikes
                                    , case when yt_categories.deleted_at is null then 0 else 1 end deleted
                                    , yt_categorystatuses.ext_id status, yt_categorystatuses.name statusName
                                    ,languages.code langCode, languages.name langName')
                                ->join('yt_categorystatuses','yt_categorystatuses_id','=','yt_categorystatuses.id')
                                ->join('languages','language_id','=','languages.id')
                                ->Where('yt_categories.ext_id',$ext_id)->first();
                
       return view('yezztalk.category', compact('categories','isEdit','languages','statuses','category','openForm'));
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
        try {
              $language_id = Language::where('code', $request->get('languages'))->first()->id;
              $status_id   = YtCategorystatus::where('ext_id',$request->get('statuses'))->first()->id;
              $category = YtCategory::withTrashed()->Where('yt_categories.ext_id',$ext_id)->first();


              $category->yt_categorystatuses_id = $status_id;
              $category->language_id            = $language_id; 
              $category->name                   = $request->get('name');
              $category->save();

              return redirect()->route('ytcategories.view');  

  
        } catch (Exception $e) {
            
        }

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
            $category = YtCategory::withTrashed()->Where('ext_id',$ext_id)->first();

            $category->delete();
                
            return redirect()->route('ytcategories.view');  

        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
        }
    }

      public function remove($ext_id)
    {
        try{
          
             YtCategory::withTrashed()->Where('ext_id',$ext_id)->forceDelete();

            return redirect()->route('ytcategories.view');  

        } 
        catch(\Exception $e){
            
            return response()->json(['code' =>500 ,'message'=> $e]);              
        }
    }


    public function restore($ext_id)
    {
      try{
            
             YtCategory::withTrashed()->Where('ext_id',$ext_id)->restore();


        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
        }
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
}
