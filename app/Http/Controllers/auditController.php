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
        
        
        
        if($audit->currentPage() == 1){
            session(['first'=>$first]);
        
        $html='<li class="time-label">
            <span class="bg-red">
                '.date("D, M. d Y", strtotime($first)) .'
                </span>
            </li>';
        }
        else $html = "";
        
        foreach ($audit as $aud) {
            $date = date_create($aud->Date);
            $date = $date->format('Y-m-d');
            
            if(session()->get('first') != $date){
                $html.='<li class="time-label">
                    <span class="bg-red">
                    '.date("D, M. d Y", strtotime($aud->Date)) .'
                    </span>
                </li>';
                $first = date_create($aud->Date);
                $first = $first->format('Y-m-d');
                session()->forget('first');
                session(['first'=>$first]);
            }
            
                $html.= "<li>";
                if($aud->Action == 'INSERTED') 
                    $html.= '<i class="fa fa-plus-square bg-orange"></i>';
                else if($aud->Action == 'DELETED') 
                    $html.= '<i class="fa fa-trash bg-red"></i>';
                else if($aud->Action == "SENT PASSCODE") 
                    $html.='<i class ="fa fa-envelope-o bg-purple"></i>';
                else if($aud->Action == "RESTORED")
                    $html.='<i class ="fa fa-recycle bg-green"></i>';
                else 
                    $html.= '<i class="fa fa-edit bg-blue"></i>';
            
                if($aud->Action == 'UPDATED')
                {
                    $html.= '<div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i>'. date("h:i a", strtotime($aud->Date)) .' </span>

                    <h3 class="timeline-header"><a href="#">'. $aud->user .'</a> <label style="color:blue">'. $aud->Action .'</label> '. $aud->type.' '. $aud->strMemberId .' <strong>'. $aud->fullname .'</strong>' .'</h3>';
                            
                    // if($aud->Action == "UPDATED")
                            $html.= '<div class="timeline-body">'.'from '. $aud->oldValue .' updated to <big><strong>'. $aud->newValue .'</strong></big>
                    </div>';
                }
                else if($aud->Action == 'DELETED')
                {
                     $html.= '<div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i>'. date("h:i a", strtotime($aud->Date)) .' </span>

                        <h3 class="timeline-header"><a href="#">'. $aud->user .'</a> <label style="color:red">'. $aud->Action .'</label> '. $aud->type.' '. $aud->strMemberId .' <strong>'. $aud->fullname .'</strong>' .'</h3>';
                }
                else if($aud->Action == 'INSERTED')
                {
                    $html.= '<div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i>'. date("h:i a", strtotime($aud->Date)) .' </span>

                    <h3 class="timeline-header"><a href="#">'. $aud->user .'</a> <label style="color:orange">'. $aud->Action .'</label> '. $aud->type.' '. $aud->strMemberId .' <strong>'. $aud->fullname .'</strong>' .'</h3>';
                }
                else if($aud->Action =='RESTORED')
                {
                    $html.= '<div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i>'. date("h:i a", strtotime($aud->Date)) .' </span>

                    <h3 class="timeline-header"><a href="#">'. $aud->user .'</a> <label style="color:green">'. $aud->Action .'</label> '. $aud->type.' '. $aud->strMemberId .' <strong>'. $aud->fullname .'</strong>' .'</h3>';
                }
                else if($aud->Action == 'SENT PASSCODE')
                {
                    $html.= '<div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i>'. date("h:i a", strtotime($aud->Date)) .' </span>

                    <h3 class="timeline-header"><a href="#">'. $aud->user .'</a> has <label style="color:purple">'. $aud->Action .'</label> to '. $aud->type.' '. $aud->strMemberId .' <strong>'. $aud->fullname .'</strong>' .'</h3>';
                    }
            
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
    
    public function survey(){
        $survey = DB::table('tblsurveyheader')
                ->join('tblmember', 'tblsurveyheader.strSHMemCode', '=', 'tblmember.strMemberId')
                ->get();
        
        return view('auditsurvey', ['survey' => $survey]);
    }
    
    public function viewsurvey(Request $request){
        $answers = DB::table('tblsurveydetail')
                ->join('tblsurveyquestion', 'tblsurveyquestion.intSQId', '=', 'tblsurveydetail.intSDSQId')
                ->join('tblsurveyheader', 'tblsurveyheader.intSHId', '=', 'tblsurveydetail.intSDSHId')
                ->where('intSDSHId', '=', $request->input('id'))
                ->get();
        $surveyed = DB::table('tblsurveyheader')
                ->join('tblmember', 'tblsurveyheader.strSHMemCode', '=', 'tblmember.strMemberId')
                ->where('intSHId', '=', $request->input('id'))
                ->get();
        
        return view('viewsurvey', ['answers' => $answers, 'surveyed'=>$surveyed]);
    }

}

