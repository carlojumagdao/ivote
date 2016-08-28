<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GenSet AS GenSet;
use Validator;
use DB;
use Redirect;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class gensetController extends Controller
{
    public function index(){
        

    	$Settings = DB::table('tblSetting')->select('*')->get();
    	foreach ($Settings as $value) {
    		$strElecName = $value->strSetElecName;
    		$strElecDesc = $value->strSetElecDesc;
    		$datStart = $value->datSetStart;
    		$datEnd = $value->datSetEnd;
    		$blSurvey = $value->blSetSurvey;
    		$blParty = $value->blSetParty;
            $strHeaders = $value->strHeader;
            $strAddress = $value->strSetAddress;
            $blSetPublish = $value->blSetPublish;
            $LogoPic = $value->txtSetLogo;
            /*$strSetLogo = $value->txtSetLogo;*/
    	}
         return view('Settings.general', ['strElecName' => $strElecName,'strElecDesc' => $strElecDesc,'datStart' => $datStart,'datEnd' => $datEnd, 'blSurvey' => $blSurvey,'blParty' => $blParty, 'strHeaders' => $strHeaders , 'LogoPic'=>$LogoPic, 'strSetAddress' => $strAddress, 'blSetPublish'=>$blSetPublish]);
    }
    public function save(Request $request){

        // var_dump($_POST);  
    	$rules = array(
			'txtElectionTitle' => 'required',
			// 'txtElectionDesc' => 'required',
            'txtSchedule' => 'required',
            'txtHeader' => 'required',
            'logo' => 'mimes:jpeg,jpg,png,bmp|max:10000',
		);
		$messages = [
		    'required' => 'The :attribute field is required.',
		];
		$niceNames = array(
		    'txtElectionTitle' => 'Election Title',
			'txtElectionDesc' => 'Election Description',
            'txtSchedule' => 'Schedule',
            'txtHeader' => 'Header'
		);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } 
        else{
            $date = $request->input('txtSchedule'); // MM/DD/YYYY 12:00 AM-MM/DD/YYYY 12:00 PM
            $pieces = explode("-", $date); // $pieces[0] = MM/DD/YYYY 12:00 AM 
                                           // $pieces[1] = MM/DD/YYYY 12:00 PM
            $startdatetime = explode(" ", $pieces[0]); 
                                            // $startdatetime[0] = MM/DD/YYYY 
                                            // $startdatetime[1] = 12:00 
                                            // $startdatetime[2] = AM
            
            $timeStartPart = explode(":", $startdatetime[1]); //$timeStartPart[0] = HH // $timeStartPart[1] = MM
            $finaltimestart =  0;
            if ($startdatetime[2]=='PM')
            {       
                    if($timeStartPart[0] == 12){
                        $sum = $timeStartPart[0];
                        $finaltimestart = "$sum:$timeStartPart[1]";
                    }
                    else{
                        $sum = 12+$timeStartPart[0];
                        $finaltimestart = "$sum:$timeStartPart[1]";
                    }
                
            }
            else 
            {    
                if($timeStartPart[0] == 12){
                        $sum = $timeStartPart[0]-12;
                        $finaltimestart = "$sum:$timeStartPart[1]";  
                }
                else{
                    $sum = $timeStartPart[0];
                    $finaltimestart = "$sum:$timeStartPart[1]";
                }
            }
            

            $startdate = explode("/", $startdatetime[0]);// $startdate[0] = MM // $startdate[1] = DD // $startdate[2] = YYYY
            $finalStartdate = "$startdate[2]-$startdate[0]-$startdate[1]";
            $finalStartDateTime = "$finalStartdate $finaltimestart";
            $finalStartDateTime = date_create($finalStartDateTime);
            var_dump($finalStartDateTime);
            $enddatetime = explode(" ", $pieces[1]); 
                                            // $enddatetime[0] = MM/DD/YYYY
                                            // $enddatetime[1] = 12:00
                                            // $enddatetime[2] = AM
            $timeEndPart = explode(":", $enddatetime[1]); //$timeStartPart[0] = 12 // $timeStartPart[1] = 00
            $finaltimeEnd = 0;
            if ($enddatetime[2]=='PM')
            {  
                if($timeEndPart[0] == 12){
                    $sum = $timeEndPart[0];
                    $finaltimeEnd = "$sum:$timeEndPart[1]";
                }
                else{
                    $sum = 12 + $timeEndPart[0];
                    $finaltimeEnd = "$sum:$timeEndPart[1]";
                }
                
            }
            else {
                
                if($timeEndPart[0] == 12){
                    $sum = $timeEndPart[0]-12;
                    $finaltimeEnd = "$sum:$timeEndPart[1]";
                }
                else{
                    $sum = $timeEndPart[0];
                    $finaltimeEnd = "$sum:$timeEndPart[1]";
                }
            }
            $enddate = explode("/", $enddatetime[0]);
                                            // $enddate[0] = MM // $enddate[1] = DD // $enddate[2] = YYYY
            $finalEnddate = "$enddate[2]-$enddate[0]-$enddate[1]";
            $finalEndDateTime = "$finalEnddate $finaltimeEnd";
            $finalEndDateTime = date_create($finalEndDateTime);
            var_dump($finalEndDateTime);

            //format of date for Data insertion YYYY-MM-DD
            if($request->file('logo') == null){
                try{
                    $GenSet = GenSet::find(1);
                    $GenSet->strSetElecName = $request->input('txtElectionTitle');
                    $GenSet->strSetElecDesc = $request->input('txtElectionDesc');
                    $GenSet->datSetStart = $finalStartDateTime;
                    $GenSet->datSetEnd = $finalEndDateTime;
                    $GenSet->blSetSurvey = $request->input('txtSurveyStatus');
                    $GenSet->blSetParty = $request->input('txtPartyStatus');
                    $GenSet->strSetAddress = $request->input('txtAddress');
                    $GenSet->strHeader = $request->input('txtHeader');
                    $GenSet->blSetPublish = $request->input('txtPublishStatus');
                    $GenSet->save();
                }catch (\Illuminate\Database\QueryException $e){
                    $errMess = $e->getMessage();
                    return Redirect::back()->withErrors($errMess);
                }
            }
        
            else if ($request->file('logo')->isValid()) {
                $destinationPath =  'assets/images/'; // upload path
                $extension = $request->file('logo')->getClientOriginalExtension(); // getting image extension
                $date = date("Ymdhis");
                $filename = $date.'-'.rand(111111,999999).'.'.$extension;
                $GenSet = GenSet::find(1);
                $request->file('logo')->move($destinationPath, $filename);
                $GenSet->txtSetLogo = $filename;
                $GenSet->strSetElecName = $request->input('txtElectionTitle');
                $GenSet->strSetElecDesc = $request->input('txtElectionDesc');
                $GenSet->datSetStart = $finalStartDateTime;
                $GenSet->datSetEnd = $finalEndDateTime;
                $GenSet->blSetSurvey = $request->input('txtSurveyStatus');
                $GenSet->blSetParty = $request->input('txtPartyStatus');
                $GenSet->strSetAddress = $request->input('txtAddress');
                $GenSet->strHeader = $request->input('txtHeader');
                $GenSet->blSetPublish = $request->input('txtPublishStatus');
                $GenSet->save();
            }
            else{
                return Redirect::back()->withErrors("uploaded file is not valid");
            }
        }
         // redirect
        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    }
    
    public function recaptcha(){
        

    	$Settings = DB::table('tblSetting')->select('*')->get();
    	foreach ($Settings as $value) {
            $txtSiteKey = $value->txtSiteKey;
            $txtSecret = $value->txtSecret;
            /*$strSetLogo = $value->txtSetLogo;*/
    	}
         return view('Settings.captcha', ['txtSiteKey' => $txtSiteKey,'txtSecret' => $txtSecret]);
    }
    
    public function recaptchaSave(Request $request){
        
        $GenSet = GenSet::find(1);
        $GenSet->txtSiteKey = $request->input('txtSiteKey');
        $GenSet->txtSecret = $request->input('txtSecret');
        $GenSet->save();
        
    	$Settings = DB::table('tblSetting')->select('*')->get();
    	foreach ($Settings as $value) {
            $txtSiteKey = $value->txtSiteKey;
            $txtSecret = $value->txtSecret;
            /*$strSetLogo = $value->txtSetLogo;*/
    	}
        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    }
}
