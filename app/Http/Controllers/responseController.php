<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\formEncoder AS formEncoder;
use App\SurveyHeader AS SurveyHeader;
use App\SurveyDetail AS SurveyDetail;
use DB;
use App\GenSet AS GenSet;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class responseController extends Controller
{
	public function LogInUser(){
        if(Session::has('memid')) Session::forget('memid');
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
    	$start = date_create($GenSet->datSetStart);
        $nowNoTime = date_create(date("Y-m-d"));
        $now = date_create(date("Y-m-d H:i:s"));
        
        if(date_diff($nowNoTime, $start)->d > 0) return Redirect::route('Countdown');
    	else return view('LogInUser', ['header'=>$header, 'logo'=>$logo,'SecQues'=>$SecQues]);
    }
    public function Validation(Request $request){
       return Redirect::route('voting.page');
    }
    public function survey(){
    	$SurveyStatus = DB::table('tblSetting')->where('blSetSurvey', '=', 1)->get();
        if($SurveyStatus){
            $formData = DB::table('tblSurveyForm')->select('strSurveyForm','strSurveyFormTitle','strSurveyFormDesc')->get();
            $formDesign = DB::table('tblSetting')->select('strHeader','txtSetLogo')->get();
            foreach ($formDesign as $design) {
                $header = $design->strHeader;
                $logo = $design->txtSetLogo;
            }
            foreach ($formData as $form) {
                $data = $form->strSurveyForm;
                $formTitle = $form->strSurveyFormTitle;
                $formDesc = $form->strSurveyFormDesc;
            }
            $loader = new formEncoder($data, '/survey/add');
            $form = $loader->render_form("001"); // 001 is just to have a value
            return view('Response.survey', ['form' => $form,'formTitle' => $formTitle,'formDesc' =>$formDesc, 'header'=>$header, 'logo'=>$logo]);
        }
    }

    public function postsurvey(Request $request){
    	
    	try{
            DB::beginTransaction();  

            $SurveyHeader = new SurveyHeader();
            $SurveyHeader->strSHMemCode = session('memid');
            $SurveyHeader->save();

            $SurveyId = DB::table('tblSurveyHeader')->get();
            foreach ($SurveyId as $value) {
            	$SurveyHeaderId = $value->intSHId;
            }

            foreach ($_POST as $key => $value) {
                // if the field is checkbox, it will extract the array value
                if(is_array($value)){
                    foreach ($value as $checked) {
                        $SurveyDetail = new SurveyDetail();
                        $SurveyDetail->intSDSHId = $SurveyHeaderId;
                        $SurveyDetail->strSDSQ = $key;
                        $SurveyDetail->strSDAnswer = $checked;
                        $SurveyDetail->save();
                    }
                }else{
                    $SurveyDetail = new SurveyDetail();
                    $SurveyDetail->intSDSHId = $SurveyHeaderId;
                    $SurveyDetail->strSDSQ = $key;
                    $SurveyDetail->strSDAnswer = $value;
                    $SurveyDetail->save();
                }
            }
            DB::commit();
            echo "Success | Redirect to thank you page.";
        }catch (\Illuminate\Database\QueryException $e){
            DB::rollBack();
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
    }
}
