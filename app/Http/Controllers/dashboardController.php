<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\GenSet As GenSet;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class dashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $TotalPosition = DB::table('tblposition')->where('blPosDelete', '=', 0)->count();
        $TotalCandidate = DB::table('tblcandidate')->where('blCandDelete', '=', 0)->count();
        $TotalVoter = DB::table('tblmember')->where('blMemDelete', '=', 0)->count();
        $TotalVoted = DB::table('tblvoteheader')->count();
        $candno = DB::select('SELECT s.strPositionId, s.strPosName, count(c.strCandId) as Total, s.strPosColor
                            FROM tblposition AS s LEFT JOIN tblcandidate AS c
                                ON s.strPositionId = c.strCandPosId
                            WHERE blPosDelete = 0 AND blCandDelete = 0
                            GROUP by s.strPosName;');
        $Date = GenSet::find(1);
        $start = $Date->datSetStart;
        $end = $Date->datSetEnd;

        $DynFields = DB::select('SELECT intDynFieldId,strDynFieldName FROM 
                                tblDynamicField WHERE blDynStatus = 1');
        $FieldData = DB::select('SELECT distinct(m.strMemDeFieldData),count(m.strMemDeFieldData
                                ) AS Count, m.strMemDeFieldName, d.intDynFieldId FROM tblmemberdetail AS m
                                LEFT JOIN tbldynamicfield AS d
                                    ON m.strMemDeFieldName = d.strDynFieldName
                                LEFT JOIN tblmember as mr
                                    ON m.strMemDeMemId = mr.strMemberId
                                WHERE d.blDynStatus = 1 AND mr.blMemDelete = 0
                                GROUP BY 1
                                ORDER BY 3; ');
        
        return view ('Dashboard.index', ['TotalPosition' => $TotalPosition, 'TotalCandidate' => $TotalCandidate, 'TotalVoter' => $TotalVoter, 'TotalVoted' => $TotalVoted, 'start'=>$start, 'end'=>$end,'candno'=>$candno,'DynFields'=>$DynFields,'FieldData'=>$FieldData]);

    }
}
