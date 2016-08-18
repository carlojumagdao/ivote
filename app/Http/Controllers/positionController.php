<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position AS Position;
use App\PositionDetail AS PositionDetail;
use App\posFormEncoder AS posFormEncoder;
use App\editPosFormEncoder AS editPosFormEncoder;
use App\SmartCounter AS SmartCounter;
use Validator;
use DB;
use Redirect;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class positionController extends Controller
{
    public function index(){
        $Positions = DB::table('tblPosition')->get();
        return view('Positions.index', ['Positions' => $Positions, 'intCounter'=>0]);
    } 
    public function create(){
    	$MemberForm = DB::table('tblMemberForm')->get();
        foreach ($MemberForm as $value) {
            $form = $value->strMemForm;
        }
        $posLoader = new posFormEncoder($form,'update'); // url of create position
        $posForm = $posLoader->render_form();

        $PositionsId = DB::table('tblPosition')
        				->select('strPositionId')
        				->orderBy('strPositionId')
        				->get();
        $id = "POS000";
        foreach ($PositionsId as $value) {
        	$id = $value->strPositionId;
        }
        $counter = new SmartCounter();
        $code = $counter->smartcounter($id);

        return view('Positions.addPosition', ['posForm' => $posForm, 'code' => $code]);
    }

    public function revert(Request $request){
        $id = $request->input("id");
        $Positions = DB::table('tblPosition')->where('strPositionId', '=', $id)->get();
          
            $Position = Position::find($id);
            $Position->blPosDelete = 0;
            $Position->deleted_at = "0000-00-00 00:00:00";
            $Position->save();
        
        //redirect
        $request->session()->flash('message', 'Position reverted.');  
        return Redirect::back();
    }

    public function update(Request $request){
    	$rules = array(
            'txtPositionId' => 'required',
            'txtPositionName' => 'required',
            'txtVoteLimit' => 'required|integer|between:1,100',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
            'between' => 'The :attribute field must be between :min - :max.',
        ];
        $niceNames = array(
            'txtPositionId' => 'Position ID',
            'txtPositionName' => 'Position Name',
            'txtVoteLimit' => 'Vote Limit',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            DB::beginTransaction();    
            $Position = Position::find($request->input('txtPositionId'));
            $Position->strPosName = $request->input('txtPositionName');
            $Position->strPosColor = $request->input('txtPositionColor');
            $Position->intPosVoteLimit = $request->input('txtVoteLimit');
            $Position->save();

            DB::table('tblPositionDetail')->where('strPosDePosId', '=', $request->input('txtPositionId'))->delete();
            if($request->delReference){
	    		//
	    	} else{
	    		foreach ($_POST as $key => $value) {

	                if($key == "btnSubmit" || $key == "txtPositionId" || $key == "txtPositionName" || $key == "txtVoteLimit" || $key == "txtPositionColor"){
	                    
	                    //nothing will happen...

	                } else {
	                    // if the field is checkbox, it will extract the array value
	                    if(is_array($value)){
	                        foreach ($value as $checked) {
	                            $PositionDetail = new PositionDetail();
	                            $PositionDetail->strPosDePosId = $request->input('txtPositionId');
	                            $PositionDetail->strPosDeFieldName = $key;
	                            $PositionDetail->strPosDeFieldData = $checked;
	                            $PositionDetail->save();
	                        }
	                    }else{
	                        $PositionDetail = new PositionDetail();
	                        $PositionDetail->strPosDePosId = $request->input('txtPositionId');
	                        $PositionDetail->strPosDeFieldName = $key;
	                        $PositionDetail->strPosDeFieldData = $value;
	                        $PositionDetail->save();
	                    }
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

    public function edit($id){
    	$arrFieldName= array (' ');
		$arrFieldData= array (' ');
    	$MemberForm = DB::table('tblMemberForm')->get();
        foreach ($MemberForm as $value) {
            $form = $value->strMemForm;
        }
    	$Position = DB::table('tblPosition')
                    ->where('strPositionId', '=', $id)
                    ->where('blPosDelete', '=', 0)
                    ->get();
        foreach ($Position as $value) {
        	$strPositionId = $value->strPositionId;
	    	$strPosName = $value->strPosName;
	    	$strPosColor = $value->strPosColor;
	    	$intVoteLimit = $value->intPosVoteLimit;
	    }

	    $data = DB::table('tblPositionDetail')
            ->join('tblDynamicField', 'tblPositionDetail.strPosDeFieldName', '=', 'tblDynamicField.strDynFieldName')
            ->select('tblPositionDetail.*')
            ->where('tblDynamicField.blDynStatus', '=', 1)
            ->where('tblPositionDetail.strPosDePosId', '=', $id)
            ->get();

        $intFieldCounter = 0;
        foreach ($data as $value) {
            $arrFieldName[$intFieldCounter] = $value->strPosDeFieldName;
            $arrFieldData[$intFieldCounter] = $value->strPosDeFieldData;
            $intFieldCounter++;
        }
        $editLoader = new editPosFormEncoder($form,'update',$arrFieldName,$arrFieldData);
        $editForm = $editLoader->render_form();
        return view('Positions.editPosition', ['editForm' => $editForm,'strPositionId' => $strPositionId, 'strPosName' => $strPosName, 'strPosColor' => $strPosColor,'intVoteLimit' => $intVoteLimit]);
    }
    public function delete(Request $request){
        $id = $request->input("id");
        $candidate = DB::table('tblCandidate')
            ->where('strCandPosId', '=', $id)
            ->where('blCandDelete', '=', 0)
            ->get();
        if($candidate){
            return Redirect::back()->withErrors("Cannot delete this record, because it is used by another record.");
        } else{           
            $Position = Position::find($id);
            $Position->blPosDelete = 1;
            $Position->deleted_at = date("Y-m-d H:i:s");
            $Position->save();
        }
        //redirect
        $request->session()->flash('message', 'Successfully deleted.');  
        return Redirect::back();
    }
    public function add(Request $request){
    	$rules = array(
            'txtPositionId' => 'required',
            'txtPositionName' => 'required',
            'txtVoteLimit' => 'required|integer|between:1,100',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
            'between' => 'The :attribute field must be between :min - :max.',
        ];
        $niceNames = array(
            'txtPositionId' => 'Position ID',
            'txtPositionName' => 'Position Name',
            'txtVoteLimit' => 'Vote Limit',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            DB::beginTransaction();    
            $Position = new Position();
            $Position->strPositionID = $request->input('txtPositionId');
            $Position->strPosName = $request->input('txtPositionName');
            $Position->strPosColor = $request->input('txtPositionColor');
            $Position->intPosVoteLimit = $request->input('txtVoteLimit');
            $Position->save();
            foreach ($_POST as $key => $value) {

                if($key == "btnSubmit" || $key == "txtPositionId" || $key == "txtPositionName" || $key == "txtVoteLimit" || $key == "txtPositionColor"){
                    
                    //nothing will happen...

                } else {
                    // if the field is checkbox, it will extract the array value
                    if(is_array($value)){
                        foreach ($value as $checked) {
                            $PositionDetail = new PositionDetail();
                            $PositionDetail->strPosDePosId = $request->input('txtPositionId');
                            $PositionDetail->strPosDeFieldName = $key;
                            $PositionDetail->strPosDeFieldData = $checked;
                            $PositionDetail->save();
                        }
                    }else{
                        $PositionDetail = new PositionDetail();
                        $PositionDetail->strPosDePosId = $request->input('txtPositionId');
                        $PositionDetail->strPosDeFieldName = $key;
                        $PositionDetail->strPosDeFieldData = $value;
                        $PositionDetail->save();
                    }
                }
            }
            DB::commit();
            $request->session()->flash('message', 'Successfully added.');    
        }catch (\Illuminate\Database\QueryException $e){
            DB::rollBack();
            /*$errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);*/
            $PositionsId = DB::table('tblPosition')
                ->select('strPositionId')
                ->orderBy('strPositionId')
                ->get();
            $id = "POS000";
            foreach ($PositionsId as $value) {
                $Newid = $value->strPositionId;
            }
            $counter = new SmartCounter();
            DB::beginTransaction();    
            $Position = new Position();
            $Position->strPositionID = $counter->smartcounter($Newid);
            $Position->strPosName = $request->input('txtPositionName');
            $Position->strPosColor = $request->input('txtPositionColor');
            $Position->intPosVoteLimit = $request->input('txtVoteLimit');
            $Position->save();
            foreach ($_POST as $key => $value) {

                if($key == "btnSubmit" || $key == "txtPositionId" || $key == "txtPositionName" || $key == "txtVoteLimit" || $key == "txtPositionColor"){
                    
                    //nothing will happen...

                } else {
                    // if the field is checkbox, it will extract the array value
                    if(is_array($value)){
                        foreach ($value as $checked) {
                            $PositionDetail = new PositionDetail();
                            $PositionDetail->strPosDePosId = $counter->smartcounter($Newid);
                            $PositionDetail->strPosDeFieldName = $key;
                            $PositionDetail->strPosDeFieldData = $checked;
                            $PositionDetail->save();
                        }
                    }else{
                        $PositionDetail = new PositionDetail();
                        $PositionDetail->strPosDePosId = $counter->smartcounter($Newid);
                        $PositionDetail->strPosDeFieldName = $key;
                        $PositionDetail->strPosDeFieldData = $value;
                        $PositionDetail->save();
                    }
                }
            }
            DB::commit();
            $request->session()->flash('message', 'Successfully added. ID already taken, new ID given.');
        }
        //redirect
        return Redirect::back();
    }
}
