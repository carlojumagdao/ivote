<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\GenSet AS GenSet;
use App\VoteHeader AS VoteHeader;
use App\VoteDetail AS VoteDetail;
use App\SmartCounter AS SmartCounter;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use Session;

class votingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page()
    {
        
        $party = DB::table('tblSetting')->where('blSetParty', '=', 1)->get();
        
        if($party){
            $partylist = DB::table('tblcandidate')
                            ->distinct()
                            ->join('tblparty', 'tblcandidate.intCandParId', '=', 'tblparty.intPartyId')
                            ->where('blCandDelete', '=', 0)
                            ->select('tblcandidate.intCandParId','tblparty.strPartyName', 'tblparty.strPartyColor')
                            ->get();
            $memdetail = DB::table('tblmemberdetail')
                            ->select('strMemDeFieldName', 'strMemDeFieldData')
                            ->where('strMemDeMemId', '=', session('memid'))
                            ->get();
            $only = "";
            $index = 0;
            $positions = DB::table('tblposition')->get();
            
            foreach($positions as $pos){
                $posdetail = DB::table('tblpositiondetail')
                                ->select('strPosDeFieldName','strPosDeFieldData')
                                ->where('strPosDePosId', '=', $pos->strPositionId)
                                ->get();
                if($posdetail){
                    $count = 0;
                    foreach($posdetail as $posdet){
                        foreach($memdetail as $memdet){
                            if($posdet->strPosDeFieldName == $memdet->strMemDeFieldName){
                                if($posdet->strPosDeFieldData == $memdet->strMemDeFieldData) $count++;
                            }
                        }
                    }
                    
                    if($count != 0){
                        $only[$index] = $pos;
                        $index++;
                    } 
                    
                }
                
                else{
                    $only[$index] = $pos;
                    $index++;
                }
                
            }
            $candidates = DB::table('tblcandidate')
                            ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                            ->join('tblparty', 'tblcandidate.intCandParId', '=', 'tblparty.intPartyId')
                            ->where('blCandDelete', '=', 0)
                            ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname', 'tblparty.strPartyName', 'tblparty.strPartyColor')
                            ->get();
            $election = DB::table('tblsetting')->get();
            return view('Voting.page', ['partylist'=>$partylist, 'positions'=>$only, 'candidates'=>$candidates, 'election' => $election]);
            
            
        }
        
        else {
            $positions = DB::table('tblposition')->get();
            $candidates = DB::table('tblcandidate')
                            ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                            ->where('blCandDelete', '=', 0)
                            ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname')
                            ->get();
            $memdetail = DB::table('tblmemberdetail')
                            ->select('strMemDeFieldName', 'strMemDeFieldData')
                            ->where('strMemDeMemId', '=', session('memid'))
                            ->get();
            $only = "";
            $index = 0;
            $positions = DB::table('tblposition')->get();
            
            foreach($positions as $pos){
                $posdetail = DB::table('tblpositiondetail')
                                ->select('strPosDeFieldName','strPosDeFieldData')
                                ->where('strPosDePosId', '=', $pos->strPositionId)
                                ->get();
                if($posdetail){
                    $count = 0;
                    foreach($posdetail as $posdet){
                        foreach($memdetail as $memdet){
                            if($posdet->strPosDeFieldName == $memdet->strMemDeFieldName){
                                if($posdet->strPosDeFieldData == $memdet->strMemDeFieldData) $count++;
                            }
                        }
                    }
                    
                    if($count != 0){
                        $only[$index] = $pos;
                        $index++;
                    } 
                    
                }
                
                else{
                    $only[$index] = $pos;
                    $index++;
                }
                
            }
            
            $election = DB::table('tblsetting')->get();
            return view('Voting.pagelessparty', [ 'positions'=>$only, 'candidates'=>$candidates, 'election' => $election]);
        }
        
    }
    
    public function cast()
    {
        try{
            DB::beginTransaction();  
            
            $VoteHeader = new VoteHeader();
            
            $ids = DB::table('tblvoteheader')->select('strVHCode')->get();
            $latest = 'VOTE-00000';
            foreach($ids as $id){
                $latest = $id->strVHCode;
            }
            
            $counter = new SmartCounter();
            $VoteHeader->strVHCode = $counter->smartcounter($latest);
            $VoteHeader->strVHMemId = session('memid');
            $id = $VoteHeader->strVHCode;
            $VoteHeader->save();
            
            $VHID = VoteHeader::find($id);
            $VDID = $VHID->strVHCode;
            
            
            foreach ($_POST['vote'] as $candID) {
                $VoteDetail = new VoteDetail();
                $VoteDetail->strVDVHCode = $VDID;
                $VoteDetail->strVDCandId = $candID;
                $VoteDetail->save();
                
            }
            DB::commit();
            
            if(Session::has('memid')) $memid = session('memid');
            if(Session::has('memid')) Session::forget('memid');
            
            Session::put('memid', $memid);
            Session::put('votereference', $VDID);
            
            return redirect()->route("survey.answerSurvey");
        }catch (\Illuminate\Database\QueryException $e){
            DB::rollBack();
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        
        
        

    }

}
