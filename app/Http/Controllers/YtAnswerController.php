<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\YtAnswer;
use App\YtQuestion;

class YtAnswerController extends Controller
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
         $question_ext_id = $request->input('question');
               
         $question = YtQuestion::Join('users','user_id','=','users.id')
                              ->Where('ext_id',$question_ext_id)->first();
         
         $answers = YtAnswer::Where('yt_question_id',$question->id)->get();

         return $answers;
            
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
         
         $user      = User::Where('username',$data->username)->first();
         $question  = YtQuestion::Where('ext_id',$data->question)->first();
         $parent_id    = $data->parent == 0 ? $data->parent : YtAnswer::Where('ext_id',$data->parent)->first()->id;

         if($question == null || $user == null) return response()->json(['error' =>'404']);              

         $answer = YtAnswer::create(
            [
             'user_id'     => $user->id,
             'ext_id'      => str_random(20),
             'yt_question_id' => $question->id,
             'answer'      => $data->answer,
             'parent_id'   => $parent_id
          ]);

         return response()->json(['ext_id' =>$answer->ext_id]);              
            
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
        //
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
         
         $answer = YtAnswer::Where('ext_id',$ext_id)->first();

         if($answer == null) return response()->json(['error' =>'404']);              

         return $answer;
            
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

         $answer = YtAnswer::Where('ext_id',$ext_id)->first();

         if($answer == null) return response()->json(['error' =>'404']);              

         $answer->answer = $data->answer;
         $answer->save();

         return response()->json(['ext_id' =>$answer->ext_id]);              
            
        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
        }
    }


   public function rate(Request $request, $ext_id)
    {
        try
        {
         
         $type = $request->input('type');

         $answer = YtAnswer::Where('ext_id',$ext_id)->first();

         if($answer == null) return response()->json(['error' =>'404']);              

        switch ($type) {
            case 'positive':
                $value = $answer->positive + 1;
                $answer->positive = $value;
                break;
            
            case 'negative':
                $value = $answer->negative + 1;
                $answer->negative = $value;
            break;
            default:
                return response()->json(['error' =>'400']);              
                break;
        }

         $answer->save();

         return response()->json(['value' =>$value]);              
            
        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
        }
    }

    public function report(Request $request, $ext_id)
    {
        try
        {
         

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
         
         $answer = YtAnswer::Where('ext_id',$ext_id)->first();

         if($answer == null) return response()->json(['error' =>'404']);              

         $answer->delete();

         return response()->json(['ext_id' =>$answer->ext_id]);              
            
        } 
        catch(\Exception $e){
            return response()->json(['error' =>'500', 'message' => $e]);              
        }
    }
}
