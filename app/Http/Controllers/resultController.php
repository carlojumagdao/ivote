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
                            ->select('strCandPosId', 'strPosName', 'strPosColor')
                            ->where('blPosDelete', '=', '0')
                            ->distinct()
                            ->get();
        $tally = DB::select('SELECT strCandID, CONCAT(strMemFName," ",strMemLName) AS fullname, strCandPosId,
                            txtCandPic, count(strVDCandId) as `votes` FROM tblcandidate 
                            join tblmember on strMemberId = strCandMemId
                            left join tblvotedetail on strCandId = strVDCandId
                            where blCandDelete = 0
                            group by strVDCandID, strMemLName, txtCandPic
                            order by 5 desc;');
    	return view("partialresult", ['tally'=>$tally, 'positions'=>$positions]);
    }
}
