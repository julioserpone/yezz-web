<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Language;
use App\Product;
use App\Specification;
use App\Http\Requests;


class SpecificationController extends Controller
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

           //return response()->json(['error' =>'404');              

      } 
      catch(\Exception $e){
         return response()->json(['error' =>'500', 'message' => $e]);              
     }
 }




    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $user = \Auth::user();

            $product_id  = Product::withTrashed()->where('ext_id',$request->get('product'))->first()->id;
            $language_id = Language::where('code', $request->get('languages'))->first()->id;


            if($product_id == null || $language_id == null) return response()->json(['code' =>'404']);              

            $specification = Specification::create([
                'product_id'   => $product_id,
                'name'         => $request->get('name'),
                'operating_system' => $request->get('operating_system'),
                'language_id'  => $language_id , 
                'ext_id'       => str_random(20) ,
                'dimensions'   => $request->get('dimensions') ,
                'weight'       => $request->get('weight') , 
                'chipset'      => $request->get('chipset') ,
                'cpu'          => $request->get('cpu') ,
                'cpu_cores'    => $request->get('cpu_cores') ,
                'gpu'          => $request->get('gpu') ,
                'simCard'      => $request->get('simCard') ,
                'simQty'       => $request->get('simQty') ,
                'gsm_bands'    => $request->get('gsm_bands') ,
                'threeg_speed' => $request->get('threeg_speed') ,
                'threeg_bands' => $request->get('threeg_bands') ,
                'fourg_speed'  => $request->get('fourg_speed') ,
                'fourg_bands'  => $request->get('fourg_bands') ,
                'displayType'  => $request->get('displayType') ,
                'displaySize'  => $request->get('displaySize'),
                'resolution'   => $request->get('resolution'),
                'multitouch'   => $request->get('multitouch') ,
                'primary_camera' => $request->get('primary_camera') ,
                'secundary_camera'=> $request->get('secundary_camera') ,
                'videoRecording'  => $request->get('videoRecording') ,
                'primary_camera_features' => $request->get('primary_camera_features') ,
                'microSDCS'    => $request->get('microSDCS') ,
                'internalMemory'  => $request->get('internalMemory') ,
                'ram'          => $request->get('ram') ,
                'wlan'         => $request->get('wlan') ,
                'bluetooth'    => $request->get('bluetooth') ,
                'gps'          => $request->get('gps') ,
                'usb'          => $request->get('usb'),
                'batteryType'  => $request->get('batteryType') ,
                'batteryCapacity' => $request->get('batteryCapacity') ,
                'batteryRemovable'=> $request->get('batteryRemovable'),
                'created_by'   => $user->id 
                ]);
            
            return response()->json(['code' => 200 ,'ext_id' => $specification->ext_id]);              

           // return response()->json(['code' =>200, 'ext_id'=>$specification->ext_id]);           
            //return response()->json([$request->all()]);           

        }catch(\Exception $e){
         return response()->json(['error' =>'500', 'message' => $e]);              
     }
 }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
      try {
        $language_id = Language::Where('code',$request->get('language'))->first()->id;
        $product_id  = Product::withTrashed()->Where('ext_id',$request->get('product'))->first()->id;

        $specification = Specification::where('language_id',$language_id)
        ->where('product_id',$product_id)
        ->first();

        if($specification==null)return response()->json(['code'=>404]);    
        
        return response()->json(['code'=>200 ,'specs'=>$specification]);

    }catch(\Exception $e){
     return response()->json(['code' =>500, 'message' => $e]);              
 }
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

        
        $user = \Auth::user();

        $specification = Specification::Where('ext_id',$ext_id)->first();

        if($specification == null) return response()->json(['code' =>'404', 'message' => 'Not found']);              
        $specification->operating_system = $request->get('operating_system');
        $specification->name         = $request->get('name');
        $specification->dimensions   = $request->get('dimensions');
        $specification->weight       = $request->get('weight'); 
        $specification->chipset      = $request->get('chipset');
        $specification->cpu_cores    = $request->get('cpu_cores');
        $specification->cpu          = $request->get('cpu');
        $specification->gpu          = $request->get('gpu');
        $specification->simCard      = $request->get('simCard');
        $specification->simQty       = $request->get('simQty');
        $specification->gsm_bands    = $request->get('gsm_bands');
        $specification->threeg_speed = $request->get('threeg_speed');
        $specification->threeg_bands = $request->get('threeg_bands');
        $specification->fourg_speed  = $request->get('fourg_speed');
        $specification->fourg_bands  = $request->get('fourg_bands');
        $specification->displayType  = $request->get('displayType');
        $specification->displaySize  = $request->get('displaySize');
        $specification->resolution   = $request->get('resolution');
        $specification->multitouch   = $request->get('multitouch');
        $specification->primary_camera     = $request->get('primary_camera');
        $specification->secundary_camera   = $request->get('secundary_camera');
        $specification->videoRecording     = $request->get('videoRecording');
        $specification->primary_camera_features = $request->get('primary_camera_features');
        $specification->microSDCS          = $request->get('microSDCS');
        $specification->internalMemory     = $request->get('internalMemory');
        $specification->ram          = $request->get('ram');
        $specification->wlan         = $request->get('wlan');
        $specification->bluetooth    = $request->get('bluetooth');
        $specification->gps          = $request->get('gps');
        $specification->usb          = $request->get('usb');
        $specification->batteryType  = $request->get('batteryType');
        $specification->batteryCapacity = $request->get('batteryCapacity');
        $specification->batteryRemovable= $request->get('batteryRemovable'); 
        $specification->updated_by   = $user->id;
        $specification->save(); 

        return response()->json(['code' =>200, 'ext_id'=>$specification->ext_id]);           

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
    public function destroy($ext_id)
    {
        try
        {
            $specification = Specification::Where('ext_id',$ext_id)->first();

            if($specification == null) return response()->json(['error' =>'404', 'message' => 'Not found']);              

            $specification->delete();

            return response()->json(['ext_id' =>$ext_id]);              


        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
        }
        
    }

    public function remove($ext_id)
    {
        try{

            Specification::withTrashed()->Where('ext_id',$ext_id)->forceDelete();

            return response()->json(['code' => 200]);              

        } 
        catch(\Exception $e){

            return response()->json(['code' =>500 ,'message'=> $e]);              
        }
    }
}
