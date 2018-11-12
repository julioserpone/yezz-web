<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Faq;
use App\Language;

class FaqController extends Controller
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
    public function index(Request $request)
    {
        $lang_code = $request->input('langcode');
        
        return Faq::withTrashed()
                   ->join('languages', 'faqs.language_id', '=', 'languages.id')
                   ->select(['ext_id','question', 'answer','priority','likes','unlike','languages.code as langCode','languages.name as langName'])
                   ->selectRaw('case when countries.deleted_at is null then 0 else 1 end deleted')
                   ->Where('languages.code',$language_code)
                   ->get();

    }


    public function view(Request $request)
    {
        
       $language_code = $request->get('lang');
       $lang = $language_code==null ? '0' : $language_code;
       $languages = Language::DropdownList();


       $faqs = Faq::withTrashed()
                   ->join('languages', 'faqs.language_id', '=', 'languages.id')
                   ->select(['ext_id','question', 'answer','priority','likes','unlikes','languages.code as langCode','languages.name as langName'])
                   ->selectRaw('case when faqs.deleted_at is null then 0 else 1 end deleted')
                 //  ->whereRaw('languages.code' = \''.$lang.'\' or (\'0\' = \''.$lang.'\')')
                   ->get();
       return view('faq.faq', compact('faqs','languages'));


    }


    public function search(Request $request)
    {
        $lang_code = $request->input('langcode');
        $text      = $request->input('text');
        return Faq::AutoCompleteSearch($lang_code, $text);
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
            
            $language = Language::Where('code',$data->langcode)->first();
            if($language == null) return response()->json(['error' =>'404']);              
            $language_id = $language->id;

            $faq = Faq::create(
            ['ext_id'      => str_random(20),
             'language_id' => $language_id,
             'question'    => $data->question,
             'answer'      => $data->answer,
             'priority'    => $data->priority
             ]);

            return response()->json(['ext_id' => $faq->ext_id]);
        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e->errorInfo]); 
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
         try{
            $lang = $request->get('language');

            $language = Language::Where('code',$lang)->first();
            if($language == null) return response()->json(['error' =>'404']);              
            

            $faq = Faq::create(
            ['ext_id'      => str_random(20),
             'language_id' => $language->id,
             'question'    => $request->get('question'),
             'answer'      => $request->get('answer'),
             'priority'    => $request->get('priority')
             ]);

            return response()->json(['code' => $faq->ext_id]);
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
    public function show($ext_id)
    {
        
        try
        {

            $faq = Faq::select(['ext_id','question', 'answer','priority'])
                       ->Where('faqs.active',1)
                       ->Where('ext_id',$ext_id)
                       ->first();

            if ($faq == null) return response()->json(['error' =>'404']); 
            
            return $faq;
        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500']);              
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
    public function update(Request $request, $ext_id)
    {
        try{
            $lang = $request->get('language');

            $language = Language::Where('code',$lang)->first();
            $faq      = Faq::Where('ext_id',$ext_id)->first();

            if($language == null || $faq == null) return response()->json(['error' =>'404']);              
            
            $faq->language_id = $language->id;
            $faq->question    = $request->get('question');
            $faq->answer      = $request->get('answer');
            $faq->priority    = $request->get('priority');
            $faq->save();
            
              
            return response()->json(['code' => $ext_id]);
           
          

        } 
        catch(\Exception $e){
            return response()->json(['code' =>'500']);              
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
            $faq = Faq::Where('ext_id',$ext_id)->first();

            if($faq == null) return response()->json(['error' =>'404']);              
      
            $faq->delete();
            
            return response()->json(['code' => 200]);

        } 
        catch(\Exception $e){
            return response()->json(['code' =>'500']);              
        }
    }


    public function restore($ext_id)
    {
      try{
            
            Faq::withTrashed()->Where('ext_id',$ext_id)->restore();

        } 
        catch(\Exception $e){
            //return response()->json(['error' =>'500', 'message' => $e]);              
        }
    }

    public function remove($ext_id)
    {
        try{
          
            Faq::withTrashed()->Where('ext_id',$ext_id)->forceDelete();

            return response()->json(['code' =>'200']);              

        } 
        catch(\Exception $e){
            return response()->json(['code' =>'500', 'message' => $e]);              
        }
    }
}
