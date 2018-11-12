<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Mail;

class SendMailController extends Controller
{
    //

    public function __construct()
    {
      //  $this->middleware('auth');
    }

   public function resetPassword(Request $request)
   {
		try {
			
	   	    $title   = "titulo";// $request->input('title');
          $content = ["contenido"];//$request->input('content');
          $to      = ["gsarmiento@yezzcorp.com", "guillermosarmiento@gmail.com"];
          $subject = "Reset Password";
/*          $msg =  Mail::send('public.email.resetpassword', ['title' => $title, 'content' => $content], function($message)
	         {
			    $message->from('yezztalk@sayyezz.com', 'YEZZTalk');

			    $message->to('gsarmiento@yezzcorp.com');

			 });   	    */
		//dd($msg);

        Mail::queue('public.email.resetpassword', $content, function ($message) use ($to, $subject,  $content) {
                $message->to($to)->subject($subject);
            });
           
           if (Mail::failures()) {
               return response()->json(['message' => Mail::failures()]);
          }
		
            //return response()->json(['message' => $msg]);


		} catch (Exception $e) {
            return response()->json(['message' => $e->message]);
		
		}

   }

}
