<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GenSet AS GenSet;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CountdownController extends Controller
{
    public function Count(){
    	$GenSet = GenSet::find(1);
    	$start = date_create( $GenSet->datSetStart);
    	$end = date_create($GenSet->datSetEnd);
    	$day = date_diff($start, $end);
    	return view('Countdown', ['day'=>$day->days]);
    }
}
