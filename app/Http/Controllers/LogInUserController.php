<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\GenSet AS GenSet;

class LogInUserController extends Controller
{
    public function LogInUser(){
        $settings = GenSet::find(1);
        
    	return view('LogInUser', ['published'=>$settings->blSetPublish]);
    }
}
