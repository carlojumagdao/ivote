<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ui AS ui;
use Validator;
use Input;
use DB;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class UIController extends Controller
{
    /*public function index(){
    	$PartyStatus = DB::table('tblSetting')->where('blSetParty', '=', 1)->get();
    	if($PartyStatus){
    		$Party = DB::table('tblParty')->where('blPartyDelete', '=', 0)->get();
        	return view('Settings.party', ['Party' => $Party, 'intCounter'=>0]);
    	} else{
    		return view('Settings.partydisabled');
    	}
    	
    }*/
    public function add(Request $request){
    	$rules = array(
			'txtHeader' => 'required',
            'logo' => 'mimes:jpeg,jpg,png,bmp|max:10000',
		);
		$messages = [
		    'required' => 'The :attribute field is required.',
		];
		$niceNames = array(
		    'txtHeader' => 'Header'
		);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            
            $destinationPath =  'assets/images/'; // upload path
            $extension = $request->file('logo')->getClientOriginalExtension(); // getting image extension
            $date = date("Ymdhis");
            $filename = $date.'-'.rand(111111,999999).'.'.$extension;
            
            $ui = new ui();
            $ui->strHeader = $request->input('txtHeader');
            
            if ($request->file('logo')->isValid()) {
                $request->file('logo')->move($destinationPath, $filename);
                $ui->txtLogoPic = $filename;
            }
           
            $ui->save();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        //redirect
        $request->session()->flash('message', 'Successfully added.');    
        return Redirect::back();
    }
    
    
}
