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
        $tally = DB::select('SELECT strCandID, strMemLName, strMemFName, strCandPosId,
                            txtCandPic, count(strVDCandId) as `votes` FROM tblcandidate 
                            join tblmember on strMemberId = strCandMemId
                            left join tblvotedetail on strCandId = strVDCandId
                            where blCandDelete = 0
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
        $posdetail = DB::table('tbldynamicfield')->select('strDynFieldName')->where('blDynStatus', '=', 1)->get();
        
        return view('Report.voteDistro', ['posdetail'=>$posdetail]);
    }
    
    public function voteDistro(Request $page){
        $candidate = DB::table('tblcandidate')
                        ->join('tblmember', 'tblmember.strMemberId', '=', 'tblcandidate.strCandMemId')
                        ->get();
        $posdetail = DB::table('tbldynamicfield')->select('strDynFieldName')->where('blDynStatus', '=', 1)->get();
        $votedistro = DB::select('SELECT c.strCandId, CONCAT(m.strMemFname, " ", m.strMemLName) as "fullname" ,p.strPosName, md.strMemDeFieldData, count(vh.strVHCode) AS "count"
            FROM tblcandidate AS c  
            join tblmember as m on c.strCandMemId = m.strMemberID
            join tblposition as p on c.strCandPosId = p.strPositionID
            join tblvotedetail AS vd on c.strCandID = vd.strVDCandID
            join tblvoteheader AS vh on vd.strVDVHCode = vh.strVHCode
            left join tblmemberdetail AS md on vh.strVHMemID = md.strMemDeMemId
            where md.strMemDeFieldName = ? OR md.strMemDeFieldName IS NULL
            group by c.strCandId, fullname, p.strPosName,  md.strMemDeFieldData;',[$page->input('distro')]);
        
        return view('Report.distroview', ["candidate"=>$candidate, "votedistro" =>$votedistro, 'posdetail'=>$posdetail]);
        
    }
}
