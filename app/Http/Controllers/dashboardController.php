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
        
        $Date = GenSet::find(1);
        $start = $Date->datSetStart;
        $end = $Date->datSetEnd;
        
        return view ('Dashboard.index', ['TotalPosition' => $TotalPosition, 'TotalCandidate' => $TotalCandidate, 'TotalVoter' => $TotalVoter, 'TotalVoted' => $TotalVoted, 'start'=>$start, 'end'=>$end]);

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
