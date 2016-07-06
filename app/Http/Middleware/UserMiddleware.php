<?php

namespace App\Http\Middleware;
use DB;
use Closure;
use Redirect;

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
            return $next($request);
        }else{
            $errMess = "Authentication Failed";
            return Redirect::back()->withErrors($errMess);
        }   
    }
}
