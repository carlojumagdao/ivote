<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\GenSet As GenSet;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class reportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tallyvotes()
    {
        $tally = DB::select('SELECT strCandID, strMemLName, strMemFName, txtCandPic, count(strVDCandId) as `votes` FROM tblcandidate 
join tblmember on strMemberId = strCandMemId
left join tblvotedetail on strCandId = strVDCandId
group by strVDCandID, strMemLName, txtCandPic
order by 5 desc;');
        $voted = DB::table('tblvoteheader')->count();
        $GenSet = GenSet::find(1);
    	$start = date_create($GenSet->datSetStart);
        $end = date_create($GenSet->datSetEnd);
        $nowNoTime = date_create(date("Y-m-d"));
        $now = date_create(date("Y-m-d H:i:s"));
        
        if($nowNoTime < $start) echo "the election is ongoing"; 
        else if($nowNoTime > $end) return view('Report.tallyvotes', ['tally'=>$tally, 'count'=>$voted] );
    	else echo "the election has not yet started";
    }
}
