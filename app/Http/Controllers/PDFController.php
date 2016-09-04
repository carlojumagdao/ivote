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
        if($setting->blSetPublish == 1){
            if($query == 1){
                
                $list = DB::table('tblmember')
                            ->join('tblsurveyheader', 'strMemberId', '=', 'strSHMemCode' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->get();
                $count = DB::table('tblmember')
                            ->join('tblsurveyheader', 'strMemberId', '=', 'strSHMemCode' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
            
                $title = "Total Members Who Took Survey";
            
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
                            ->where('blMemCodeSendStat', '=', 1)
                            ->whereNull('tblsurveyheader.strSHMemCode')
                            ->get();
                $count = DB::table('tblmember')
                            ->leftJoin('tblsurveyheader', 'strMemberId', '=', 'strSHMemCode' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->whereNull('tblsurveyheader.strSHMemCode')
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Did Not Take Survey";
                
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
            else if($query == 3){
                $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=',   1)
                            ->where('blMemDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Voted";
                
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
            else if($query == 4){
            
                $list = DB::table('tblmember')
                            ->leftJoin('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->whereNULL('tblvoteheader.strVHMemId')
                            ->get();
                $count = DB::table('tblmember')
                            ->leftJoin('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->whereNULL('tblvoteheader.strVHMemId')
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Did Not Vote";
                
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
            else if($query == 5){
                $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->where('blcandidate', '=', 1)
                            ->get();
                $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->where('blcandidate', '=', 1)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Candidate Who Voted";
            
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
            else if($query == 6){
                $list = DB::table('tblmember')
                            ->leftJoin('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->whereNULL('tblvoteheader.strVHMemId')
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->where('blCandDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember')
                            ->leftJoin('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->whereNULL('tblvoteheader.strVHMemId')
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->where('blCandDelete', '=', 0)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Candidate Who Did Not Vote";
            
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
        
            else if($query == 7){
                $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blundervote', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember') 
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->where('blundervote', '=', 1)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Undervoted";
            
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
            else if($query == 8){
                $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blundervote', '=', 0)
                            ->where('blMemDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blundervote', '=', 0)
                            ->where('blMemDelete', '=', 0)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Did Not Undervote";
            
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
        
            else if($query == 9){
                $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blvotestraight', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->where('blvotestraight', '=', 1)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Votestraight";
            
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
            else if($query == 10){
                $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blvotestraight', '=', 0)
                            ->where('blMemDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blvotestraight', '=', 0)
                            ->where('blMemDelete', '=', 0)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members who Did Not Vote Straight";
            
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
        }
        else{
            if($query == 1){
                
                $list = DB::table('tblmember')
                            ->join('tblsurveyheader', 'strMemberId', '=', 'strSHMemCode' )
                            ->where('blMemDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember')
                            ->join('tblsurveyheader', 'strMemberId', '=', 'strSHMemCode' )
                            ->where('blMemDelete', '=', 0)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
            
                $title = "Total Members Who Took Survey";
            
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
                            ->whereNull('tblsurveyheader.strSHMemCode')
                            ->get();
                $count = DB::table('tblmember')
                            ->leftJoin('tblsurveyheader', 'strMemberId', '=', 'strSHMemCode' )
                            ->where('blMemDelete', '=', 0)
                            ->whereNull('tblsurveyheader.strSHMemCode')
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Did Not Take Survey";
                
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
            else if($query == 3){
                $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemDelete', '=', 0)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Voted";
                
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
            else if($query == 4){
            
                $list = DB::table('tblmember')
                            ->leftJoin('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemDelete', '=', 0)
                            ->whereNULL('tblvoteheader.strVHMemId')
                            ->get();
                $count = DB::table('tblmember')
                            ->leftJoin('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemDelete', '=', 0)
                            ->whereNULL('tblvoteheader.strVHMemId')
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Did Not Vote";
                
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
            else if($query == 5){
                $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blcandidate', '=', 1)
                            ->get();
                $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blcandidate', '=', 1)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Candidate Who Voted";
            
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
            else if($query == 6){
                $list = DB::table('tblmember')
                            ->leftJoin('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->whereNULL('tblvoteheader.strVHMemId')
                            ->where('blMemDelete', '=', 0)
                            ->where('blCandDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember')
                            ->leftJoin('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->whereNULL('tblvoteheader.strVHMemId')
                            ->where('blMemDelete', '=', 0)
                            ->where('blCandDelete', '=', 0)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Candidate Who Did Not Vote";
            
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
        
            else if($query == 7){
                $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blundervote', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember') 
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blundervote', '=', 1)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Undervoted";
            
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
            else if($query == 8){
                $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blundervote', '=', 0)
                            ->where('blMemDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blundervote', '=', 0)
                            ->where('blMemDelete', '=', 0)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Did Not Undervote";
            
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
        
            else if($query == 9){
                $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blvotestraight', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemDelete', '=', 0)
                            ->where('blvotestraight', '=', 1)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Votestraight";
            
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
            else if($query == 10){
                $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blvotestraight', '=', 0)
                            ->where('blMemDelete', '=', 0)
                            ->get();
                $count = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blvotestraight', '=', 0)
                            ->where('blMemDelete', '=', 0)
                            ->count();
                $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->count();
                if($members != 0)
                    $percent = ($count/$members) * 100;
                else  $percent = 0;
                $title = "Total Number of Members Who Did Not Vote Straight";
            
                $pdf=PDF::loadview('PDFfile.query',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'list'=> $list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, "title" => $title, 'publish'=>$setting->blSetPublish, 'query'=>$query));
                return $pdf->stream('pdfile.pdf');
            }
        }
    }
    
    public function surveyPDF(){
    	$SurveyQuestions = DB::select('SELECT intSQId,strSQQuestion, strSQQuesType FROM 
    							tblsurveyquestion WHERE blSQStatus = 1;');
    	$SurveyTally = DB::select('SELECT sd.strSDAnswer, count(sd.strSDAnswer) AS Tally,
    								sq.intSQId, sd.intSDId
									FROM tblsurveyquestion AS sq
									LEFT JOIN tblsurveydetail AS sd
										ON sq.intSQId = sd.intSDSQId
									WHERE sq.blSQStatus = 1
								    GROUP BY 1
								    ORDER BY sq.strSQQuestion;');
    	$pdf=PDF::loadview("PDFFile.survey", ['SurveyTally'=>$SurveyTally, 'SurveyQuestions'=>$SurveyQuestions]);
        return $pdf->stream('pdfile.pdf');
    }
}
