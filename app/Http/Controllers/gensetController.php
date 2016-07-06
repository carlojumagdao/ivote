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
            $LogoPic = $value->txtSetLogo;
            /*$strSetLogo = $value->txtSetLogo;*/
    	}
        return view('Settings.general', ['strElecName' => $strElecName,'strElecDesc' => $strElecDesc,'datStart' => $datStart,'datEnd' => $datEnd,'blSurvey' => $blSurvey,'blParty' => $blParty, 'strHeaders' => $strHeaders , 'LogoPic'=>$LogoPic]);
    }
    public function save(Request $request){
                
    	$rules = array(
			'txtElectionTitle' => 'required',
			'txtElectionDesc' => 'required',
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
            $date = $request->input('txtSchedule');
            $pieces = explode("-", $date);
            $startdate = explode("/", $pieces[0]);
            $finalStartdate = "$startdate[2]-$startdate[0]-$startdate[1]";
            $enddate = explode("/", $pieces[1]);
            $finalEnddate = "$enddate[2]-$enddate[0]-$enddate[1]";
            
            if($request->file('logo') == null){
                try{
                    $GenSet = GenSet::find(1);
                    $GenSet->strSetElecName = $request->input('txtElectionTitle');
                    $GenSet->strSetElecDesc = $request->input('txtElectionDesc');
                    $GenSet->datSetStart = $finalStartdate;
                    $GenSet->datSetEnd = $finalEnddate;
                    $GenSet->blSetSurvey = $request->input('txtSurveyStatus');
                    $GenSet->blSetParty = $request->input('txtPartyStatus');
                    $GenSet->strHeader = $request->input('txtHeader');
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
                $GenSet->datSetStart = $finalStartdate;
                $GenSet->datSetEnd = $finalEnddate;
                $GenSet->blSetSurvey = $request->input('txtSurveyStatus');
                $GenSet->blSetParty = $request->input('txtPartyStatus');
                $GenSet->strHeader = $request->input('txtHeader');
                $GenSet->save();
            }
            else{
                return Redirect::back()->withErrors("uploaded file is not valid");
            }
        }
        //redirect
        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    }
}
