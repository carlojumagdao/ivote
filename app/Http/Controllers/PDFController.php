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
                            ->where('blCandDelete', '=', '0')
                            ->distinct()
                            ->get();
        $tally = DB::select('SELECT strCandID, strMemLName, strMemFName, strCandPosId, txtCandPic, count(strVDCandId) as `votes` FROM tblcandidate 
join tblmember on strMemberId = strCandMemId
left join tblvotedetail on strCandId = strVDCandId
where blCandDelete = 0
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
                            ->where('blCandDelete', '=', '0')
                            ->distinct()
                            ->get();
        $tally = DB::select('SELECT strCandID, strMemLName, strMemFName, strCandPosId, txtCandPic, count(strVDCandId) as                        `votes` FROM tblcandidate 
                                join tblmember on strMemberId = strCandMemId
                                left join tblvotedetail on strCandId = strVDCandId
                                where blCandDelete = 0
                                group by strVDCandID, strMemLName, txtCandPic
                                order by 6 desc;');
        
        $voted = DB::table('tblvoteheader')->count();
    	$pdf=PDF::loadview('PDFfile.winner',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'tally'=> $tally, 'count'=>$voted, 'positions'=>$positions));
    	return $pdf->stream('pdfile.pdf');
    	
    }
    
    public function tookSurvey(){
        $queryResult = GenSet::all();
        $setting = GenSet::find(1);
    	foreach($queryResult as $result) {
            $Head = $result->strHeader;
            $Picture = $result->txtSetLogo;
            $Address = $result->strSetAddress;
        }
        $send = 0;
        if($setting->blSetPublish == 1) $send = 1;
            $list = DB::table('tblmember')
                            ->join('tblsurveyheader', 'strMemberId', '=', 'strSHMemCode' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblsurveyheader', 'strMemberId', '=', 'strSHMemCode' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
           if($members != 0)
            $percent = ($count/$members) * 100;
            else  $percent = 0;
        
        $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'query'=>$query));
    	return $pdf->stream('pdfile.pdf');
    }
    
    public function query($query){
        $queryResult = GenSet::all();
        $setting = GenSet::find(1);
    	foreach($queryResult as $result) {
            $Head = $result->strHeader;
            $Picture = $result->txtSetLogo;
            $Address = $result->strSetAddress;
        }
        $send = 0;
        if($setting->blSetPublish == 1) $send = 1;
        
        if($query == 1){
            $list = DB::table('tblmember')
                            ->join('tblsurveyheader', 'strMemberId', '=', 'strSHMemCode' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblsurveyheader', 'strMemberId', '=', 'strSHMemCode' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
           if($members != 0)
            $percent = ($count/$members) * 100;
            else  $percent = 0;
            
            $title = "Who Took Survey";
            
            $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
            return $pdf->stream('pdfile.pdf');
        }
        
        else if($query == 2){
            $arr = DB::select('SELECT strSHMemCode from tblsurveyheader');
            $ind = 0;
            $surveyed = '';
            foreach($arr as $el){
                $surveyed[$ind] = $el->strSHMemCode;
            }
            $list = DB::table('tblmember')
                            ->leftJoin('tblsurveyheader', 'strMemberId', '=', 'strSHMemCode' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->whereNull('tblsurveyheader.strSHMemCode')
                            ->get();
            $count = DB::table('tblmember')
                            ->leftJoin('tblsurveyheader', 'strMemberId', '=', 'strSHMemCode' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->whereNull('tblsurveyheader.strSHMemCode')
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
            if($members != 0)
            $percent = ($count/$members) * 100;
            else  $percent = 0;
            $title = "Who did not take Survey";
            
            $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
            return $pdf->stream('pdfile.pdf');
        }
        else if($query == 3){
            $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blMemDelete', '=', 0)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blMemDelete', '=', 0)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
           if($members != 0)
            $percent = ($count/$members) * 100;
            else  $percent = 0;
            $title = "Who Voted";
            
            $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
            return $pdf->stream('pdfile.pdf');
        }
        else if($query == 4){
            $arr = DB::select('SELECT strVHMemId from tblvoteheader');
            $ind = 0;
            $voted = '';
            foreach($arr as $el){
                $voted[$ind] = $el->strVHMemId;
            }
            $list = DB::table('tblmember')
                            ->whereNotIn('strMemberId', $voted)
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->get();
            $count = DB::table('tblmember')
                            ->whereNotIn('strMemberId', $voted)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blMemDelete', '=', 0)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
            if($members != 0)
            $percent = ($count/$members) * 100;
            else  $percent = 0;
            $title = "Who did not vote";
            
            $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
            return $pdf->stream('pdfile.pdf');
        }
        else if($query == 5){
            $list = DB::table('tblmember')
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blMemDelete', '=', 0)
                            ->where('blCandDelete', '=', 0)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blMemDelete', '=', 0)
                            ->where('blCandDelete', '=', 0)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
            if($members != 0)
            $percent = ($count/$members) * 100;
            else  $percent = 0;
            $title = "Candidates Who Voted";
            
            $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
            return $pdf->stream('pdfile.pdf');
        }
        else if($query == 6){
            $arr = DB::select('SELECT strVHMemId from tblvoteheader');
            $ind = 0;
            $voted = '';
            foreach($arr as $el){
                $voted[$ind] = $el->strVHMemId;
            }
            $list = DB::table('tblmember')
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->whereNotIn('strMemberId', $voted)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blMemDelete', '=', 0)
                            ->where('blCandDelete', '=', 0)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->whereNotIn('strMemberId', $voted)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blMemDelete', '=', 0)
                            ->where('blCandDelete', '=', 0)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
            if($members != 0)
            $percent = ($count/$members) * 100;
            else  $percent = 0;
            $title = "Candidates Who did not vote";
            
            $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
            return $pdf->stream('pdfile.pdf');
        }
        
        else if($query == 7){
            $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blundervote', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blMemDelete', '=', 0)
                            ->where('blundervote', '=', 1)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
            if($members != 0)
            $percent = ($count/$members) * 100;
            else  $percent = 0;
            $title = "Members Who Undervoted";
            
            $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
            return $pdf->stream('pdfile.pdf');
        }
        else if($query == 8){
            $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blundervote', '=', 0)
                            ->where('blMemDelete', '=', 0)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blundervote', '=', 0)
                            ->where('blMemDelete', '=', 0)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
            if($members != 0)
                $percent = ($count/$members) * 100;
            else  $percent = 0;
            $title = "Members Who did not undervote";
            
            $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
            return $pdf->stream('pdfile.pdf');
        }
        
        else if($query == 9){
            $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blvotestraight', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blMemDelete', '=', 0)
                            ->where('blvotestraight', '=', 1)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
            if($members != 0)
                $percent = ($count/$members) * 100;
            else  $percent = 0;
            $title = "Members Who VoteStraight";
            
            $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
            return $pdf->stream('pdfile.pdf');
        }
        else if($query == 10){
            $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blvotestraight', '=', 0)
                            ->where('blMemDelete', '=', 0)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', $send)
                            ->where('blvotestraight', '=', 0)
                            ->where('blMemDelete', '=', 0)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', $send)
                            ->count();
            if($members != 0)
            $percent = ($count/$members) * 100;
            else  $percent = 0;
            $title = "Members Who did not votestraight";
            
            $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
            return $pdf->stream('pdfile.pdf');
        }
        
    }
}
