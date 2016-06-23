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
    	}
        return view('Settings.general', ['strElecName' => $strElecName,'strElecDesc' => $strElecDesc,'datStart' => $datStart,'datEnd' => $datEnd,'blSurvey' => $blSurvey,'blParty' => $blParty]);
    }
    public function save(Request $request){
    	$rules = array(
			'txtElectionTitle' => 'required',
			'txtElectionDesc' => 'required',
            // 'txtSchedule' => 'required', Manipulate the string of the field.
		);
		$messages = [
		    'required' => 'The :attribute field is required.',
		];
		$niceNames = array(
		    'txtElectionTitle' => 'Election Title',
			'txtElectionDesc' => 'Election Description',
            'txtSchedule' => 'Schedule',
		);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            $GenSet = GenSet::find(1);
            $GenSet->strSetElecName = $request->input('txtElectionTitle');
            $GenSet->strSetElecDesc = $request->input('txtElectionDesc');
            // $GenSet->datSetStart = $request->input('txtSchedule');
            // $GenSet->datSetEnd = $request->input('txtSchedule');
            $GenSet->blSetSurvey = $request->input('txtSurveyStatus');
            $GenSet->blSetParty = $request->input('txtPartyStatus');
            $GenSet->save();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        //redirect
        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    }
}
