<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use DB;

class MailController extends Controller
{
    public function send(Request $request){

    
        $id = $request->input('id');
        $results= DB::select('SELECT CONCAT(strMemFname," ",strMemLname) AS Name, strMemPasscode , md5(strMemPasscode) AS Passcode, strMemEmail FROM tblMember WHERE strMemberId = ?',[$id] );
        foreach($results as $result) {
            $Fname = $result->Name;
            $Passcode = $result->Passcode;
            $Tpasscode = $result->strMemPasscode;
        }
        Mail::send('members.email', ['name'=>$Fname, 'Enpass'=> $Passcode , 'Tpass'=> $Tpasscode], function($message) use ($results){
                foreach($results as $value){
                    $email = $value->strMemEmail;
                    break;
                }
                $message->to("$email")->subject('iVote++ Passcode!');
        });

        

    }
}
