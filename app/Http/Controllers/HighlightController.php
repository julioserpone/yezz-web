<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Language;
use App\Highlight;
use App\HighlightType;
use App\Product;

class HighlightController extends Controller
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
    public function index(Request $request)
    {
      try{  
        $product_id = Product::withTrashed()->where('ext_id',$request->get('product'))->first()->id;

        $highlights = Highlight::withTrashed()
                                ->selectRaw('highlights.ext_id, highlights.text,languages.code langCode, languages.name langName
                                            , case when highlights.deleted_at is null then 0 else 1 end deleted')
                                ->where('product_id',$product_id)
                                ->join('languages','language_id','=','languages.id')
                                ->get();
                                
        return response()->json($highlights);          
      } 
        catch(\Exception $e){
            return response()->json(['code' => 500, 'message' => $e]);              
        }    
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
        try{
                $product_id  = Product::withTrashed()->where('ext_id',$request->get('product'))->first()->id;
                $language_id = Language::withTrashed()->where('code',$request->get('language'))->first()->id;
                $type_id     = HighlightType::where('code',$request->get('type'))->first()->id;
                
                $highlight = Highlight::create([
                               'product_id'  => $product_id,
                               'language_id' => $language_id,
                               'type_id'     => $type_id,
                               'ext_id'      => str_random(20),
                               'text'        => $request->get('text')

                     ]);
           
                return response()->json(['code' =>200]);              

           } 
            catch(\Exception $e){
                return response()->json(['code' => 500, 'message' => $e]);              
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
    public function update(Request $request, $ext_id)
    {
        try{
            $language_id = Language::where('code',$request->get('language'))->first()->id;
            $highlight   = Highlight::withTrashed()->where('ext_id',$ext_id)->first();
            //$product_id  = Product::withTrashed()->where('ext_id'$request->get('product'); 

            $highlight->language_id = $language_id;
            $highlight->text        = $request->get('text');
            $highlight->save();


            $highlights = Highlight::withTrashed()
                                ->selectRaw('highlights.ext_id, highlights.text,languages.code langCode, languages.name langName
                                            , case when highlights.deleted_at is null then 0 else 1 end deleted')
                                ->join('languages','language_id','=','languages.id')
                                ->join('products','product_id','=','products.id')
                                ->where('products.ext_id',$request->get('product'))
                                ->get();

           return response()->json(['code' => 200, 'highlights' => $highlights]);              

        } 
            catch(\Exception $e){
                return response()->json(['code' => 500, 'message' => $e]);              
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
        try{
           Highlight::withTrashed()->where('ext_id',$ext_id)->first()->delete();
        
           return response()->json(['code' => 200]);              

        } 
            catch(\Exception $e){
                return response()->json(['code' => 500, 'message' => $e]);              
            }

    }



    public function restore($ext_id)
    {
      try{
            
            Highlight::withTrashed()->Where('ext_id',$ext_id)->restore();

        } 
        catch(\Exception $e){
            //return response()->json(['error' =>'500', 'message' => $e]);              
        }
    }

    public function remove($ext_id)
    {
        try{
          
            Highlight::withTrashed()->Where('ext_id',$ext_id)->forceDelete();

            return response()->json(['code' => 200]);              

        } 
        catch(\Exception $e){
            return response()->json(['code' =>500]);              
        }
    }

}
