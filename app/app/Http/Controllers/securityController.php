<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Security AS Security;
use Validator;
use DB;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class securityController extends Controller
{
    public function index(){
    	$secQues = DB::table('tblSecurityQuestion')->where('blSecQuesDelete', '=', 0)->get();
        return view('Settings.security', ['secQues' => $secQues, 'intCounter'=>0]);
    }
    public function add(Request $request){
    	$rules = array(
			'txtSecurityQuestion' => 'required',
		);
		$messages = [
		    'required' => 'The :attribute field is required.',
		];
		$niceNames = array(
		    'txtSecurityQuestion' => 'Security Question',
		);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            $Security = new Security();
            $Security->strSecQuestion = $request->input('txtSecurityQuestion');
            $Security->save();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        //redirect
        $request->session()->flash('message', 'Successfully added.');    
        return Redirect::back();
    }
    public function update(Request $request){
    	$rules = array(
			'txtSecurityQuestion' => 'required',
		);
		$messages = [
		    'required' => 'The :attribute field is required.',
		];
		$niceNames = array(
		    'txtSecurityQuestion' => 'Security Question',
		);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            $Security = Security::find($request->input('txtSecurityQuestionId'));
            $Security->strSecQuestion = $request->input('txtSecurityQuestion');
            $Security->save();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        //redirect
        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    }
    public function delete(Request $request){
    	$id = $request->input("id");
    	$member = DB::table('tblMember')->where('intMemSecQuesId', '=', $id)->get();
        if($member){
            return Redirect::back()->withErrors("Cannot delete this record, because it is used by another record.");
        } else{           
            $Security = Security::find($id);
            $Security->blSecQuesDelete = 1;
            $Security->save();
        }
        //redirect
        $request->session()->flash('message', 'Successfully deleted.');  
        return Redirect::back();
    }
}
