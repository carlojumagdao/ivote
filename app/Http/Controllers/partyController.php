<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Party AS Party;
use Validator;
use Input;
use DB;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class partyController extends Controller
{
    public function index(){
    	$PartyStatus = DB::table('tblSetting')->where('blSetParty', '=', 1)->get();
    	if($PartyStatus){
    		$Party = DB::table('tblParty')->where('blPartyDelete', '=', 0)->get();
        	return view('Settings.party', ['Party' => $Party, 'intCounter'=>0]);
    	} else{
    		return view('Settings.partydisabled');
    	}
    	
    }
    public function add(Request $request){
    	$rules = array(
			'txtPartyName' => 'required',
			'txtPartyLeader' => 'required',
			'txtPartyColor' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,bmp|max:10000',
		);
		$messages = [
		    'required' => 'The :attribute field is required.',
		];
		$niceNames = array(
		    'txtPartyName' => 'Party Name',
		    'txtPartyLeader' => 'Party Leader',
		    'txtPartyColor' => 'Party Color',
		);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            
            $destinationPath =  'assets/images/'; // upload path
            $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
            $date = date("Ymdhis");
            $filename = $date.'-'.rand(111111,999999).'.'.$extension;
            
            $Party = new Party();
            $Party->strPartyName = $request->input('txtPartyName');
            $Party->strPartyLeader = $request->input('txtPartyLeader');
            $Party->strPartyColor = $request->input('txtPartyColor');
            
            if ($request->file('image')->isValid()) {
                $request->file('image')->move($destinationPath, $filename);
                $Party->txtPartyPic = $filename;
            }
           
            $Party->save();
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
			'txtPartyName' => 'required',
			'txtPartyLeader' => 'required',
			'txtPartyColor' => 'required'
		);
		$messages = [
		    'required' => 'The :attribute field is required.',
		];
		$niceNames = array(
		    'txtPartyName' => 'Party Name',
		    'txtPartyLeader' => 'Party Leader',
		    'txtPartyColor' => 'Party Color',
		);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            $destinationPath =  'assets/images/'; // upload path
            $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
            $date = date("Ymdhis");
            $filename = $date.'-'.rand(111111,999999).'.'.$extension;
        
            $Party = Party::find($request->input('txtPartyId'));
            $Party->strPartyName = $request->input('txtPartyName');
            $Party->strPartyLeader = $request->input('txtPartyLeader');
            $Party->strPartyColor = $request->input('txtPartyColor');
            
            if ($request->file('image')->isValid()) {
                $request->file('image')->move($destinationPath, $filename);
                $Party->txtPartyPic = $filename;
            }
            
            $Party->save();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back();
        }
        //redirect
        $request->session()->flash('message', 'Successfully updated.');    
        $Parties = DB::table('tblParty')->get();
        return view('Settings.party', ['Party' => $Parties, 'intCounter'=>0]);
    }
    public function delete(Request $request){
    	$id = $request->input("id");
    	$candidate = DB::table('tblCandidate')->where('intCandParId', '=', $id)->get();
        if($candidate){
            return Redirect::back()->withErrors("Cannot delete this record, because it is used by another record.");
        } else{           
            $Party = Party::find($id);
            $Party->blPartyDelete = 1;
            $Party->save();
        }
        //redirect
        $request->session()->flash('message', 'Successfully deleted.');  
        return Redirect::back();
    }
    
    public function editpage(Request $request){
        $id = $request->input('id');
        $party = DB::table('tblparty')->where('intPartyId', $id)->get();
        
        return view('Settings.partyEdit', ['party' => $party]);
        
    }
}
