<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;

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
            $positions = DB::table('tblposition')->get();
            $candidates = DB::table('tblcandidate')
                            ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                            ->join('tblparty', 'tblcandidate.intCandParId', '=', 'tblparty.intPartyId')
                            ->where('blCandDelete', '=', 0)
                            ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname', 'tblparty.strPartyName', 'tblparty.strPartyColor')
                            ->get();
            $election = DB::table('tblsetting')->get();
            return view('Voting.page', ['partylist'=>$partylist, 'positions'=>$positions, 'candidates'=>$candidates, 'election' => $election]);
            
            
        }
        
        else {
            $positions = DB::table('tblposition')->get();
            $candidates = DB::table('tblcandidate')
                            ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                            ->where('blCandDelete', '=', 0)
                            ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname')
                            ->get();
            $election = DB::table('tblsetting')->get();
            return view('Voting.pagelessparty', [ 'positions'=>$positions, 'candidates'=>$candidates, 'election' => $election]);
        }
        
    }
    
    public function cast()
    {
       return Redirect::route('survey.view');
    }

}
