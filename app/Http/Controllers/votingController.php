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
use BrowserDetect;
use Session;
use App\Dummy AS Dummy;
use App\SurveyHeader AS SurveyHeader;
use Illuminate\Support\Facades\App;

class votingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page(){

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
            $positions = DB::select('SELECT distinct tblposition.* FROM tblposition
                                    left join tblcandidate on strPositionId = strCandPosId
                                    WHERE strCandId IS NOT NULL and blPosDelete = 0 and blCandDelete = 0');
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
                                if($posdet->strPosDeFieldData == $memdet->strMemDeFieldData) $counter++;
                            }
                        }
                        if($counter != 0) $count++;
                    }
                    
                    if($count == $numdet){
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
            
            $num=0;
            foreach($only as $on){
                $limit = DB::table('tblposition')
                            ->select('intPosVoteLimit')
                            ->where('strPositionId', '=', $on->strPositionId)
                            ->get();
                $num=$num+$limit[0]->intPosVoteLimit;
            }
            return view('Voting.page', ['partylist'=>$partylist, 'positions'=>$only, 'candidates'=>$candidates, 'election' => $election, 'countCand'=>$num]);
        } else {
            
            $candidates = DB::table('tblcandidate')
                            ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                            ->where('blCandDelete', '=', 0)
                            ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname')
                            ->get();
            $memdetail = DB::table('tblmemberdetail')
                            ->select('strMemDeFieldName', 'strMemDeFieldData')
                            ->where('strMemDeMemId', '=', session('memid'))
                            ->get();
            // $only = "";
            // $only = new Dummy();
            $index = 0;
            $positions = DB::select('SELECT distinct tblposition.* FROM tblposition
                                    left join tblcandidate on strPositionId = strCandPosId
                                    WHERE strCandId IS NOT NULL and blPosDelete = 0 and blCandDelete = 0'); 
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
                                if($posdet->strPosDeFieldData == $memdet->strMemDeFieldData) $counter++;
                            }
                        }
                        if($counter != 0) $count++;
                    }
                    if($count == $numdet){
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
            $countCand = sizeof($candidates);
            return view('Voting.pagelessparty', [ 'positions'=>$only, 'candidates'=>$candidates, 'election' => $election, 'countCand'=>$countCand]);
        }
        
    }
    public function summary(Request $request){
        $request->flash();
        $voted = "";
        if(isset($_POST['vote'])){
            $count = 0;
            foreach ($_POST['vote'] as $candID) {
                $candidates = DB::table('tblcandidate')
                            ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                            ->join('tblposition', 'tblcandidate.strCandPosId', '=', 'tblposition.strPositionId')
                            ->where('blCandDelete', '=', 0)
                            ->where('strCandId', '=', $candID)
                            ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname', 'tblposition.strPosName', 'tblposition.strPosColor')
                            ->get();    
                $voted[$count] = $candidates[0];
                $count++;
            }
            
        }
        if(isset($_POST['par'])) $par = $_POST['par'];
        else $par = NULL;
        $election = DB::table('tblsetting')->get();
        return view('Voting.summary', ['candidates'=>$voted, 'election' => $election, 'par'=>$par, 'countCand'=>$_POST['countCand']]);
            
    }
    public function cast(Request $request)
    {
        // Detect User's Device // 
        $device = '';
        $browser = '';
        $opSys = '';
        $model = '';
        if (BrowserDetect::isDesktop())
            $device = 1;
        else if(BrowserDetect::isTablet())
            $device = 2;
        else if(BrowserDetect::isMobile())
            $device = 3;
        $browser = BrowserDetect::browserName();
        $opSys = BrowserDetect::osFamily();
        $model = BrowserDetect::deviceModel();
        // Detect User's Device // 

        if($_POST['redirect'] == 1)
            return Redirect::route('voting.page')->withInput();
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
            $VoteHeader->intDevice = $device;
            $VoteHeader->strBrowser = $browser;
            $VoteHeader->strOpSys = $opSys;
            $VoteHeader->strDevModel = $model;
            if($_POST['par'] != NULL){
                $VoteHeader->blvotestraight = 1;
                $par = DB::table('tblparty')->where('intPartyId', '=', $_POST['par'])->get();
                $VoteHeader->strVHParty = $par[0]->strPartyName;
              
            } 
            if(isset($_POST['vote'])){
                if($_POST['countCand'] > sizeof($_POST['vote']))$VoteHeader->blundervote = 1;
            }
            else $VoteHeader->blundervote = 1;   
            $candid = DB::table('tblcandidate')->where('strCandMemId', '=', session('memid'))
                            ->where('blCandDelete', '=', 0)->get();
            if($candid) $VoteHeader->blcandidate = 1;
            $id = $VoteHeader->strVHCode;
            $VoteHeader->save();
            
            $VHID = VoteHeader::find($id);
            $VDID = $VHID->strVHCode;
            
            if(isset($_POST['vote'])){
                foreach ($_POST['vote'] as $candID) {
                    $VoteDetail = new VoteDetail();
                    $VoteDetail->strVDVHCode = $VDID;
                    $VoteDetail->strVDCandId = $candID;
                    $VoteDetail->save();
                    
                }
            }
            DB::commit();
            
            if(Session::has('memid')) $memid = session('memid');
            if(Session::has('memid')) Session::forget('memid');
            
            Session::put('memid', $memid);
            Session::put('votereference', $VDID);

            // Pusher: Sending an Channel and Event // 
            $pusher = App::make('pusher');
            $pusher->trigger('notifications',
                             'new-notification',
                             array('text' => 'Vote Entered')
                             );
            // Pusher: Sending an Channel and Event // 

            $SurveyStatus = DB::table('tblSetting')->where('blSetSurvey', '=', 1)->get();
            if($SurveyStatus){
                // redirect to thanks then survey
                return Redirect::route('thanks');
            } else{
                if(Session::has('memid')) Session::forget('memid');
                if(Session::has('votereference')) Session::forget('memid');
                
                //redirect to realtime voting result
                return Redirect::route('LogInUser');
            }
        }catch (\Illuminate\Database\QueryException $e){
            DB::rollBack();
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
    }
}

