<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LogInUserController extends Controller
{
    public function LogInUser(){
    	return view('LogInUser');
    }
}
