<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PDF;
use DB;
use App\GenSet;

class PDFController extends Controller
{
    public function getPDF(){
    	$queryResult = GenSet::all();
    	foreach($queryResult as $result) {
            $Head = $result->strHeader;
            $Picture = $result->txtSetLogo;
            $Address = $result->strSetAddress;
        }
    	$tally = DB::select('SELECT strCandID, strMemLName, strMemFName, txtCandPic, count(strVDCandId) as `votes` FROM tblcandidate 
join tblmember on strMemberId = strCandMemId
left join tblvotedetail on strCandId = strVDCandId
group by strVDCandID, strMemLName, txtCandPic
order by 5 desc;');
        $voted = DB::table('tblvoteheader')->count();
    	$pdf=PDF::loadview('Settings.pdfile',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture, 'strAddress'=>$Address, 'tally'=> $tally, 'count'=>$voted));
    	return $pdf->stream('pdfile.pdf');
    	
    }
}
