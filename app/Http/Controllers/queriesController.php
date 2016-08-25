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
use URL;
use Redirect;
use Session;

class queriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(){
        $setting = GenSet::find(1);
        return view('Queries.index', ['surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty]);
    }
    
    public function query(Request $request){
        $setting = GenSet::find(1);
        $query =  $request->input('query');
        $send = 0;
        $PDFlink = e(URL::to('/query/'. $query ));
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
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty, 'publish'=>$setting->blSetPublish, 'link'=>$PDFlink]);
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
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty, 'publish'=>$setting->blSetPublish, 'link'=>$PDFlink]);
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
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty, 'publish'=>$setting->blSetPublish, 'link'=>$PDFlink]);
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
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty, 'publish'=>$setting->blSetPublish, 'link'=>$PDFlink]);
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
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty, 'publish'=>$setting->blSetPublish, 'link'=>$PDFlink]);
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
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty, 'publish'=>$setting->blSetPublish, 'link'=>$PDFlink]);
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
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty, 'publish'=>$setting->blSetPublish, 'link'=>$PDFlink]);
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
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty, 'publish'=>$setting->blSetPublish, 'link'=>$PDFlink]);
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
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty, 'publish'=>$setting->blSetPublish, 'link'=>$PDFlink]);
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
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty, 'publish'=>$setting->blSetPublish, 'link'=>$PDFlink]);
        }
        
    }
    

}
