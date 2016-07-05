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
    	foreach($queryResult as $result) {
            $Head = $result->strHeader;
            $Picture = $result->txtSetLogo;
        }
    	
    	$pdf=PDF::loadview('Settings.pdfile',array('strHeader'=>$Head, 'txtSetLogo'=>$Picture));
    	return $pdf->stream('pdfile.pdf');
    	
    }
}
