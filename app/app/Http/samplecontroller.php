<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PDF;
use App\GenSet;

/*require 'fpdf/fpdf.php';*/
use App\fpdf.php;
// DB parameters
$host = "localhost"; 
$user = "username"; 
$pass = "password";
$db = "db"; 

// Create fpdf object
$pdf = new FPDF('P', 'pt', 'Letter');

// Add a new page to the document
$pdf->addPage();

// Try to connect to DB
$r = mysql_connect($host, $user, $pass);
if (!$r) {
    echo "Could not connect to server\n";
    trigger_error(mysql_error(), E_USER_ERROR);
} else {
    echo "Connection established\n"; 
}

// Try to select the database
$r2 = mysql_select_db($db);
if (!$r2) {
    echo "Cannot select database\n";
    trigger_error(mysql_error(), E_USER_ERROR); 
} else {
    echo "Database selected\n";
}

// Try to execute the query
$query = "SELECT * FROM images";
$rs = mysql_query($query);
if (!$rs) {
    echo "Could not execute query: $query";
    trigger_error(mysql_error(), E_USER_ERROR); 
} else {
    echo "Query: $query executed\n";
} 

while ($row = mysql_fetch_assoc($rs)) {
    // Get the image from each row
    $url = $row['url'];

    // Place the image in the pdf document
    $pdf->Image($url);
}

// Close the db connection
mysql_close();

// Close the document and save to the filesystem with the name images.pdf
$pdf->Output('images.pdf','F');