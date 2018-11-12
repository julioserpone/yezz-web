<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Language;

use App\Http\Requests;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Language::Select(['code','name'])->where('active',1)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function create(Request $request)
    {
       $input = $request->getContent();
       $data  = json_decode($input);
       try{
            $language = Language::create(
            ['code'        => $data->code,
             'name'        => $data->name
             ]);

            return response()->json(['code' => $language->code]);
        } 
        catch(\Exception $e){
            $message = $e->errorInfo != null? $e->errorInfo : $e;
            return response()->json(['error' =>'500', 'message' => $message]);              
        }
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
    public function show($code)
    {

         try{
           $language =  Language::Select(['code' ,'name'])->Where('code',$code)->first();
           if ($language == null) return response()->json(['error' =>'404']);              
           return $language;
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
    public function update(Request $request, $code)
    {
      try{
           $input = $request->getContent();
           $data  = json_decode($input);

           $language = Language::Where('code',$code)->first();
           if ($language == null) return response()->json(['error' =>'404']);              

           $language->name = $data->name;
           $language->save(); 
           
           return response()->json(['code' =>$language->code]);              
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
           
           $language =  Language::Where('code',$code)->first();
           
           if ($language == null) return response()->json(['error' =>'404']);              

           $language->delete();

           return response()->json(['code' =>$language->code]);              
        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
        }
        
    }
}
