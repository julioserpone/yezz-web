<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Category;
use App\Country;
use App\Confirm;
use App\Banner;
use App\Faq;
use App\Journal;
use App\Language;
use App\Product;
use App\ProductCountry;
use App\ProductManual;
use App\ServiceProvider;
use App\Seller;
use App\Specification;
use App\Subscription;
use App\Url;
use App\User;
use App\UserRol;
use App\Yezz\Mailer;
use DB;
use Session;
use Lang;
use \Torann\GeoIP\GeoIP;
use App\Yezz\Location;

class AppController extends Controller
{
  public function viewLang(Request $request) {

    $uri = $request->route()->uri();
    $uri = explode('-', $request->route()->uri());
    $count  = sizeof($uri);
    $lang = Language::Exist($uri[0])->get();

    //Si el idioma no existe, retorno vista en ingles
    if(!$lang->count())
    {
      return $this->view();
    }
    //Si el pais no existe, retorno vista en ingles
    if($count>1)
    {
      $country = Country::where('code',$uri[1])->first();
      if($country==null)
      {
        return $this->view();
      }
    }
    //Asigno idioma de la Uri
    $lang_country = $uri[0];
    app()->setLocale($lang_country);

    $language = Language::where('code', $lang_country)->first();
    $banners = Banner::where('language_id', $language->id)->orderBy('position')->get();
    $journals = Journal::where('language_id',$language->id)->orderBy('position')->get();
    $categories = Category::has('products')->orderBy('position')->get();

    return view('public.home',compact('lang_country','journals','banners','categories'));
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function view()
  {
    $lang_country = 'en';
    app()->setLocale($lang_country);
    $language = Language::where('code', 'en')->first();
    $banners = Banner::where('language_id', $language->id)->orderBy('position')->get();
    $journals = Journal::where('language_id',$language->id)->orderBy('position')->get();
    $categories = Category::has('products')->orderBy('position')->get();

    return view('public.home',compact('lang_country','journals','banners','categories'));
  }

  /**
   * Return view of Support (English)
   * @return [type] [description]
   */
  public function support() {
    
    return redirect('/support/en');
  }

  /**
   * Return view of Support (Case Language)
   * @param  string $langcountry Language
   * @return view
   */
  public function supports($langcountry) {

    $lang_country = "";
    $code = $this->validateLangCountry($langcountry);

    if($code['language']!="")
    {
      $lang_country = $code['language'];
    }else{
      return redirect('/support/en');
    }
    if($code['country']!="")
    {
      $lang_country = $lang_country.'-'.$code['country'];
    }

    $this->setLang($code['language']);

    return view('public.support.main',compact('lang_country'));
  } 

  /**
   * FAQS
   * @param  string $language laguage ('en','es')
   * @return ViewBlade  View
   */
  public function faqs($language = 'en') {

    $lang_country = "";
    $code = $this->validateLangCountry($language);

    if($code['language']!="") {
      $lang_country = $code['language'];
    } else {
      return redirect('/faqs/en-us');
    }

    if($code['country']!="") {
      $lang_country = $lang_country.'-'.$code['country'];
    }

    $this->setLang($code['language']);

    $faqs = Faq::Show($code['language']);

    return view('public.support.faqs',compact('lang_country','faqs'));
  } 

  /**
   * MANUALS
   * @param  string $language laguage ('en','es')
   * @return ViewBlade  View
   */
  public function manuals($lang_country = 'en') {

    app()->setLocale($lang_country);
    $manuals = ProductManual::with('product')->has('product')->get();

    return view('public.support.manuals',compact('manuals','lang_country'));        
  }

  /**
   * Show Catalog Products
   * @param  string $lang_country language
   * @return view               ViewBlade
  */
  public function showCatalog($lang_country = 'en') {

    app()->setLocale($lang_country);
    $categories = Category::has('products')->orderBy('position')->get();

    return view('public.catalog',compact('categories','lang_country')); 
  }

  /**
   * Show Contacts
   * @return view ViewBlade
   */
  public function contacts()
  {
    $code = $this->setLocation();

    return redirect('/contact/'.$code['language']);        
  }

  /**
   * Show Contacts for language
   * @param  string $langcountry language
   * @return view              ViewBlade
   */
  public function contact($langcountry)
  {
    $lang_country = "";
    $code = $this->validateLangCountry($langcountry);

    if($code['language']!="")
    {
      $lang_country = $code['language'];
    }else{
      return redirect('/contact/en');
    }
    if($code['country']!="")
    {
      $lang_country = $lang_country.'-'.$code['country'];
    }

    $this->setLang($code['language']);

    return view('public.contacts',compact('lang_country'));        
  }

  /**
   * Show Privacy view
   * @return view ViewBlade
   */
  public function privacy($lang_country = 'en')
  {
    app()->setLocale($lang_country);
    return view('public.support.terms_privacy',compact('lang_country'));
  }

  /**
   * Show form compare products
   * @param  string $lang_country language
   * @return view               ViewBlade
   */
  public function compare($lang_country = 'en')
  {
    app()->setLocale($lang_country);
    $productList = Product::DropdownList();    
    $productList = ['0'=>  trans('message.select_product') ] + $productList->all();

    return view('public.products.compare',compact('productList','lang_country'));        
  }

  /**
   * Show Infor Product
   * @param  string $model        Model Phone
   * @param  string $lang_country Language
   * @return view               ViewBlade
   */
  public function showProduct($model, $lang_country)
  {
    app()->setLocale($lang_country);
    $product = Product::with(['category','specs'])->where('model_id',$model)->first();

    if (!$product){
      return redirect('/products/en');    
    }

    $countries = ProductCountry::with(['country','product'])->where('product_id',$product->id)->get();

    $show_sales_guide = 0;
    if($product->sales_guide_en!=null){
      $sales_guide = $product->sales_guide_en;
      $show_sales_guide = 1;
    }

    if($lang_country=='es'){
      $sales_guide = $product->sales_guide_es;
    }

    return view('public.products.specs',compact('product','specs','countries','lang_country','sales_guide','show_sales_guide'));        
  } 

  /**
   * Sellers redirection
   * @return ViewBlade View Sellers
   */
  public function sellers_location()
  {
    $code = $this->setLocation();

    return redirect('/sellers/'.$code['language']);
  }

  /**
   * Sellers View
   * @param  string $lang_country Code Country
   * @return ViewBlade               Sellers View
   */
  public function sellers($lang_country = 'en')
  {
    app()->setLocale($lang_country);

    $sellers = Seller::select('sellers.name','address1 as address', 'address2', 'email1 as email','phone1 as phone_number','regions.code as region', 'latitude as lat', 'longitude as lng', 'countries.name as country')
      ->join('countries','country_id','=','countries.id')
      ->join('regions','countries.region_id','=','regions.id')
      ->orderBy('regions.id')->orderBy('countries.name','asc')
      ->get();

    $directions = json_encode($sellers);

    return view('public.support.sellers',compact('sellers','directions','lang_country'));
  }

  /**
   * Show view Unsolicited Idea Submision
   * @param  string $lang_country language
   * @return view               ViewBlade
   */
  public function unsolicited($lang_country = 'en')
  {
    app()->setLocale($lang_country);
    return view('public.support.unsolicited_idea_submission',compact('lang_country'));
  }

  function getIP() 
  {
    return ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ) ? $_SERVER['HTTP_CLIENT_IP'] : ( ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'] );
  }

  function setLocation()
  { 

    $gip = geoip()->getLocation($this->getIP());

    $code['language'] = "en";
    $code['country']  = "us";
    $code['marketing_region'] = "a1";

    if ($gip)
    {
      $code['country'] = strtolower($gip->iso_code);
      $country = Country::with('language')->where('code',$code['country'])->first();

      if($country)
      {
        $code['language'] = $country->language->code;
        $code['marketing_region'] = $country->marketing_region;
      } 
    }

    return $code;
  }

  public function sendContactMail(Request $request)
  {
    try
    {
      $receivers = Mailer::receivers();
      $code      = $this->setLocation();
      $region    = $code['marketing_region']; 
      $language  = $code['language']; 
      $mail_list = $receivers[$region][$request->get('section')][$request->get('form')];
      $mail_list = explode(',', $mail_list);
      $section = trans('message.'.$request->get('section'));
      $form   = trans('message.'.$request->get('form'));

      $data   = [
        'name'     => $request->get('name'),
        'email'    => $request->get('email'),
        'city'     => $request->get('city'),
        'country'  => $request->get('country'),
        'comment'  => $request->get('comment'),
        'section'  => $section,
        'form'     => $form,
        'product'  => $request->get('productList'),
        'imei'     => $request->get('imei'),
        'region'   => $region,
        'language' => $language 
      ];  

      $data_mail = [
        "to"        => $mail_list,
        "content"   => $data,
      ];

      $res = Mailer::send($data_mail);

      return response()->json(['code'=>200]);
    }
    catch(Exception $e)
    {
      return response()->json(['code'=>200, 'res'=>$e]);
    }

  }

  public function contactForm($section, $form, $lang_country = 'en')
  {

    app()->setLocale($lang_country);
    $productList= Product::selectRaw('concat(model,\' \',categories.name) as name , products.ext_id')
    ->join('categories','category_id','=','categories.id')
    ->get()->pluck('name', 'name');

    $exist = Url::whereRaw('url in (\''.$section.'\',\''.$form.'\')')->get();
    if($exist->count()!=2)
    {
      return redirect('/contact');
    }    

    return view('public.support.contactForm',compact('section','form','productList','lang_country'));    
  }

 public function productsByCategory($category)
 {
  $params   = explode('-', $lang_country);

  $count    = sizeof($params);
  $products = null;
  $country  = null;
  $country_id  = null;
  $show_all    = 0; 
  $series[$category]  = array();


  $lang = Language::Exist($params[0])->get();
  if(!$lang->count())
  {
   return redirect('/products/en');
 }

 $lang_id = $lang->first()->id;
 if($count>1){
   $country = Country::where('code',$params[1])->first();
 } 

 if($country==null){
       //$script_where = "(country_id is null or 1 = 1)";  
   $country_id = 0;
   $show_all   = 1;
 }else{
   $country_id = $country->id;
       //$script_where = "(counrty_id = ".$country_id.")";  

 }
 $category_name = str_replace('_', ' ', $category);
 

    $products = Product::select(['line','model','model_id','products.ext_id','categories.name as category'])//,'highlights.text as highlights'])
    ->leftjoin('product_countries','product_countries.product_id','=','products.id')
    ->join('categories','category_id','=','categories.id')
    ->where('categories.name','=',$category_name)
    ->orderby('top')
    ->distinct()
    ->get();

    $front_requires['multiselect'] = false;


    $this->setLang($params[0]);

    return view('public.catalog',compact('products','series','lang_country','isProducts','front_requires'));        




  }


  public function apiProduct($ext_id)
  {
   try 
   {
     $product = Product::ProductSpecs($ext_id);

     return response()->json(['code' =>'200', 'data' => $product]);              

   } catch (Exception $e) {
     return response()->json(['code' =>'500', 'message' => $e]);              
   }
 }

 public function productAutocomplete()
 {
  $term = Input::get('term');

  $results = array();

  $queries = DB::table('products')
  ->leftJoin('specifications','product_id','=','products.id')
  ->where('model', 'LIKE', '%'.$term.'%')
  ->orWhere('operating_system', 'LIKE', '%'.$term.'%')
  ->orWhere('cpu_cores', 'LIKE', '%'.$term.'%')
  ->orWhere('cpu_cores', 'LIKE', '%'.$term.'%')
  ->orWhere('cpu', 'LIKE', '%'.$term.'%')
  ->orWhere('gpu', 'LIKE', '%'.$term.'%')
  ->orWhere('simCard', 'LIKE', '%'.$term.'%')
  ->orWhere('simQty', 'LIKE', '%'.$term.'%')
  ->orWhere('gsm_bands', 'LIKE', '%'.$term.'%')
  ->orWhere('threeg_bands', 'LIKE', '%'.$term.'%')
  ->orWhere('threeg_speed', 'LIKE', '%'.$term.'%')
  ->orWhere('fourg_speed', 'LIKE', '%'.$term.'%')
  ->orWhere('fourg_bands', 'LIKE', '%'.$term.'%')
  ->orWhere('displayType', 'LIKE', '%'.$term.'%')
  ->orWhere('displaySize', 'LIKE', '%'.$term.'%')
  ->take(10)->get();

  foreach ($queries as $query)
  {
    $results[] = [ 'id' => $query->model_id, 'value' => $query->model ];
  }
  return Response::json($results);
}

public function searchProduct()
{

}
           public function service_provider()
           {
            return redirect('/service-providers/en');
          }

          public function service_providers($langcountry)
          {
            $lang_country = "";
            $code = $this->validateLangCountry($langcountry);


            if($code['language']!="")
            {
              $lang_country = $code['language'];
            }else{
              return redirect('/service-providers/en-us');
            }
            if($code['country']!="")
            {
              $lang_country = $lang_country.'-'.$code['country'];
            }

            $this->setLang($code['language']);

            $service_providers = ServiceProvider::selectRaw('service_providers.name, province, email, phone_number, address, regions.code as region
             , latitude as lat, longitude lng, attention, countries.name as country')
            ->join('countries','country','=','countries.code')
            ->join('regions','countries.region_id','=','regions.id')
            ->orderBy('regions.id')->orderBy('countries.name','asc')
            ->get();

            $directions = json_encode($service_providers);

            return view('public.support.service_providers',compact('service_providers','directions','lang_country'));
          }

          public function sellerList($country_code)
          {
            try {

             $sellers = Seller::select('sellers.name','address1','email1','phone1','attention')
             ->join('countries','country_id','=','countries.id')
             ->where('countries.code',$country_code)
             ->get();


             if($sellers!=null)
             {
              return response()->json(['code'=>200 , 'data'=> $sellers]);
            }else
            {
              return response()->json(['code'=>404]);
            }

          } catch (Exception $e) {
            return response()->json(['code'=>500]);
          }
        }

        public function subscribe(Request $request)
        {
          try {
            $email = $request->get('email');

            $subscribed = Subscription::where('email',$email)->first();

            if($subscribed!=null)
            {
              return response()->json(['code'=>200]);
            }else{

              $uip = $this->getIP();
              $gip = geoip()->getLocation($uip);
              $code = array();
              $code['language'] = "en";
              $code['country']  = "";
              if($gip!=null)
              {
                $client_country = $gip->iso_code;
                $client_country = strtolower($client_country);
                $code['country']= $client_country;
                $country_language = Country::withTrashed()
                ->select('languages.code','marketing_region')
                ->join('languages','language_id','=','languages.id')
                ->where('countries.code',$client_country)
                ->first();

                if($country_language!=null)
                {
                  $code['language'] = $country_language->code;


                }else{
                  $code['language'] = "en";
                }

                if($code['country']!=null)
                {
                  $subscribed = Subscription::create([
                    'email'    => $email,
                    'marketing_region' => $country_language->marketing_region,
                    'country'  => $code['country'],
                    'language' => $code['language']
                    ]);

                  if($subscribed!=null)
                  {
                    return response()->json(['code'=>201]);
                  }else{
                    return response()->json(['code'=>500]);
                  }
                }
              }
            }



          } catch (Exception $e) {
            return response()->json(['code'=>500]);
          }
        }


        function existLang($lang)
        {
          return Language::Exist($lang)->get()->count();
        }

        function setLang($lang){
         \App::setlocale($lang);
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

      public function authenticate(Request $request)
      {
        $url      = $_SERVER['HTTP_REFERER'];
        $email    = $request->get('email');
        $password = $request->get('password');

        $confirm = Confirm::where('email',$email)->first();  


        if($confirm!=null)
        {
         Session::set('unconfirm_msg', 1);
         Session::set('confirm_msg',0);
         Session::set('show_login',0);
         Session::set('unconfirmed_email', $email);
         return redirect()->back()->with('login_error', 1);
       }

       if (Auth::attempt(['email' => $email, 'password' => $password])) {
       // Authentication passed...
        Session::set('show_login',0);
        return redirect($url);
      }else{
       Session::set('show_login',1);
       return redirect()->back()->with('login_error', 1);


     }


   }


   protected function register(Request $request)
   {
    $host     = $_SERVER['SERVER_NAME'];
    $url      = $_SERVER['HTTP_REFERER'];
    $name     = $request->get('name');
    $email    = $request->get('email');
    $password = $request->get('password');

    $exists  = User::where('email',$email)->get();
    $confirm = Confirm::where('email',$email)->first();  

    if($exists->count()>0)
    {
      if($confirm==null)
      {
        Session::set('unconfirm_msg',0);
        return redirect()->back()->with('confirm_msg', 1);
      }else{
        Session::set('confirm_msg',0);
        return redirect()->back()->with('unconfirm_msg', 1);
      }


    }else{

     $rol  = UserRol::where('ext_id','web_user')->first();

     $user = User::create([
      'name'     => $name,
      'email'    => $email,
      'password' => bcrypt($password),
      'rol_id'   => $rol->id
      ]);

     $confirm = Confirm::create([
      "email"  => $email,
      "token"  => str_random(20)
      ]);

     $data = array(
      "to"        => $email,
      "name"      => $name,
      "content"   => array("name"=>$name,"token"=>$confirm->token,"host"=>$host),
      "subject"   => "Registro YezzTalk",
      "template"  => "public.email.resetpassword"
      );


     $res = Mailer::send($data);

     if($res==1){
       Session::set('unconfirm_msg', 0);
       Session::set('confirm_msg', 1);
       Session::set('show_login',0);
       return redirect('/yezztalk');
     }else{
       return redirect('/loging');
     } 

   }

 }

 public function confirm($token)
 {
  $confirm = Confirm::where('token',$token)->first();

  if($confirm!=null)
  {
    $confirm->delete();
    Session::set('show_login',1);
    Session::set('confirm_msg', 0);
    return redirect('/yezztalk');
  }
}

public function reconfirm($email)
{
  try {
    if(Session::get('unconfirmed_email')!=null)
    {

      $confirm = Confirm::where('email',$email)->first();

      $confirm->token = str_random(20);
      $confirm->save();

      $user = User::where('email',$email)->first();

      $data = array(
        "to"        => $email,
        "name"      => $user->name,
        "content"   => array("name"=>$user->name,"token"=>$confirm->token),
        "subject"   => "Registro YezzTalk",
        "template"  => "public.email.resetpassword"
        );


      $res = Mailer::send($data);

      Session::set('unconfirm_msg', 0);
      Session::set('confirm_msg',0);
      Session::set('show_login',0);

      return response()->json(['code'=>200]);
    }  
  } catch (Exception $e) {
    return response()->json(['code'=>500]);
  }


}




protected function registers(Request $request)
{
  $url      = $_SERVER['HTTP_REFERER'];
  $name     = $request->get('name');
  $email    = $request->get('email');
  $password = $request->get('password');

  $rol  = UserRol::where('ext_id','web_user')->first();

  $user = User::create([
    'name'     => $name,
    'email'    => $email,
    'password' => bcrypt($password),
    'rol_id'   => $rol->id
    ]);

  if($user!=null){
    if (Auth::attempt(['email' => $email, 'password' => $password])) {
              // Authentication passed...
      return redirect($url);
    }else{
     return redirect()->back()->with('login_error', 1);
   }

 }

}

public function warranty_policy($langcountry)
{
  $code = $this->setLocation();
  $lang_country = $code['language'];

  //$code = $this->validateLangCountry($langcountry);
  $this->setLang($code['language']);

  return view('public.support.warranty_policy',compact('lang_country'));
}

public function repairProgram()
{
  return view('public.support.repair_program');
}

public function live_chat_admin()
{

}



public function validatepage()
  {
   
   $lang_country = 'en-us';
   $code = $this->setLocation();
   

    //$gip = geoip($ip = null);
    //$gip = geoip()->getLocation('27.974.399.65');
    //$gip = geoip()->getClientIP();
    //dd($gip);
   $t_series_lte = Product::Top('T LTE');
   $t_series_3g  = Product::Top('T 3G');
   $m_series_lte = Product::Top('M LTE');
   $m_series_3g  = Product::Top('M 3G');
   $e_series_lte = Product::Top('E LTE');
   $e_series_3g  = Product::Top('E 3G');
   $classic  = Product::Top('classic');
   $tablet   = Product::Top('epic');

   $this->setLang($code['language']);
   $language = Language::where('code',$code['language'])->first();

   $journals = Journal::where('language_id',$language->id)->orderBy('position')->get();

   $lang = $code["language"];
   $lang_country = $code["language"];

   $img_lang = "en";
   if($lang=="es"){$img_lang=$lang;}

   return view('public.validate',compact('t_series_lte',
     't_series_3g',
     'm_series_lte',
     'm_series_3g',
     'e_series_lte',
     'e_series_3g',
     'classic',
     'tablet',
     'lang_country',
     'lang',
     'img_lang',
     'journals'));

 }

 


}
