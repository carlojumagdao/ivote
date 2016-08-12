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

class auditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $audit = DB::select("SELECT user, strMemberId, tblaudit.Action, date(tblaudit.Date) as `date`, time(tblaudit.Date) as `time`, oldValue, newValue
from tblaudit order by date desc, time desc;");
        
        
        if($audit){
            $first =  $audit[0]->date;
            return view('audit', ['audit'=>$audit, 'first'=> $first]);
        }
            
        else return view('audit-none');
        
    }
    
    public function vote(){
        $voted = DB::table('tblvoteheader')
                ->join('tblmember', 'tblvoteheader.strVHMemId', '=', 'tblmember.strMemberId')
                ->get();
        
        return view('auditvote', ['voted' => $voted]);
    }
    
    public function view(Request $request){
        $votes = DB::table('tblvotedetail')
                ->join('tblcandidate', 'tblcandidate.strCandId', '=', 'tblvotedetail.strVDCandId')
                ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                ->join('tblposition', 'tblcandidate.strCandPosId', '=', 'tblposition.strPositionId')
                ->where('strVDVHCode', '=', $request->input('id'))
                ->get();
        $voted = DB::table('tblvoteheader')
                ->join('tblmember', 'tblvoteheader.strVHMemId', '=', 'tblmember.strMemberId')
                ->where('strVHCode', '=', $request->input('id'))
                ->get();
        
        return view('viewvote', ['votes' => $votes, 'voted'=>$voted]);
    }

}

