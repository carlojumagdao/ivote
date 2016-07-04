<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PDF;
use App\element;

class PDFController extends Controller
{
    public function getPDF(){
    	$queryResult = element::all();
    	
    	$pdf=PDF::loadview('settings.pdfile',array('result'=>$queryResult));
    	return $pdf->stream('pdfile.pdf');
    	
    }
}
