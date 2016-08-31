<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\GenSet AS GenSet;
use App\Candidate AS Candidate;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SmartCounter AS SmartCounter;
use Validator;
use Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class candidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $GenSet = GenSet::find(1);
        $start = date_create($GenSet->datSetStart);
        $end = date_create($GenSet->datSetEnd);
        $nowNoTime = date_create(date("Y-m-d"));
        $now = date_create(date("Y-m-d H:i:s"));
        if(($now >= $start) & ($now <= $end)){
            $ongoing = 1;
        }
        else{
            $ongoing = 0;
        }

        $PartyStatus = DB::table('tblSetting')->where('blSetParty', '=', 1)->get();
             $candidates = DB::table('tblcandidate')
            ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
            ->join('tblposition', 'tblcandidate.strCandPosId', '=', 'tblposition.strPositionId')
            ->join('tblparty', 'tblcandidate.intCandParId', '=', 'tblparty.intPartyId')
            ->where('blCandDelete', '=', 0)
            ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname', 'tblposition.strPosName', 'tblparty.strPartyName')->get();
    
        return view('Candidate.candidate', ['candidates' => $candidates, 'intCounter'=>0, 'party' => $PartyStatus, 'electionStatus'=>$ongoing]);
        
        $candidates = DB::table('tblcandidate')
        ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
        ->join('tblposition', 'tblcandidate.strCandPosId', '=', 'tblposition.strPositionId')
        ->join('tblparty', 'tblcandidate.intCandParId', '=', 'tblparty.intPartyId')
        ->where('blCandDelete','=', 0)
        ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname', 'tblposition.strPosName', 'tblparty.strPartyName')->get();
        $strCandEducBackg = "";
        $strCandInfor = "";
        foreach ($candidates as $value) 
            {
                $strCandEducBackg = $value->strCandEducBack;
                $strCandInfor = $value->strCandInfo;
            }        
        return view('Candidate.candidate', ['candidates' => $candidates, 'intCounter'=>0, 'party' => $PartyStatus, 'strCandEducBackg' => 
                $strCandEducBackg , 'strCandInfor' => $strCandInfor,'electionStatus'=>$ongoing]);
    }

    public function add()
    {
        $GenSet = GenSet::find(1);
        $start = date_create($GenSet->datSetStart);
        $end = date_create($GenSet->datSetEnd);
        $nowNoTime = date_create(date("Y-m-d"));
        $now = date_create(date("Y-m-d H:i:s"));
        
        $PartyStatus = DB::table('tblSetting')->where('blSetParty', '=', 1)->get();
        if($PartyStatus){
            $Members = DB::table('tblmember')->select('strMemberId', 'strMemFname', 'strMemLname', 'strMemMname')->where('blMemDelete', '=', 0)->get();
            $Positions = DB::table('tblposition')
            ->select('strPositionId', 'strPosName')
            ->where('blPosDelete', '=', 0)
            ->get();
            $Parties = DB::table('tblparty')->select('intPartyId', 'strPartyName')->get();
            if(($now >= $start) & ($now <= $end)){ 
                return view('election-page-disabled');
            }
            else{
                return view('Candidate.add', ['Members' => $Members, 'Positions' => $Positions, 'Parties'=> $Parties]);
            }
        }
        else{
            
            $Members = DB::table('tblmember')->select('strMemberId', 'strMemFname', 'strMemLname', 'strMemMname')->where('blMemDelete', '=', 0)->get();
            $Positions = DB::table('tblposition')->select('strPositionId', 'strPosName')->where('blPosDelete', '=', 0)->get();
            if(($now >= $start) & ($now <= $end)){ 
                return view('election-page-disabled');
            }
            else{
                return view('Candidate.addlessparty', ['Members' => $Members, 'Positions' => $Positions]);
            }
        }
    }
    
    public function newCandidate(Request $request){
       
       $rules = array(
			'member' => 'required',
			'position' => 'required',
            // 'txtEducback' => 'required',
            // 'txtinfo' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,bmp|max:50000',
		);
		$messages = [
		    'required' => 'The :attribute field is required.',
		];
		$niceNames = array(
		    'member' => 'Candidate Name',
		    'position' => 'Position',
            'educback' => 'Educational Background',
            'info' => 'Information',
		);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        
        try{
            $limit = 0;
            $countPos = 0;
            $position = $request->input('position');
            if ($request->has('party')) $party = $request->input('party');
            if ($request->has('party')) $partyName = DB::table('tblparty')
                                            ->where('intPartyId', "=", $party)
                                            ->select('strPartyName')
                                            ->get();
            if ($request->has('party') && $party != 1) $limit = DB::table('tblposition')->where('strPositionId', '=', $position)->select('intPosVoteLimit', 'strPositionId', 'strPosName')->get();
            
                
            if ($request->has('party')  && $party != 1) $countPos = DB::table('tblcandidate')
                                                        ->where('strCandPosId', '=', $position)
                                                        ->where('intCandParId', "=", $party )
                                                        ->where('blCandDelete', "=", 0)
                                                        ->select('strCandPosId')
                                                        ->count();
            
            if($request->has('party') && $party != 1){
            if($limit[0]->intPosVoteLimit == $countPos && $party != 1){
                $errMess = "Candidate limit of " . $limit[0]->strPosName . " in Party " . $partyName[0]->strPartyName . " has EXCEEDED";    
                return Redirect::back()->withErrors($errMess);
            }
                
           $already = DB::table('tblcandidate')->where('strCandMemId', '=', $request->input('member'))->where('blCandDelete', '=', '0')->get();
                
                if($already){
                    $PRTY = DB::table('tblparty')->where('intPartyId', '=', $already[0]->intCandParId)->get();
                    $errMess = "Candidate is already a member of the " . $PRTY[0]->strPartyName . " party";    
                    return Redirect::back()->withErrors($errMess);
                }
            }
                $already = DB::table('tblcandidate')->where('strCandMemId', '=', $request->input('member'))->where('blCandDelete', '=', '0')->get();
                
                if($already){
                    
                    $errMess = "Member is already a Candidate";    
                    return Redirect::back()->withErrors($errMess);
                }
            $destinationPath =  'assets/images/'; // upload path
            $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
            $date = date("Ymdhis");
            $filename = $date.'-'.rand(111111,999999).'.'.$extension;
            
            $ids = DB::table('tblcandidate')->select('strCandId')->get();
            $latest = 'CAND000';
            foreach($ids as $id){
                $latest = $id->strCandId;
            }
            $counter = new SmartCounter();
            $Candidate = new Candidate();
            $Candidate->strCandId = $counter->smartcounter($latest);
            $Candidate->strCandMemId = $request->input('member');
            $Candidate->strCandPosId = $request->input('position');
            $Candidate->strCandEducBack = $request->input('txtEducback');
            $Candidate->strCandInfo = $request->input('txtinfo');
            if ($request->has('party'))$Candidate->intCandParId = $request->input('party');
            else $Candidate->intCandParId = 1;
            if ($request->file('image')->isValid()) {
                $request->file('image')->move($destinationPath, $filename);
                $Candidate->txtCandPic = $filename;
            }  
            $Candidate->save();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        
        $request->session()->flash('message', 'Successfully added.');    
        return Redirect::back();
    }
    
    public function delete(Request $request){
        $id = $request->input("id");
        $voted = DB::table('tblvotedetail')->where('strVDCandId', $id)->get();
        if($voted){
             return Redirect::back()->withErrors("Cannot delete this record, because it is used by another record.");
        }
        else{
            $Candidate = Candidate::find($id);
            $Candidate->blCandDelete = 1;
            $Candidate->save();
        }
        //redirect
        $request->session()->flash('message', 'Successfully deleted.');  
        return Redirect::back();
        
    }
    
    public function editpage(Request $request){
        $id = $request->input('id');
        $PartyStatus = DB::table('tblSetting')->where('blSetParty', '=', 1)->get();
        $Candidate = Candidate::find($id);
        
        if($PartyStatus){
            $Members = DB::table('tblmember')->select('strMemberId', 'strMemFname', 'strMemLname', 'strMemMname')->get();
            $Positions = DB::table('tblposition')->select('strPositionId', 'strPosName')->get();
            $Parties = DB::table('tblparty')->select('intPartyId', 'strPartyName')->get();
            return view('Candidate.edit', ['Members' => $Members, 'Positions' => $Positions, 'Parties'=> $Parties, 'Candidate'=>$Candidate]);
        }
        else{
            $Members = DB::table('tblmember')->select('strMemberId', 'strMemFname', 'strMemLname', 'strMemMname')->get();
            $Positions = DB::table('tblposition')->select('strPositionId', 'strPosName')->get();
            $Parties = DB::table('tblparty')->select('intPartyId', 'strPartyName')->get();
            return view('Candidate.editlessparty', ['Members' => $Members, 'Positions' => $Positions, 'Candidate'=>$Candidate]);
        }
        
       
    }
    
    public function update(Request $request){
        $rules = array(
			'member' => 'required',
			'position' => 'required',
            'image' => 'mimes:jpeg,jpg,png,bmp|max:50000',
		);
		$messages = [
		    'required' => 'The :attribute field is required.',
		];
		$niceNames = array(
		    'member' => 'Candidate Name',
		    'position' => 'Position',
		    'party' => 'Party Affiliation',
		);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::route('candidate.index')->withErrors($validator);
        }
        
        
        try{
            
            $limit = 0;
            $countPos = 0;
            $position = $request->input('position');
            if ($request->has('party')) 
                $party = $request->input('party');
            if ($request->has('party')) 
                $partyName = DB::table('tblparty')
                    ->where('intPartyId', "=", $party)
                    ->select('strPartyName')
                    ->get();
            if ($request->has('party') && $party != 1) $limit = DB::table('tblposition')->where('strPositionId', '=', $position)->select('intPosVoteLimit', 'strPositionId', 'strPosName')->get();
            
                
            if ($request->has('party')  && $party != 1) $countPos = DB::table('tblcandidate')
                                                        ->where('strCandPosId', '=', $position)
                                                        ->where('intCandParId', "=", $party )
                                                        ->where('blCandDelete', "=", 0)
                                                        ->select('strCandPosId')
                                                        ->count();
            
            /*if($request->has('party') && $party != 1){
            if($limit[0]->intPosVoteLimit == $countPos && $party != 1){
                
                
                $errMess = "Candidate limit of " . $limit[0]->strPosName . " in Party " . $partyName[0]->strPartyName . " has EXCEEDED";    
                return Redirect::route('candidate.index')->withErrors($errMess);
            }
                
            
            if($request->has('party') && $party != 1){
                if($limit[0]->intPosVoteLimit == $countPos && $party != 1){
                    $errMess = "Candidate limit of " . $limit[0]->strPosName . " in Party " . $partyName[0]->strPartyName . " has EXCEEDED";    
                    return Redirect::back()->withErrors($errMess);
                }
            }*/
            
        
            
            $id = $request->input('txtCandId');
            $Candidate = Candidate::find($id);
            $Candidate->strCandMemId = $request->input('member');
            $Candidate->strCandPosId = $request->input('position');
            $Candidate->strCandEducBack = $request->input('txtEducback');
            $Candidate->strCandInfo = $request->input('txtinfo');
            if ($request->has('party'))$Candidate->intCandParId = $request->input('party');
            
            if ($request->hasFile('image')){

                $destinationPath =  'assets/images/'; // upload path
                $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
                $date = date("Ymdhis");
                $filename = $date.'-'.rand(111111,999999).'.'.$extension;

                
                 
                if ($request->file('image')->isValid()) {
                    $request->file('image')->move($destinationPath, $filename);
                    $Candidate->txtCandPic = $filename;
                }
                
            }
           
            $Candidate->save();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::route('candidate.index')->withErrors($errMess);
        }
        //redirect
        $request->session()->flash('message', 'Successfully Updates.');    
        return Redirect::route('candidate.index');
    }
    
    public function page(){
        $party = DB::table('tblSetting')->where('blSetParty', '=', 1)->get();
        
        if($party){
            
            $partylist = DB::table('tblcandidate')
                            ->distinct()
                            ->join('tblparty', 'tblcandidate.intCandParId', '=', 'tblparty.intPartyId')
                            ->where('blCandDelete', '=', 0)
                            ->select('tblcandidate.intCandParId','tblparty.strPartyName', 'tblparty.strPartyColor')
                            ->get();
            $positions = DB::select('SELECT distinct tblposition.* FROM tblposition
                                    left join tblcandidate on strPositionId = strCandPosId
                                    WHERE strCandId IS NOT NULL and blPosDelete = 0 and blCandDelete = 0');
            $candidates = DB::table('tblcandidate')
                            ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                            ->where('blCandDelete', '=', 0)
                            ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname')
                            ->get();
            $election = DB::table('tblsetting')->get();
            return view('Candidate.page', ['partylist'=>$partylist, 'positions'=>$positions, 'candidates'=>$candidates, 'election' => $election]);
            
            
        }
        
        else {
            $positions = DB::select('SELECT distinct tblposition.* FROM tblposition
                                    left join tblcandidate on strPositionId = strCandPosId
                                    WHERE strCandId IS NOT NULL and blPosDelete = 0 and blCandDelete = 0');
            $candidates = DB::table('tblcandidate')
                            ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                            ->where('blCandDelete', '=', 0)
                            ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname')
                            ->get();
            $election = DB::table('tblsetting')->get();
            return view('Candidate.pagelessparty', [ 'positions'=>$positions, 'candidates'=>$candidates, 'election' => $election]);
        }
        
    }
    public function filterposition(){
        $id = $_POST['id'];
        $positions = DB::table('tblposition')->select('strPositionId', 'strPosName')->get();
        $memdetail = DB::table('tblmemberdetail')
                            ->select('strMemDeFieldName', 'strMemDeFieldData')
                            ->where('strMemDeMemId', '=', $id)
                            ->get();
        $arrPosAvail = "";
        $arrPosAvailId = "";
        $index = 0;               
        foreach($positions as $pos){
            $posdetail = DB::table('tblpositiondetail')
                            ->select('strPosDeFieldName','strPosDeFieldData')
                            ->where('strPosDePosId', '=', $pos->strPositionId)
                            ->get();
            $numdet = DB::table('tblpositiondetail')
                            ->select('strPosDeFieldName')
                            ->where('strPosDePosId', '=', $pos->strPositionId)
                            ->distinct()
                            ->count();
            if($posdetail){
                $count = 0;
                foreach($posdetail as $posdet){
                    $counter = 0;
                    foreach($memdetail as $memdet){
                        if($posdet->strPosDeFieldName == $memdet->strMemDeFieldName){
                            if($posdet->strPosDeFieldData == $memdet->strMemDeFieldData){
                                $counter++;
                            }
                        }
                    }
                    if($counter > 0) $count++;
                }
                if($count == $numdet){
                    $arrPosAvailId[$index] = $pos->strPositionId;
                    $arrPosAvail[$index] = $pos->strPosName;
                    $index++;
                }
            }
            else{
                // global position to..
                $arrPosAvailId[$index] = $pos->strPositionId;
                $arrPosAvail[$index] = $pos->strPosName;
                $index++;
            }
        }
        return view('Candidate.positionFilter', [ 'arrPosAvail'=>$arrPosAvail, 'arrPosAvailId'=>$arrPosAvailId]);
    }    
}
