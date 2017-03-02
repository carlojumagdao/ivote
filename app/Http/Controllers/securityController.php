<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Security AS Security;
use Validator;
use DB;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Member AS Member;
use App\GenSet AS GenSet;


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
    
    public function createPage($id){
        $formDesign = DB::table('tblSetting')->select('strHeader','txtSetLogo')->get();
        foreach ($formDesign as $design) {
            $header = $design->strHeader;
            $logo = $design->txtSetLogo;
        }
        $SecQues = DB::table('tblSecurityQuestion')
        			->select('intSecQuesId','strSecQuestion')
        			->where('blSecQuesDelete', '=', 0)
        			->get();
        $GenSet = GenSet::find(1);
        $sitekey = $GenSet->txtSiteKey;
        return view('secquestion', ['header'=>$header, 'logo'=>$logo,'SecQues'=>$SecQues, 'id'=>$id, 'sitekey'=>$sitekey]);
    }
    
    public function setSecurity(Request $request, $id){
        $rules = array(
            'txtPasscode' => 'required',
			'secques' => 'required',
            'txtAnswer' => 'required',
		);
		$messages = [
		    'required' => 'The :attribute field is required.',
		];
		$niceNames = array(
		    'txtPasscode' => 'Passcode',
			'secques' => 'Security Question',
            'txtAnswer' => 'Answer',
		);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        
        try{
            $GenSet = GenSet::find(1);
            $txtSiteKey = $GenSet->txtSiteKey;
            $txtSecret = $GenSet->txtSecret;
            
            $SecQues = $request->input('secques');
            $Answer = $request->input('txtAnswer');
            $passcode = $request->input('txtPasscode');
            
            $member = DB::select('select CONCAT(strMemFname," ",strMemLname) as FullName from tblMember where strMemPasscode = ?', [$passcode]);
            if($member){
                $siteKey = $txtSiteKey;
                $secret = $txtSecret;
                // reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
                $lang = "en";

                // The response from reCAPTCHA
                $resp = null;
                // The error code from reCAPTCHA, if any
                $error = null;

                $recaptcha = new \ReCaptcha\ReCaptcha($secret);

                // Was there a reCAPTCHA response?  
                if(isset($_POST["g-recaptcha-response"])){
                    if ($_POST["g-recaptcha-response"]) {
                        $resp = $recaptcha->verify(
                            $_POST["g-recaptcha-response"],
                            $_SERVER["REMOTE_ADDR"]
                        );  
                    }
                
                
                if ($resp->isSuccess()) {
                    
                    if(md5($passcode) == $id){
                        $Member = Member::where("strMemPasscode", '=', $passcode)->first();
                        $Member->intMemSecQuesId = $SecQues;
                        $Member->strMemSecQuesAnswer = $Answer;
                        $Member->save();
                    }
                    
                    else{
                        $errMess = "Don't Use other's Passcode";
                        return Redirect::back()->withErrors($errMess); 
                    }
                        

                }
                        
                else {
                    $errMess = "Robot Detected!";
                    return Redirect::back()->withErrors($errMess); 
                }
            } else{
                $errMess = "Authentication Failed";
                return Redirect::back()->withErrors($errMess);
            }
            
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        $request->session()->flash('message', 'Security Question Successfully Set.');    
        return Redirect::route('LogInUser');  
    }
}
