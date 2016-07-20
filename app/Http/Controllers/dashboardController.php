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
        $TotalVoter = DB::table('tblmember')->where('blMemDelete', '=', 0)->where('blMemCodeSendStat', '=', 1)->count();
        $TotalVoted = DB::table('tblvoteheader')->count();
        
        $Date = GenSet::find(1);
        $start = $Date->datSetStart;
        $end = $Date->datSetEnd;
        
        return view ('Dashboard.index', ['TotalPosition' => $TotalPosition, 'TotalCandidate' => $TotalCandidate, 'TotalVoter' => $TotalVoter, 'TotalVoted' => $TotalVoted, 'start'=>$start, 'end'=>$end]);

    }

    public function displayPosition()
    {
        $formDesign = DB::table('tblSetting')->select('strHeader','txtSetLogo','strSetElecName','strSetAddress')->get();
        foreach ($formDesign as $design) {
            $org = $design->strHeader;
            $logo = $design->txtSetLogo;
            $election = $design->strSetElecName;
            $address = $design->strSetAddress;
        }
        $Positions = DB::table('tblposition')->where('blPosDelete', '=', 0)->get();
        return view('Dashboard.position',['Positions' => $Positions,'org'=>$org, 'logo'=>$logo, 'election'=>$election, 'address'=>$address]);
    }

    public function displayCandidate()
    {
        $party = DB::table('tblSetting')->where('blSetParty', '=', 1)->get();
        $formDesign = DB::table('tblSetting')->select('strHeader','txtSetLogo','strSetElecName','strSetAddress')->get();
        foreach ($formDesign as $design) {
            $org = $design->strHeader;
            $logo = $design->txtSetLogo;
            $election = $design->strSetElecName;
            $address = $design->strSetAddress;
        }
        if($party){
            
            $partylist = DB::table('tblcandidate')
                            ->distinct()
                            ->join('tblparty', 'tblcandidate.intCandParId', '=', 'tblparty.intPartyId')
                            ->where('blCandDelete', '=', 0)
                            ->select('tblcandidate.intCandParId','tblparty.strPartyName', 'tblparty.strPartyColor')
                            ->get();
            $positions = DB::table('tblposition')->get();
            $candidates = DB::table('tblcandidate')
                            ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                            ->where('blCandDelete', '=', 0)
                            ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname')
                            ->get();
            //$election = DB::table('tblsetting')->get();
            return view('Dashboard.candidate', ['partylist'=>$partylist, 'positions'=>$positions, 'candidates'=>$candidates, 'org'=>$org, 'logo'=>$logo, 'election'=>$election, 'address'=>$address]);
            
            
        }
        
        else {
            $positions = DB::table('tblposition')->get();
            $candidates = DB::table('tblcandidate')
                            ->join('tblmember', 'tblcandidate.strCandMemId', '=', 'tblmember.strMemberId')
                            ->where('blCandDelete', '=', 0)
                            ->select('tblcandidate.*', 'tblmember.strMemFname', 'tblmember.strMemLname')
                            ->get();
            //$election = DB::table('tblsetting')->get();
            return view('Dashboard.candidate', [ 'positions'=>$positions, 'candidates'=>$candidates, 'org'=>$org, 'logo'=>$logo, 'election'=>$election, 'address'=>$address]);
        }
    }

    public function displayVoter()
    {

        $Members = DB::table('tblMember')->where('blMemDelete', '=', 0)->where('blMemCodeSendStat', '=', 1)->get();
        $formDesign = DB::table('tblSetting')->select('strHeader','txtSetLogo','strSetElecName','strSetAddress')->get();
        foreach ($formDesign as $design) {
            $org = $design->strHeader;
            $logo = $design->txtSetLogo;
            $election = $design->strSetElecName;
            $address = $design->strSetAddress;
        }
        return view('Dashboard.voter',['Members' => $Members,'org'=>$org, 'logo'=>$logo, 'election'=>$election, 'address'=>$address]);
    }

    public function displayVoted()
    {
        $formDesign = DB::table('tblSetting')->select('strHeader','txtSetLogo','strSetElecName','strSetAddress')->get();
        foreach ($formDesign as $design) {
            $org = $design->strHeader;
            $logo = $design->txtSetLogo;
            $election = $design->strSetElecName;
            $address = $design->strSetAddress;
        }
        $members = DB::table('tblvoteheader')
                            ->join('tblmember', 'tblvoteheader.strVHMemId', '=', 'tblmember.strMemberId')
                            ->select('tblvoteheader.*', 'tblmember.strMemFname', 'tblmember.strMemLname')
                            ->get();
        return view('Dashboard.voted', [ 'members'=>$members, 'org'=>$org, 'logo'=>$logo, 'election'=>$election, 'address'=>$address]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
