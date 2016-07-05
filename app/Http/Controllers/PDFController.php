<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PDF;
use App\GenSet;

class PDFController extends Controller
{
    public function getPDF(){
    	$queryResult = GenSet::all();
    	
    	$pdf=PDF::loadview('Settings.pdfile',array('result'=>$queryResult));
    	return $pdf->stream('pdfile.pdf');
    	
    }
}
