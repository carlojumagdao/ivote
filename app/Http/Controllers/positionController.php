<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position AS Position;
use App\PositionDetail AS PositionDetail;
use App\posFormEncoder AS posFormEncoder;
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
        $Positions = DB::table('tblPosition')->where('blPosDelete', '=', 0)->get();
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
        				->where('blPosDelete', '=', 0)
        				->orderBy('strPositionId')
        				->get();
        foreach ($PositionsId as $value) {
        	$id = $value->strPositionId;
        }
        $counter = new SmartCounter();
        $code = $counter->smartcounter($id);

        return view('Positions.addPosition', ['posForm' => $posForm, 'code' => $code]);
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
        }catch (\Illuminate\Database\QueryException $e){
            DB::rollBack();
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        //redirect
        $request->session()->flash('message', 'Successfully added.');    
        return Redirect::back();
    }
}
