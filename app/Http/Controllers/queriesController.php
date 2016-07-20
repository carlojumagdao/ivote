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
            $percent = ($count/$members) * 100;
            
            $title = "Who Took Survey";
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty]);
        }
        
        else if($query == 2){
            $arr = DB::select('SELECT strSHMemCode from tblsurveyheader');
            $ind = 0;
            $surveyed = '';
            foreach($arr as $el){
                $surveyed[$ind] = $el->strSHMemCode;
            }
            $list = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->whereNotIn('strMemberId', $surveyed)
                            ->get();
            $count = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->whereNotIn('strMemberId', $surveyed)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
            $percent = ($count/$members) * 100;
            $title = "Who did not take Survey";
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty]);
        }
        else if($query == 3){
            $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
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
            $percent = ($count/$members) * 100;
            $title = "Who Voted";
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty]);
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
                            ->where('blMemCodeSendStat', '=', 1)
                            ->get();
            $count = DB::table('tblmember')
                            ->whereNotIn('strMemberId', $voted)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
            $percent = ($count/$members) * 100;
            $title = "Who did not vote";
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty]);
        }
        else if($query == 5){
            $list = DB::table('tblmember')
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->where('blCandDelete', '=', 0)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->where('blCandDelete', '=', 0)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
            $percent = ($count/$members) * 100;
            $title = "Candidates Who Voted";
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty]);
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
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->where('blCandDelete', '=', 0)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->whereNotIn('strMemberId', $voted)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->where('blCandDelete', '=', 0)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
            $percent = ($count/$members) * 100;
            $title = "Candidates Who did not vote";
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty]);
        }
        
        else if($query == 7){
            $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blundervote', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->where('blundervote', '=', 1)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
            $percent = ($count/$members) * 100;
            $title = "Members Who Undervoted";
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty]);
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
            $percent = ($count/$members) * 100;
            $title = "Members Who did not undervote";
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty]);
        }
        
        else if($query == 9){
            $list = DB::table('tblmember')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blvotestraight', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->get();
            $count = DB::table('tblmember')
                            ->join('tblcandidate', 'strCandMemId', '=', 'strMemberId')
                            ->join('tblvoteheader', 'strMemberId', '=', 'strVHMemId' )
                            ->where('blMemCodeSendStat', '=', 1)
                            ->where('blMemDelete', '=', 0)
                            ->where('blvotestraight', '=', 1)
                            ->count();
            $members = DB::table('tblmember')
                            ->where('blMemDelete', '=', 0)
                            ->where('blMemCodeSendStat', '=', 1)
                            ->count();
            $percent = ($count/$members) * 100;
            $title = "Members Who VoteStraight";
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty]);
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
            $percent = ($count/$members) * 100;
            $title = "Members Who did not votestraight";
            
            return view('Queries.index', ['title'=>$title, 'query'=>$query,'list'=>$list, 'count'=>$count, 'members'=>$members, 'percent'=>$percent, 'surveystat' => $setting->blSetSurvey, 'partystat'=>$setting->blSetParty]);
        }
        
    }
    

}
