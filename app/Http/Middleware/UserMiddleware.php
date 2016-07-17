<?php

namespace App\Http\Middleware;
use DB;
use Closure;
use Redirect;
use Session;
use App\SurveyHeader AS SurveyHeader;


class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(Session::has('memid')){
            $memid = session('memid');
            $voted = DB::table('tblvoteheader')->where('strVHMemId', '=', $memid)->select('strVHCode')->get();
            if($voted){
                $SH = SurveyHeader::where('strSHMemCode', "=", $memid)->first();
                if($SH){
                    echo "voted and surveyed";
                }
                
                else return $next($request);
            }
            else{
                /*$member = DB::select('select CONCAT(strMemFname," ",strMemLname) as FullName, strMemberId, intMemSecQuesId, strMemSecQuesAnswer from tblMember where strMemPasscode = ?', [$request->input('txtPasscode')]);
                if($member){
                foreach ($member as $value) {
                    $retSecQues = $value->intMemSecQuesId;
                    $retAnswer = $value->strMemSecQuesAnswer;
                    $retMemId = $value->strMemberId;
                    $retFullName = $value->FullName;
                }
                session(['memid' => $retMemId, 'memfullname' => $retFullName]);*/
               
                return $next($request);
            }
            
        }
        else{
            
            $SecQues = $request->input('secques');
            $Answer = $request->input('txtAnswer');
            $member = DB::select('select CONCAT(strMemFname," ",strMemLname) as FullName, strMemberId, intMemSecQuesId, strMemSecQuesAnswer from tblMember where strMemPasscode = ?', [$request->input('txtPasscode')]);
            if($member){
                foreach ($member as $value) {
                    $retSecQues = $value->intMemSecQuesId;
                    $retAnswer = $value->strMemSecQuesAnswer;
                    $retMemId = $value->strMemberId;
                    $retFullName = $value->FullName;
                }
            
            } else{
                $errMess = "Authentication Failed";
                return Redirect::back()->withErrors($errMess);
            }
            if(($SecQues == $retSecQues) && ($Answer == $retAnswer)){
                session(['memid' => $retMemId, 'memfullname' => $retFullName]);
                $voted = DB::table('tblvoteheader')->where('strVHMemId', '=', $retMemId)->select('strVHCode')->get();
                if($voted){
                    $SH = SurveyHeader::where('strSHMemCode', "=", $retMemId)->first();
                    if($SH){
                        echo "voted and surveyed";
                    }
                    
                    else return Redirect::route('survey.answerSurvey');
                }
                else return $next($request);
            }else{
                $errMess = "Authentication Failed1";
                return Redirect::back()->withErrors($errMess);
            }
        }
          
    }
}
