<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Country;
use App\Language;
use App\Region;

use App\Http\Requests;

class CountryController extends Controller
{
     //use WithoutMiddleware;

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
        $countries = Country::ListAll();
        return $countries;
    }


    public function view()
    {
       $isEdit    = false;
       $openForm  = false; 
       $regions   = Region::where('active',1)->pluck('name', 'code as id');
       $languages = Language::where('active',1)->pluck('name', 'code as id');
       $countries = Country::withTrashed()->selectRaw('countries.code,countries.name, regions.code regionCode, regions.name regionName
                                                      ,languages.code langCode, languages.name langName
                                                      ,case when countries.deleted_at is null then 0 else 1 end deleted')
                           ->join('regions','region_id','=','regions.id')
                           ->join('languages','language_id','=','languages.id')
                           ->get();
        
       $country = new Country;
       return view('countries', compact('regions','country','languages','countries','isEdit','openForm'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $code        = $request->get('code');
       $name        = $request->get('name');
       $active      = $request->get('active');
       $lang_code   = $request->get('language');
       $region_code = $request->get('region');

       try{
          
           $language = Language::Where('code',$lang_code)->first();
           $region   =   Region::Where('code',$region_code)->first();
           
            if($language == null || $region == null) return response()->json(['error' =>'404']);              
            
            $language_id = $language->id;
            $region_id   = $region->id; 


            $country = Country::create(
            ['code'        => $code,
             'language_id' => $language_id,
             'region_id'   => $region_id,
             'name'        => $name
             ]);

            return response()->json(['code' => 200]);
                
        } 
        catch(\Exception $e){
            return response()->json(['code' =>'500', 'message' => $e->errorInfo]);              
        }          
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($name)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
        try{
            
            $name        = $request->get('name');
            $lang_code   = $request->get('language');
            $region_code = $request->get('region');
            
            $language = Language::Where('code',$lang_code)->first();
            $region   =   Region::Where('code',$region_code)->first();
            $country  =  Country::withTrashed()->Where('code',$code)->first();   
            
            if($language == null || $region == null || $country == null) return response()->json(['error' =>'404']);           
            
            $language_id = $language->id;
            $region_id   = $region->id; 
            
            $country->language_id = $language_id;
            $country->region_id   = $region_id;
            $country->name        = $name;
            $country->save();

            return response()->json(['code' => 200]);

        } 
        catch(\Exception $e){
            return response()->json(['code' =>'500', 'message' => $e]);              
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        
      try{
            $country  =  Country::Where('code',$code)->first();   

            $country->delete();
            


        } 
        catch(\Exception $e){

        }

    }

    public function restore($code)
    {
      try{
            
            Country::withTrashed()->Where('code',$code)->restore();

        } 
        catch(\Exception $e){
            //return response()->json(['error' =>'500', 'message' => $e]);              
        }
    }

    public function remove($code)
    {
        try{
            
          
            Country::withTrashed()->Where('code',$code)->forceDelete();
           

            return response()->json(['code' =>'200']);              

        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
        }
    }

}
