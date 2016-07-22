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

class auditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $audit = DB::select("SELECT user, strMemberId, tblaudit.Action, date(tblaudit.Date) as `date`, time(tblaudit.Date) as `time`
from tblaudit;");
        
        
        if($audit){
            $first =  $audit[0]->date;
            return view('audit', ['audit'=>$audit, 'first'=> $first]);
        }
            
        else return view('audit-none');
        
    }

}

