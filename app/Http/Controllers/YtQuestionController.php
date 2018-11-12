<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\YtQuestion;
use App\YtTheme;
use App\Language;
use App\YtQuestionstatus;
use App\User;



class YtQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         try
        {
         $theme = $request->input('theme');
         
         $questions = YtQuestion::Select('yt_questions.ext_id','question','yt_questions.created_at','users.name','username','yt_questionstatuses.name as statusName')
                                ->join('yt_themes','yt_theme_id','=','yt_themes.id')
                                ->join('users','user_id','=','users.id')
                                ->join('yt_questionstatuses','questionstatus_id','=','yt_questionstatuses.id')
                                ->Where('yt_themes.ext_id',$theme)->get();

         return $questions;
            
        } 
        catch(\Exception $e){
         
            return response()->json(['error' =>'500', 'message' => $e]);              
        }
        
    }

    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
          try
        {
         $input = $request->getContent();
         $data  = json_decode($input);
         
         $theme  = YtTheme::Where('ext_id',$data->theme)->first();
         $user   = User::Where('username',$data->username)->first();
         $lang   = Language::Where('code',$data->langcode)->first();
         $status = YtQuestionstatus::Where('name','New')->first();

         if($theme == null || $user == null || $lang == null) return response()->json(['error' =>'404']);              

         $question = YtQuestion::create(
            ['yt_theme_id' => $theme->id,
             'language_id' => $lang->id,
             'user_id'     => $user->id,
             'ext_id'      => str_random(20),
             'question'    => $data->question,
             'questionstatus_id' => $status->id
          ]);

         return response()->json(['ext_id' =>$question->ext_id]);              
            
        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
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
         
          /*$question = YtQuestion::Select('yt_questions.ext_id','question','yt_questions.created_at','users.name','username','yt_questionstatuses.name as statusName')
                                ->join('yt_themes','yt_theme_id','=','yt_themes.id')
                                ->join('users','user_id','=','users.id')
                                ->join('yt_questionstatuses','questionstatus_id','=','yt_questionstatuses.id')
                                ->Where('yt_questions.ext_id',$ext_id)->first();
*/
         $question = YtQuestion::Where('ext_id',$ext_id)->first();
         
         return $question;
            
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
    public function update(Request $request, $ext_id)
    {
       try
        {
         $input = $request->getContent();
         $data  = json_decode($input);
         
         $question = YtQuestion::Where('ext_id',$ext_id)->first();

         if($question == null) return response()->json(['error' =>'404']);              

         $question->question = $data->question;
         $question->save();
      
         return response()->json(['ext_id' =>$question->ext_id]);              
            
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
    public function destroy($ext_id)
    {
         try
        {
         
         $question = YtQuestion::Where('ext_id',$ext_id)->first();

         if($question == null) return response()->json(['error' =>'404']);              

         $question->delete();
      
         return response()->json(['ext_id' =>$question->ext_id]);              
            
        }   
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
        }
    }
}
