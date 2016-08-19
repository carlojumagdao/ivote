<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DynamicField AS DynamicField;
use App\formLoader AS formLoader;
use App\formEncoder AS formEncoder;
use App\viewFormEncoder AS viewFormEncoder;
use App\editFormEncoder AS editFormEncoder;
use App\Member AS Member;
use App\MemberDetail AS MemberDetail;
use App\SmartCounter AS SmartCounter;
use Validator;
use DB;
use Redirect;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class formController extends Controller
{
    
    public function index(){
        $Members = DB::table('tblMember')->get();
        return view('Members.index', ['Members' => $Members, 'intCounter'=>0]);
    } 
    public function view($id){
        $arrFieldName= array (' ');
        $arrFieldData= array (' ');
        $Members = DB::table('tblMember')
                    ->where('strMemberId', '=', $id)
                    ->where('blMemDelete', '=', 0)
                    ->get();
        foreach ($Members as $value) {
            $strMemFname = $value->strMemFname;
            $strMemMname = $value->strMemMname;
            $strMemLname = $value->strMemLname;
            $strMemEmail = $value->strMemEmail;
            $intMemSecId = $value->intMemSecQuesId;
            $strMemSecAnswer = $value->strMemSecQuesAnswer;
            $strMemPasscode = $value->strMemPasscode;
        }
        $Question = DB::table('tblSecurityQuestion')
                    ->where('intSecQuesId', '=', $intMemSecId)
                    ->where('blSecQuesDelete', '=', 0)
                    ->get();
        $strQuestion = "Not Set";
        foreach ($Question as $value) {
            $strQuestion = $value->strSecQuestion;
        }
        $data = DB::table('tblMemberDetail')
            ->join('tblDynamicField', 'tblMemberDetail.strMemDeFieldName', '=', 'tblDynamicField.strDynFieldName')
            ->select('tblMemberDetail.*')
            ->where('tblDynamicField.blDynStatus', '=', 1)
            ->where('tblMemberDetail.strMemDeMemId', '=', $id)
            ->get();
        $intFieldCounter = 0;
        foreach ($data as $value) {
            $arrFieldName[$intFieldCounter] = $value->strMemDeFieldName;
            $arrFieldData[$intFieldCounter] = $value->strMemDeFieldData;
            $intFieldCounter++;
        }
        $MemberForm = DB::table('tblMemberForm')->get();
        foreach ($MemberForm as $value) {
            $form = $value->strMemForm;
        }
        $edirLoader = new viewFormEncoder($form,'update',$id,$strMemFname,$strMemMname,$strMemLname,$strMemEmail,$arrFieldName,$arrFieldData);
        $viewForm = $edirLoader->render_form();
        return view('Members.viewMember', ['viewForm' => $viewForm,'strQuestion' => $strQuestion, 'strMemSecAnswer' => $strMemSecAnswer, 'strMemPasscode' => $strMemPasscode]);
    } 
    public function delete(Request $request){
        $id = $request->input("id");
        $candidate = DB::table('tblCandidate')
        ->where('strCandMemId', '=', $id)
        ->where('blCandDelete', '=', 0)
        ->get();
        if($candidate){
            return Redirect::back()->withErrors("Cannot delete this record, because it is used by another record.");
        } else{           
            $Member = Member::find($id);
            $Member->blMemDelete = 1;
            $Member->deleted_at = date("Y-m-d H:i:s");
            $Member->save();
        }
        //redirect
        $request->session()->flash('message', 'Successfully deleted.');  
        return Redirect::back();
    } 

    public function revert(Request $request){
        $id = $request->input("id");
        $candidate = DB::table('tblCandidate')->where('strCandMemId', '=', $id)->get();
          
        $Member = Member::find($id);
        $Member->blMemDelete = 0;
        $Member->deleted_at = "0000-00-00 00:00:00";
        $Member->save();
        
        //redirect
        $request->session()->flash('message', 'Member reverted.');  
        return Redirect::back();
    }

    public function edit($id){
        $arrFieldName= array (' ');
        $arrFieldData= array (' ');
        $Members = DB::table('tblMember')
                    ->where('strMemberId', '=', $id)
                    ->where('blMemDelete', '=', 0)
                    ->get();
        foreach ($Members as $value) {
            $strMemFname = $value->strMemFname;
            $strMemMname = $value->strMemMname;
            $strMemLname = $value->strMemLname;
            $strMemEmail = $value->strMemEmail;
            $intMemSecId = $value->intMemSecQuesId;
            $strMemSecAnswer = $value->strMemSecQuesAnswer;
            $strMemPasscode = $value->strMemPasscode;
        }
        $Question = DB::table('tblSecurityQuestion')
                    ->where('intSecQuesId', '=', $intMemSecId)
                    ->where('blSecQuesDelete', '=', 0)
                    ->get();
        $strQuestion = "Not Set";
        foreach ($Question as $value) {
            $strQuestion = $value->strSecQuestion;
        }
        $data = DB::table('tblMemberDetail')
            ->join('tblDynamicField', 'tblMemberDetail.strMemDeFieldName', '=', 'tblDynamicField.strDynFieldName')
            ->select('tblMemberDetail.*')
            ->where('tblDynamicField.blDynStatus', '=', 1)
            ->where('tblMemberDetail.strMemDeMemId', '=', $id)
            ->get();
        $intFieldCounter = 0;
        foreach ($data as $value) {
            $arrFieldName[$intFieldCounter] = $value->strMemDeFieldName;
            $arrFieldData[$intFieldCounter] = $value->strMemDeFieldData;
            $intFieldCounter++;
        }
        $MemberForm = DB::table('tblMemberForm')->get();
        foreach ($MemberForm as $value) {
            $form = $value->strMemForm;
        }
        $edirLoader = new editFormEncoder($form,'update',$id,$strMemFname,$strMemMname,$strMemLname,$strMemEmail,$arrFieldName,$arrFieldData);
        $editForm = $edirLoader->render_form();
        return view('Members.editMember', ['editForm' => $editForm,'strQuestion' => $strQuestion, 'strMemSecAnswer' => $strMemSecAnswer, 'strMemPasscode' => $strMemPasscode]);
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
        $loader = new formLoader($form_data, 'member.add'); // put the post url of the add member

        // $stmt = $conn -> query("SELECT strDynFieldName FROM tblDynamicField");
        $qrDynFieldsRows = DB::table('tblDynamicField')->select('strDynFieldName')->get();

        $arrFieldNames = $loader->render_form();
        $form_title = $loader->form_title();
        $form_title = trim($form_title);
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
                DB::table('tblMemberForm')->insert(['strMemFormTitle' => $form_title, 'strMemForm' => $form_data]);
                
                DB::update('UPDATE tblDynamicField SET blDynStatus = 0');

                foreach ($arrFieldNames as $strFieldname) {
                    if($strFieldname == "first_name" || $strFieldname == "last_name" || $strFieldname == "email" || $strFieldname == "middle_name" || $strFieldname == "member_id"){
                    } else {
                        $blFieldExist = false;
                        foreach ($qrDynFieldsRows as $qrDynFieldsRow) {
                            if($strFieldname == $qrDynFieldsRow->strDynFieldName){
                                $blFieldExist = true;
                                break;
                            }
                        }
                        if($blFieldExist){
                            DB::table('tblDynamicField')
                                ->where('strDynFieldname', $strFieldname)
                                ->update(['blDynStatus' => 1]);
                        } else{
                            DB::table('tblDynamicField')->insert([
                                ['strDynFieldName' => $strFieldname, 'blDynStatus' => $blStatus]
                            ]);
                        }
                    }
                }
                DB::commit();
            } catch(Exception $ex){
                DB::rollBack();
            }
        }

        if($strError == 1){
            return Redirect::back()->withErrors("Something went wrong.");
        } else{
            File::put("assets/memberform/src/json/example.json", $form_data);
            return redirect()->route('member.create'); // replace this with the url of add member
        }
    }


    public function create(){
        $formData = DB::table('tblMemberForm')->select('strMemForm','strMemFormTitle')->get();
        $strMemId = DB::table('tblMember')->select('strMemberId')->orderBy('strMemberId')->get();
        $strMemCode = "CODE000";
        foreach ($strMemId as $value) {
            $strMemCode = $value->strMemberId;
        }
        foreach ($formData as $form) {
            $data = $form->strMemForm;
            $formTitle = $form->strMemFormTitle;
        }
        $loader = new formEncoder($data, 'add');
        $form = $loader->render_form($strMemCode);
        return view('Members.addMember', ['form' => $form,'formTitle' => $formTitle]);
    }
    public function add(Request $request){
        $rules = array(
            'member_id' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'first_name' => 'required',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'member_id' => 'Member ID',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'first_name' => 'First Name'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            DB::beginTransaction();    
            $strPassCode = $this->fnGenerateCode();    
            $Member = new Member();
            $Member->strMemberID = $request->input('member_id');
            $Member->strMemFname = $request->input('first_name');
            $Member->strMemMname = $request->input('middle_name');
            $Member->strMemLname = $request->input('last_name');
            $Member->strMemEmail = $request->input('email');
            $Member->strMemPasscode = $strPassCode;
            $Member->save();
            foreach ($_POST as $key => $value) {
                if($key == "member_id" || $key == "last_name" || $key == "first_name" || $key == "email" || $key =="middle_name"){
                    
                    //nothing will happen...

                } else {
                    // if the field is checkbox, it will extract the array value
                    if(is_array($value)){
                        foreach ($value as $checked) {
                            $MemberDetail = new MemberDetail();
                            $MemberDetail->strMemDeMemId = $request->input('member_id');
                            $MemberDetail->strMemDeFieldName = $key;
                            $MemberDetail->strMemDeFieldData = $checked;
                            $MemberDetail->save();
                        }
                    }else{
                        $MemberDetail = new MemberDetail();
                        $MemberDetail->strMemDeMemId = $request->input('member_id');
                        $MemberDetail->strMemDeFieldName = $key;
                        $MemberDetail->strMemDeFieldData = $value;
                        $MemberDetail->save();
                    }
                }
            }
            DB::commit();
            $request->session()->flash('message', 'Successfully added.'); 
        } catch (\Illuminate\Database\QueryException $e){
            DB::rollBack();
            $strNewMemId = DB::table('tblMember')->select('strMemberId')->orderBy('strMemberId')->get();
            $strNewMemCode = "CODE000";
            foreach ($strNewMemId as $value) {
                $strNewMemCode = $value->strMemberId;
            }
            $counter = new SmartCounter();
            DB::beginTransaction();    
            $strPassCode = $this->fnGenerateCode();    
            $Member = new Member();
            $Member->strMemberID = $counter->smartcounter($strNewMemCode);
            $Member->strMemFname = $request->input('first_name');
            $Member->strMemMname = $request->input('middle_name');
            $Member->strMemLname = $request->input('last_name');
            $Member->strMemEmail = $request->input('email');
            $Member->strMemPasscode = $strPassCode;
            $Member->save();
            foreach ($_POST as $key => $value) {
                if($key == "member_id" || $key == "last_name" || $key == "first_name" || $key == "email" || $key =="middle_name"){
                    
                    //nothing will happen...

                } else {
                    // if the field is checkbox, it will extract the array value
                    if(is_array($value)){
                        foreach ($value as $checked) {
                            $MemberDetail = new MemberDetail();
                            $MemberDetail->strMemDeMemId = $counter->smartcounter($strNewMemCode);
                            $MemberDetail->strMemDeFieldName = $key;
                            $MemberDetail->strMemDeFieldData = $checked;
                            $MemberDetail->save();
                        }
                    }else{
                        $MemberDetail = new MemberDetail();
                        $MemberDetail->strMemDeMemId = $counter->smartcounter($strNewMemCode);
                        $MemberDetail->strMemDeFieldName = $key;
                        $MemberDetail->strMemDeFieldData = $value;
                        $MemberDetail->save();
                    }
                }
            }
            DB::commit();
            $request->session()->flash('message', 'Successfully added. ID already taken, new ID given.');
        } catch(\Exception $ex){
            DB::rollBack();
            $errMess = $ex->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        //redirect
        return Redirect::back();
    }

 
    public function update(Request $request){
        $rules = array(
            'member_id' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'first_name' => 'required',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'member_id' => 'Member ID',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'first_name' => 'First Name'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            DB::beginTransaction();      
            $Member = Member::find($request->input('member_id'));
            $Member->strMemFname = $request->input('first_name');
            $Member->strMemMname = $request->input('middle_name');
            $Member->strMemLname = $request->input('last_name');
            $Member->strMemEmail = $request->input('email');
            $Member->save();

            DB::table('tblMemberDetail')->where('strMemDeMemId', '=', $request->input('member_id'))->delete();

            foreach ($_POST as $key => $value) {
                if($key == "member_id" || $key == "last_name" || $key == "first_name" || $key == "email" || $key =="middle_name"){
                    
                    //nothing will happen...

                } else {
                    // if the field is checkbox, it will extract the array value
                    if(is_array($value)){
                        foreach ($value as $checked) {
                            $MemberDetail = new MemberDetail();
                            $MemberDetail->strMemDeMemId = $request->input('member_id');
                            $MemberDetail->strMemDeFieldName = $key;
                            $MemberDetail->strMemDeFieldData = $checked;
                            $MemberDetail->save();
                        }
                    }else{
                        $MemberDetail = new MemberDetail();
                        $MemberDetail->strMemDeMemId = $request->input('member_id');
                        $MemberDetail->strMemDeFieldName = $key;
                        $MemberDetail->strMemDeFieldData = $value;
                        $MemberDetail->save();
                    }
                }
            }
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e){
            DB::rollBack();
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        //redirect
        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    
    }
    public function fnGenerateCode($length = 6) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
}
