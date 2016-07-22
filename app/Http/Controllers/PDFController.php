<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PDF;
use DB;
use App\GenSet;

class PDFController extends Controller
{
    public function getPDF(){
    	$queryResult = GenSet::all();
    	foreach($queryResult as $result) {
            $Head = $result->strHeader;
            $Picture = $result->txtSetLogo;
            $Address = $result->strSetAddress;
        }
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
    	$pdf=PDF::loadview('PDFfile.pdfile',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'tally'=> $tally, 'count'=>$voted, 'positions'=>$positions));
    	return $pdf->stream('pdfile.pdf');
    	
    }
    
    public function getWinner(){
    	$queryResult = GenSet::all();
    	foreach($queryResult as $result) {
            $Head = $result->strHeader;
            $Picture = $result->txtSetLogo;
            $Address = $result->strSetAddress;
        }
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
    	$pdf=PDF::loadview('PDFfile.winner',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'tally'=> $tally, 'count'=>$voted, 'positions'=>$positions));
    	return $pdf->stream('pdfile.pdf');
    	
    }
}
