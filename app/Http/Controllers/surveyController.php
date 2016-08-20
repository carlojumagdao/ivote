<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\formLoader AS formLoader;
use App\formEncoder AS formEncoder;
use Validator;
use DB;
use Redirect;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SurveyHeader AS SurveyHeader;
use App\SurveyDetail AS SurveyDetail;
use Session;

class surveyController extends Controller
{
   	public function index(){
        $SurveyStatus = DB::table('tblSetting')->where('blSetSurvey', '=', 1)->get();
        if($SurveyStatus){
            return view('Survey.index');
        } else{
            return view('page-disabled');
        }
   		
   	}
   	public function save(Request $request){
        $formData = $request->input('formData');
        if( !$formData ) {
            throw new Exception("Error Processing Request", 1);
        }
        session(['formData' => $formData]);
    }
    public function render(){
        $blStatus = 1;
        $strError = 0; // to check if there is an error in the whole process.
        $formValue = session('formData');
        $form_data = isset($formValue) ? $formValue : FALSE;
        
        // unset($_SESSION['form_data']);

        if( !$form_data ) {
             return Redirect::back()->withErrors("Something went wrong: Check your input.");
        }
        $loader = new formLoader($form_data, 'survey.add'); // put the post url of the add member

        // $stmt = $conn -> query("SELECT strDynFieldName FROM tblDynamicField");
        $qrSurveyQuestions = DB::table('tblSurveyQuestion')->select('strSQQuestion')->get();

        $arrFieldNames = $loader->render_form();
        $arrElementType = $loader->getElementType();
        $form_title = $loader->form_title();
        $form_title = trim($form_title);
        $form_description = $loader->form_description();
        $blBlankField = false;
        $arrFieldTemp = $arrFieldNames;

        foreach ($arrFieldNames as $arrFieldName) {
            $arrFieldName = str_replace('_', ' ', strtolower($arrFieldName));
            $arrFieldName = trim($arrFieldName);

            //checking if there is any same field names
            $intCounter = 0;
            foreach ($arrFieldTemp as $strFieldTemp) {
                if($arrFieldName == $strFieldTemp){
                    $intCounter++;
                }
            }
            if($intCounter > 1){
                $blBlankField = true;
                break;
            }
            if(empty($arrFieldName)){
                $blBlankField = true;
                break;
            }
            $strFieldTemp = $arrFieldName;
        }

        if(empty($form_title)){
            $strError = 1;
            return Redirect::back()->withErrors("Do not leave blank form title.");
        } else if($blBlankField){
            $strError = 1;
            return Redirect::back()->withErrors("Do not leave blank/duplicate field label.");
        }else{
            try {
                DB::beginTransaction();
                DB::table('tblSurveyForm')->insert(['strSurveyFormTitle' => $form_title, 'strSurveyForm' => $form_data, 'strSurveyFormDesc' => $form_description]);
                
                DB::update('UPDATE tblSurveyQuestion SET blSQStatus = 0');
                $intCounter = 0;
                foreach ($arrFieldNames as $strFieldname) {
                    $blFieldExist = false;
                    foreach ($qrSurveyQuestions as $qrSurveyQuestion) {
                        if($strFieldname == $qrSurveyQuestion->strSQQuestion){
                            $blFieldExist = true;
                            break;
                        }
                    }
                    if($blFieldExist){
                        DB::table('tblSurveyQuestion')
                            ->where('strSQQuestion', $strFieldname)
                            ->update(['blSQStatus' => 1, 'strSQQuesType' => $arrElementType[$intCounter]]);
                    } else{
                        DB::table('tblSurveyQuestion')->insert([
                            ['strSQQuestion' => $strFieldname, 'strSQQuesType' => $arrElementType[$intCounter], 'blSQStatus' => $blStatus]
                        ]);
                    }
                    $intCounter++;
                }
                DB::commit();
            } catch(Exception $ex){
                DB::rollBack();
            }
        }

        if($strError == 1){
            return Redirect::back()->withErrors("Something went wrong.");
        } else{
            File::put("assets/surveyform/src/json/example.json", $form_data);
            return redirect()->route('survey.view'); 
        }
    }
    public function view(){
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
            $loader = new formEncoder($data, ' ');
            $form = $loader->render_form("001"); // 001 is just to have a value
            return view('Survey.view', ['form' => $form,'formTitle' => $formTitle,'formDesc' =>$formDesc, 'header'=>$header, 'logo'=>$logo]);
        } else{
            return view('page-disabled');
        }
        
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
            $loader = new formEncoder($data, 'answer');
            $form = $loader->render_form("001"); // 001 is just to have a value
            return view('Survey.survey', ['form' => $form,'formTitle' => $formTitle,'formDesc' =>$formDesc, 'header'=>$header, 'logo'=>$logo]);
        } else{
            return view('page-disabled');
        }
    }
    
    public function answer(Request $request){
        $memid = session('memid');
        try{
            DB::beginTransaction(); 
            
            $SurveyHeader = new SurveyHeader();
            $SurveyHeader->strSHMemCode = $memid;
            $SurveyHeader->save();
            
            $SH = SurveyHeader::where('strSHMemCode', "=", $memid)->first();
            $SHID = $SH->intSHId;
            
                
            foreach ($_POST as $key => $value) {
                
                // if the field is checkbox, it will extract the array value
                $question = DB::table('tblsurveyquestion')->where('strSQQuestion', "=", $key)->where('blSQStatus', "=", 1)->get();
                $id =  $question[0]->intSQId;
                
                if(is_array($value)){
                    foreach ($value as $checked) {
                        $SurveyDetail = new SurveyDetail();
                        $SurveyDetail->intSDSHId = $SHID;
                        $SurveyDetail->intSDSQId = $id;
                        $SurveyDetail->strSDAnswer= $checked;
                        $SurveyDetail->save();
                    }
                } else{
                    $SurveyDetail = new SurveyDetail();
                    $SurveyDetail->intSDSHId = $SHID;
                    $SurveyDetail->intSDSQId = $id;
                    $SurveyDetail->strSDAnswer= $value;
                    $SurveyDetail->save();
                } 
            }
            DB::commit();
        
        } catch (\Illuminate\Database\QueryException $e){
            DB::rollBack();
            $errMess = $e->getMessage();
            echo $errMess;
        }

        //clear user sessions
        $votereference = session('votereference');
        if(Session::has('memid')) Session::forget('memid');
        if(Session::has('votereference')) Session::forget('memid');

        //redirect to realtime voting result
        return Redirect::route('thanks');
        /*return Redirect::route('thanksSurvey');*/
    }
}
