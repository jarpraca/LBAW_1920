<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use App\Http\Controllers\Controller;

class MailController extends Controller {
   public function basic_email(Request $request) {
      $data = array('name'=>"Virat Gandhi");
   
      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to($request->input('email'), 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
         $message->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
      });
   }
}