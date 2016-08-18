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
use App\Audit AS Audit;

class auditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $audit=Audit::orderBy('Date', 'desc')->paginate(4);
        
        $first =  date_create($audit[0]->Date);
        $first = $first->format('Y-m-d');
        
        
        $html='<li class="time-label">
            <span class="bg-red">
                '.date("D, M. d Y", strtotime($first)) .'
                </span>
            </li>';
        
        foreach ($audit as $aud) {
            $date = date_create($aud->Date);
            $date = $date->format('Y-m-d');
            
            if($first != $date){
                $html.='<li class="time-label">
                    <span class="bg-red">
                    '.date("D, M. d Y", strtotime($aud->Date)) .'
                    </span>
                </li>';
                $first = date_create($aud->Date);
                $first = $first->format('Y-m-d');
            }
            
                $html.= "<li>";
                if($aud->Action == 'INSERTED') $html.= '<i class="fa fa-plus-square bg-yellow"></i>';
                else if($aud->Action == 'DELETED') $html.= '<i class="fa fa-trash bg-red"></i>';
                else $html.= '<i class="fa fa-edit bg-blue"></i>';
            
                $html.= '<div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i>'. date("h:i a", strtotime($aud->Date)) .' </span>
                
                <h3 class="timeline-header"><a href="#">'. $aud->user .'</a> '. $aud->Action .'  '. $aud->strMemberId . '</h3>';
                
                if($aud->Action == "UPDATED")
                 $html.= '<div class="timeline-body">'. $aud->oldValue .' updated to <big><strong>'. $aud->newValue .'</strong></big>
                </div>';
            
            
                $html.= '</li>';
        }
        if ($request->ajax()) {
            return $html;
        }
            return view('audit',compact('audit'));
    }
        
    
    
    public function load(Request $request){
        $limit = 5;
        $length = 5;
        $count = DB::table('tblaudit')->count();
        
        if($request->has('length'))
            if($request->input('length') <= ($count - 5)){
                $length = $request->input('length') + 5;
            }
        
        $audit = DB::select("SELECT user, strMemberId, tblaudit.Action, date(tblaudit.Date) as `date`, time(tblaudit.Date) as `time`, oldValue, newValue
from tblaudit order by date desc, time desc LIMIT ?;", [$length]);
        
        
        if($audit){
            $first =  $audit[0]->date;
            return view('audit', ['audit'=>$audit, 'first'=> $first, 'length'=>$length]);
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

