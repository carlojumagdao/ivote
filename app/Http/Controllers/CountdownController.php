<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GenSet AS GenSet;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CountdownController extends Controller
{
    public function Count(){
    	$GenSet = GenSet::find(1);
    	$start = date_create($GenSet->datSetStart);
        $nowNoTime = date_create(date("Y-m-d"));
        $now = date_create(date("Y-m-d H:i:s"));
        
        if(date_diff($nowNoTime, $start)->d == 0) return Redirect::route('voting.page');
        
    	$day = date_diff($now, $start);
        $sec = ($day->d * 24 * 3600) + ($day->h * 3600) + ($day->i * 60) + $day->s;
        //var_dump($start);
        //var_dump($now);
    	return view('Countdown', ['day'=> $sec, 'set'=> $GenSet]);
        
        
    }
}
