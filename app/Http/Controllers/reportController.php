<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\GenSet As GenSet;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class reportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tallyvotes()
    {
        $positions = DB::table('tblcandidate')
                            ->join('tblposition', 'strPositionId', '=', 'strCandPosId')
                            ->select('strCandPosId', 'strPosName')
                            ->where('blPosDelete', '=', '0')
                            ->distinct()
                            ->get();
        $tally = DB::select('SELECT strCandID, strMemLName, strMemFName, strCandPosId, txtCandPic, count(strVDCandId) as `votes` FROM tblcandidate 
join tblmember on strMemberId = strCandMemId
left join tblvotedetail on strCandId = strVDCandId
group by strVDCandID, strMemLName, txtCandPic
order by 6 desc;');
        $voted = DB::table('tblvoteheader')->count();
        $GenSet = GenSet::find(1);
    	$start = date_create($GenSet->datSetStart);
        $end = date_create($GenSet->datSetEnd);
        $nowNoTime = date_create(date("Y-m-d"));
        $now = date_create(date("Y-m-d H:i:s"));
        
        if($now < $start) return view('Report.startpage');
        else if($now > $end) return view('Report.tallyvotes', ['tally'=>$tally, 'count'=>$voted, 'positions'=>$positions] );
    	else return view('Report.endpage');
    }
    
    public function determineWinners(){
        $positions = DB::table('tblcandidate')
                            ->join('tblposition', 'strPositionId', '=', 'strCandPosId')
                            ->select('strCandPosId', 'strPosName', 'intPosVoteLimit')
                            ->where('blPosDelete', '=', '0')
                            ->distinct()
                            ->get();
        $tally = DB::select('SELECT strCandID, strMemLName, strMemFName, strCandPosId, txtCandPic, count(strVDCandId) as `votes` FROM tblcandidate 
join tblmember on strMemberId = strCandMemId
left join tblvotedetail on strCandId = strVDCandId
group by strVDCandID, strMemLName, txtCandPic
order by 6 desc;');
        $voted = DB::table('tblvoteheader')->count();
        $GenSet = GenSet::find(1);
    	$start = date_create($GenSet->datSetStart);
        $end = date_create($GenSet->datSetEnd);
        $nowNoTime = date_create(date("Y-m-d"));
        $now = date_create(date("Y-m-d H:i:s"));
        
        if($now < $start) return view('Report.startpage');
        else if($now > $end) return view('Report.winnerPage', ['tally'=>$tally, 'count'=>$voted, 'positions'=>$positions] );
    	else return view('Report.endpage');
        
    }
    
    public function distroIndex(){
        $posdetail = DB::table('tblpositiondetail')->select('strPosDeFieldName')->get();
        
        return view('Report.voteDistro', ['posdetail'=>$posdetail]);
    }
    
    public function voteDistro(Request $page){
        
    }
}
