<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Country;
use App\Highlight;
use App\HighlightType;
use App\Product;
use App\ProductCountry;
use App\ProductManual;
use App\OperatingSystem;
use App\Specification;
use App\Language;
use DB;
use File;
use Storage;


class ProductController extends Controller
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
       $os       = $request->input('os');
       $langcode = $request->input('langcode');
       $country  = $request->input('country');

       return Product::Select('model','products.ext_id','specifications.name','languages.code as langcode', 'dimensions','weight', 'chipset',
        'CPU','GPU','SimCard','GsmEdge',
        'HSPA',
        'DisplayType',
        'DisplaySize',
        'Resolution',
        'Multitouch',
        'RearCamera',
        'FrontCamera',
        'VideoRecording',
        'RearCameraFeatures',
        'MicroSDCS' ,
        'InternalMemory',
        'RAM',
        'WLAN',
        'Bluetooth',
        'GPS',
        'USB',
        'BatteryType',
        'BatteryCapacity' ,
        'BatteryRemovable')
       ->LeftJoin('operating_systems','products.operating_system_id','=','operating_systems.id')
       ->Leftjoin('specifications','products.id','=','specifications.product_id')
       ->leftjoin('languages','specifications.language_id','=','languages.id')
       ->leftjoin('product_countries','products.id','=','product_countries.product_id')
       ->leftjoin('countries','product_countries.country_id','=','countries.id')
       ->WhereRaw('(operating_systems.code = \''.$os.'\' or \'0\' = \''.$os.'\')')
       ->WhereRaw('(languages.code = \''.$langcode.'\' or \'0\' = \''.$langcode.'\')')
       ->WhereRaw('(countries.code = \''.$country.'\' or \'ALL\' = \''.$country.'\')')
       ->distinct()->get();


     } 
     catch(\Exception $e){
      return response()->json(['error' =>'500', 'message' => $e]);              
    }
  }


  public function view()
  {
    $products = Product::withTrashed()
    ->selectRaw('products.ext_id,products.line, products.model, case when products.deleted_at is null then 0 else 1 end deleted, sales_guide_en, sales_guide_es
     ,parent, top, manuals
     ,operating_systems.code osCode, operating_systems.name osName, specs, countries, categories.name category')
    ->join('operating_systems','operating_system_id','=','operating_systems.id')
    ->leftJoin(DB::raw('(select product_id ,count(*) specs from specifications group by product_id) specs'),
      function($join){
        $join->on('products.id', '=', 'specs.product_id');
      } )
    ->leftJoin(DB::raw('(select product_id ,count(*) manuals from product_manuals group by product_id) manuals'),
      function($join){
        $join->on('products.id', '=', 'manuals.product_id');
      } )
    ->leftJoin(DB::raw('(select product_id ,count(*) countries from product_countries group by product_id) countries'),
      function($join){
        $join->on('products.id', '=', 'countries.product_id');
      } )
    ->leftJoin('categories','category_id','=','categories.id')
    ->groupBy('ext_id', 'products.model','products.deleted_at','operating_systems.code', 'operating_systems.name')
    ->orderBy('products.deleted_at','asc')
    ->get();



    return view('product.product', compact('products'));

  }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user = \Auth::user();
      $model_id = $request->get('model_id');
      $line     = $request->get('line');
      $path     = public_path().'/img/products/'.$line.'/'.$model_id;

      $os_code = $request->get('operatingSystems');

      $os = OperatingSystem::Where('code',$os_code)->first();

      if($os == null ) return response()->json(['error' =>'404']);              

      $product = Product::create([
        'operating_system_id' => $os->id,
        'model'               => $request->get('model'),
        'model_id'            => $model_id,
        'line'                => $line,
        'ext_id'              => str_random(20), 
        'top'                 => $request->get('top'),
        'category_id'         => $request->get('category'),
        'create_by'           => $user->id

        ]);

      $operatingSystems = OperatingSystem::pluck('name','code as id');
      $languages = Language::DropdownList();

      $isEdit = true;


      if($product!=null)
      {

        $result = File::makeDirectory($path, 0777,true,true);
        if($result==true)
        {
          if(!empty($request->file('front_image')))
          {
            $front_image =  'yezz-'.$product->model_id."-front-view.png";
            $request->file('front_image')->move($path, $front_image);
          }
          if(!empty($request->file('banner_image')))
          {
            $banner_image =  'yezz-andy-'.$product->model_id."-hero-image.jpg";
            $request->file('banner_image')->move($path, $banner_image);
          }

        }


        if(!empty($request->file('manual_en')))
        { 
          $document = $request->file('manual_en');
          $doc_name = $document->getClientOriginalName();

          $result = $document->move(base_path() . '/public/downloads/manuals/', $doc_name);
          $language = Language::where('code','en')->first(); 
          $manual = new ProductManual(['name' => $doc_name,
           'language_id' => $language->id]);

          $product->manuals()->save($manual);
        }


        if(!empty($request->file('sales_guide_en')))
        { 
          $sales_guide = $request->file('sales_guide_en');
          $doc_name    = $sales_guide->getClientOriginalName();

          $result = $sales_guide->move(base_path() . '/public/sales-guide/en/', $doc_name);

          $product->sales_guide_en = $doc_name;

        }
        if(!empty($request->file('sales_guide_es')))
        { 
          $sales_guide = $request->file('sales_guide_es');
          $doc_name    = $sales_guide->getClientOriginalName();

          $result = $sales_guide->move(base_path() . '/public/sales-guide/es/', $doc_name);

          $product->sales_guide_es = $doc_name;
        }
        $product->save();

      }


      $url = '/admin/products/'.$product->ext_id.'/edit';
      return redirect($url);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      try{


        $isEdit        = false;
        $product       = new Product;
        $languages     = Language::DropdownList();
        $countries     = Country::pluck('name','code as id');
        $pcountries    = new ProductCountry;
        $highlightType = HighlightType::DropdownList();
        $operatingSystems = OperatingSystem::pluck('name','code as id');
        $categories       = Category::pluck('name','id');

        $manual_en = new ProductManual;
        $manual_es = new ProductManual;

        return view('product.edit', compact('product','isEdit','operatingSystems','languages','countries','pcountries','highlightType','categories','manual_en','manual_es'));

      } 
      catch(\Exception $e){
        return response()->json(['error' =>'500', 'message' => $e]);              
      }
    }

    public function productCountry(Request $request,$ext_id,$country)
    {
      try{

            //$country = $request-<input('country');


        $country_id = Country::Where('code',$country)->first()->id;
        $product_id = Product::Where('ext_id',$ext_id)->first()->id;

        if($country_id == null || $product_id == null) return response()->json(['error' =>'404']);              

        $productCountry = ProductCountry::create([
          'product_id' => $product_id,
          'country_id' => $country_id
          ]);




        return response()->json(['ext_id' =>$ext_id]);              




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
      try{

        $product = Product::Where('ext_id',$ext_id)
        ->first();

        return $product;

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

      $isEdit = true;
      $product = Product::withTrashed()
      ->with('manuals')
      ->selectRaw('products.id, products.ext_id,products.line,model_id, products.model, case when products.deleted_at is null then 0 else 1 end deleted
       ,operating_systems.code osCode, operating_systems.name osName, top,sales_guide_en, sales_guide_es,
       categories.id as category,created.name as created_by, updated.name as updated_by, products.created_at, products.updated_at')
      ->join('operating_systems','operating_system_id','=','operating_systems.id')
      ->leftJoin('categories','category_id','=','categories.id')
      ->leftJoin('users as created','products.created_by','=','created.id')
      ->leftJoin('users as updated','products.updated_by','=','updated.id')
      ->where('products.ext_id',$ext_id)
      ->first();

      $manual_en  = $product->manuals()->select('product_manuals.name')->join('languages','language_id','=','languages.id')->where('languages.code','en')->first();


      $product_id = Product::withTrashed()->where('ext_id',$ext_id)->first()->id;

      $spec = Specification::withTrashed()
      ->selectRaw('specifications.*, languages.code langCode, languages.name langName, created.name as created_by, updated.name as updated_by')
      ->where('product_id',$product_id)
      ->join('languages','language_id','=','languages.id')
      ->leftJoin('users as created','specifications.created_by','=','created.id')
      ->leftJoin('users as updated','specifications.updated_by','=','updated.id')
      ->first();


      $operatingSystems = OperatingSystem::pluck('name','code as id');
      $categories       = Category::pluck('name','id');

      $languages = Language::DropdownList();

      $highlights = Highlight::withTrashed()
      ->where('product_id',$product_id)
      ->get();

      $pcountries = ProductCountry::withTrashed()
      ->selectRaw('product_countries.ext_id, countries.code,countries.name
       ,case when product_countries.deleted_at is null then 0 else 1 end deleted')
      ->join('countries','country_id','=','countries.id')->where('product_id',$product_id)->get();


      $countries = Country::pluck('name','code as is');

      $highlightType = HighlightType::DropdownList();
      return view('product.edit', compact('product','isEdit','operatingSystems','spec','languages','highlights','highlightType','countries','pcountries','categories','manual_en','manual_es'));
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
      $os = OperatingSystem::Where('code',$request->get('operatingSystems'))->first();
      $category = Category::where('id',$request->get('category'))->first();
      $product = Product::withTrashed()->where('ext_id',$ext_id)->first();

      if($product == null || $os == null) return response()->json(['error' =>'404', 'message' => 'Not found']);              

      $product->operating_system_id = $os->id;
      $product->category_id = $category->id;
      $product->model = $request->get('model');
      $product->model_id = $request->get('model_id');
      $product->line  = $request->get('line');
      $product->top   = $request->get('top');
      $product->updated_by = $user->id; 


      if($product!=null){

        if($request->file('sales_guide_en')!=null)
        { 
          $sales_guide = $request->file('sales_guide_en');
          $doc_name    = $sales_guide->getClientOriginalName();

          $result = $sales_guide->move(base_path() . '/public/sales-guide/en/', $doc_name);

          $product->sales_guide_en = $doc_name;
        }
        if($request->file('sales_guide_es')!=null)
        { 

          $sales_guide = $request->file('sales_guide_es');
          $doc_name    = $sales_guide->getClientOriginalName();

          $result = $sales_guide->move(base_path() . '/public/sales-guide/es/', $doc_name);

          $product->sales_guide_es = $doc_name;
        }

        $product->save();


        if($request->file('manual_en')!=null)
        { 
         $path = base_path().'/public/downloads/manuals/';
         $document = $request->file('manual_en');
         $doc_name = $document->getClientOriginalName();
         $language_en = Language::where('code','en')->first(); 

         $manual  = $product->manuals()->where('language_id',$language_en->id)->first();

         

         if($manual==null)
         {

           $manual = new ProductManual(['name' => $doc_name,
            'language_id' => $language_en->id]);

           $result = $document->move($path, $doc_name);

           $product->manuals()->save($manual);
         }else{
          $result = $document->move($path, $doc_name);
          $manual->name = $doc_name;
          $manual->save();
        }
      }

      $model_id = $product->model_id;
      $line     = $product->line;
      $path     = public_path().'/img/products/'.$line.'/'.$model_id;


      if($request->file('front_image')!=null){
        $front_image =  'yezz-'.$product->model_id."-front-view.png";
        $request->file('front_image')->move($path, $front_image);
      }
      if($request->file('banner_image')!=null)
      {
        $banner_image =  'yezz-andy-'.$product->model_id."-hero-image.jpg";
        $request->file('banner_image')->move($path, $banner_image);
      }


      $url = '/admin/products/'.$product->ext_id.'/edit';
      return redirect($url);
    }else{
      $url = '/admin/products/view';
      return redirect($url);
    }

  } 
  catch(\Exception $e){
    return response()->json(['error' =>'500', 'message' => $e]);              
  }
}
/*Delete Sales Guide EN**/
public function deleteSgEn($ext_id)
{

  try {

    $base = base_path();
    $url = $base."/public/sales-guide/en/";

    $product = Product::withTrashed()->where('ext_id',$ext_id)->first();
    if($product!=null)
    {
      $file_name = $product->sales_guide_en;
      $product->sales_guide_en = "";
      $product->save();
      $res = File::delete($url.$file_name);

    }
    $uri = "/admin/products/".$ext_id."/edit";
    return redirect($uri);
  }catch (Exception $e) {

  }

}
/*Delete Sales Guide ES**/
public function deleteSgEs($ext_id)
{

  try {

    $base = base_path();
    $url = $base."/public/sales-guide/es/";

    $product = Product::withTrashed()->where('ext_id',$ext_id)->first();
    if($product!=null)
    {
      $file_name = $product->sales_guide_es;
      $product->sales_guide_es = "";
      $product->save();
      $res = File::delete($url.$file_name);

    }
    $uri = "/admin/products/".$ext_id."/edit";
    return redirect($uri);
  }catch (Exception $e) {

  }

}
/*Delete Manual**/
public function deleteManual($ext_id)
{

  try {

    $base = base_path();
    $url = $base."/public/downloads/manuals/";

    $product = Product::withTrashed()->where('ext_id',$ext_id)->first();
    if($product!=null)
    {
      $product->manual = 0;
      $manual = ProductManual::where('product_id',$product->id)->first();
      $file_name = $manual->name;
      $res = File::delete($url.$file_name);
      $manual->delete();
      $product->save();
    }
    $uri = "/admin/products/".$ext_id."/edit";
    return redirect($uri);
  }catch (Exception $e) {

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
    $product = Product::Where('ext_id',$ext_id)->first();

    if($product == null) return response()->json(['code' =>'404']);              

    $product->delete();

    return response()->json(['code' => 200]);

  } 
  catch(\Exception $e){
    return response()->json(['code' =>'500']);              
  }
}


public function restore($ext_id)
{
  try{

    Product::withTrashed()->Where('ext_id',$ext_id)->restore();

  } 
  catch(\Exception $e){
    return response()->json(['error' =>'500', 'message' => $e]);              
  }
}

public function remove($ext_id)
{
  try{

    Product::withTrashed()->Where('ext_id',$ext_id)->forceDelete();

    return response()->json(['code' => 200]);              

  } 
  catch(\Exception $e){

    return response()->json(['code' =>500 ,'message'=> $e]);              
  }
}


public function addCountry(Request $request,$ext_id)
{
  try 
  {

    $countries = $request->get('countries');
    $code = 200;
    $product = Product::withTrashed()->where('ext_id',$ext_id)->first();
    $country_id = null;

    if($product!=null){     

     foreach ($countries as $key => $value){
      $country_id = Country::Where('code',$value)->first()->id;
      $exist = ProductCountry::where('product_id',$product->id)->where('country_id',$country_id)->first();
      if(!$exist){
        $productCountry = ProductCountry::create([
          'product_id' => $product->id,
          'country_id' => $country_id,
          'ext_id'     => str_random(20)
          ]);
      }else
      {
        $code = 400;
      }
    }

  }

  return response()->json(['code' =>$code]);              

} catch (Exception $e) {
 return response()->json(['code' =>500 ,'message'=> $e]);              
}

return $val;
}

public function deleteCountry($product, $ext_id)
{

 $country = DB::table('product_countries')->where('ext_id',$ext_id)->delete();


 $url = '/admin/products/'.$product.'/edit';
 return redirect($url);
}

public function highlights($ext_id){

}


}
