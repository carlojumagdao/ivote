<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class resultController extends Controller
{
    public function index(){
    	$positions = DB::table('tblcandidate')
                            ->join('tblposition', 'strPositionId', '=', 'strCandPosId')
                            ->select('strCandPosId', 'strPosName', 'strPosColor', 'strPositionId')
                            ->where('blPosDelete', '=', '0')
                            ->distinct()
                            ->get();
        // no. of candidate for each position
        $candno = DB::select('SELECT s.strPositionId, s.strPosName, count(c.strCandId) as Total
				        	FROM tblposition AS s LEFT JOIN tblcandidate AS c
				        		ON s.strPositionId = c.strCandPosId
				            WHERE blPosDelete = 0 AND blCandDelete = 0
				            GROUP by s.strPosName;');
        $tally = DB::select('SELECT strCandID, CONCAT(strMemFName," ",strMemLName) AS 
        					fullname, strCandPosId, txtCandPic, count(strVDCandId) as `votes`, strPartyColor
        					FROM tblcandidate 
                            join tblmember on strMemberId = strCandMemId
                            left join tblvotedetail on strCandId = strVDCandId
                            left join tblparty on intCandParId = intPartyid
                            where blCandDelete = 0
                            group by strVDCandID, strMemLName, txtCandPic
                            order by 5 desc;');
    	return view("partialresult", ['tally'=>$tally, 'positions'=>$positions,'candno'=>$candno]);
    }
    public function surveyindex(){
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
    	return view("surveypartial", ['SurveyTally'=>$SurveyTally, 'SurveyQuestions'=>$SurveyQuestions]);
    }
}
