<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Region;
use App\Http\Requests;


class RegionController extends Controller
{

      public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $region  = new Region;
       //$regions = Region::lists('name', 'code as id');
       return view('regions', compact('region')); 
       
    }

    public function view(Request $request)
    {
       $region  = new Region;
       $regions = Region::ListAll();
       $isEdit  = false;
       $openEdit  = false;

       return view('regions', compact('region','isEdit','regions','openEdit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $region  = new Region;
       $isEdit  = false;
       $openEdit  = true;
       $regions = Region::ListAll();
       return view('regions', compact('region','isEdit','regions','openEdit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       try{
            $data = $request->all();
            $region = Region::create(
            ['code'        => $data['code'],
             'name'        => $data['name']
             ]);
          
          return redirect()->route('regions.view');
        } 
        catch(\Exception $e){
            //$message = $e->errorInfo != null? $e->errorInfo : $e;
            return response()->json(['error' =>'500', 'message' => $e]);              
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
      try{
           $region =  Region::Select(['code' ,'name'])->Where('code',$code)->first();
           if ($region == null) return response()->json(['error' =>'404']);              
           return $region;
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
    public function edit($code)
    {
        try{
             
            $isEdit  = true;

            $openEdit = true;

            $regions = Region::ListAll();
            
            $region  = $regions->Where('code',$code)->first();
                        
            return view('regions', compact('isEdit', 'region','regions','openEdit'));

        } 
        catch(\Exception $e){
            
        }
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
          $isEdit  = false;
          $openEdit = false;
          $region = Region::Where('code',$code)->first();
          $region->name = $request->get('name');
          $region->save();

          return redirect()->route('regions.view');
          
        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
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
            
          
           $region = Region::Where('code',$code)->first();

           $region->delete();

           return redirect()->route('regions.view');

        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
        }
    }

    public function restore($code)
    {
        try{
            
          
            Region::withTrashed()->Where('code',$code)->restore();
           //$region->restore();

          // return redirect()->route('regions.view');

        } 
        catch(\Exception $e){
            //return response()->json(['error' =>'500', 'message' => $e]);              
        }
    }

    public function remove($code)
    {
        try{
            
          
            Region::withTrashed()->Where('code',$code)->forceDelete();
           

            return response()->json(['code' =>'200']);              

        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
        }
    }
}
